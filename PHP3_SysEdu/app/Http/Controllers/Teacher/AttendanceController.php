<?php

namespace App\Http\Controllers\Teacher;

use App\Exports\ExamListExport;
use App\Exports\StudentSubjectClassExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\AttendanceRequest;
use App\Imports\StudentSubjectClassImport;
use App\Models\Schedule;
use App\Models\SubjectClass;
use App\Models\Attendance;
use App\Models\Score;
use App\Models\StudentSubjectClass;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function classList()
    {
        $teacher = Auth::guard('employee')->user();
        $today = Carbon::today();

        $currentClasses = SubjectClass::where('employee_id', $teacher->id)
            ->with(['subject', 'schedules', 'studentSubjectClasses'])
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        $pastClasses = SubjectClass::where('employee_id', $teacher->id)
            ->with(['subject', 'schedules', 'studentSubjectClasses'])
            ->where('end_date', '<', $today)
            ->paginate(10);

        return view('teacher.attendance.classList', compact('currentClasses', 'pastClasses'));
    }

    public function classDetail(SubjectClass $subjectClass)
    {
        $date = request('date', Carbon::today()->format('Y-m-d'));

        $attendanceStats = $this->getAttendanceStats($subjectClass);
        $attendanceHistory = $this->getAttendanceHistory($subjectClass);

        $students = StudentSubjectClass::where('subject_class_id', $subjectClass->id)->with('student')->get();

        foreach ($students as $studentSubjectClass) {
            $studentSubjectClass->calculateTotalScore();
            $studentSubjectClass->save();
        }

        $grades = Score::whereHas('studentSubjectClass', function ($query) use ($subjectClass) {
            $query->where('subject_class_id', $subjectClass->id);
        })->with('studentSubjectClass.student')->get();
        return view('teacher.attendance.classDetail', compact('subjectClass', 'attendanceStats', 'attendanceHistory', 'students', 'grades', 'date'));
    }

    public function takeAttendance(SubjectClass $subjectClass)
    {
        $date = request('date', Carbon::today()->format('Y-m-d'));

        if (Carbon::parse($date)->isFuture()) {
            return back()->with('error', 'Ngày điểm danh không thể là ngày trong tương lai!');
        }

        $schedule = $subjectClass->schedules()
            ->whereDate('date', $date)
            ->first();

        if (!$schedule) {
            return back()->with('error', 'Không có lịch học vào ngày này!');
        }

        $scheduleData = Schedule::getScheduleWithStudents($schedule->id, $date);

        return view('teacher.attendance.takeAttendance', compact('scheduleData', 'date', 'subjectClass'));
    }

    public function store(AttendanceRequest $request, SubjectClass $subjectClass)
    {
        $validated = $request->validated();

        $attendance = array_map(function ($value) {
            return $value === "on";
        }, $validated['attendance']);

        $studentSubjectClassIds = array_keys($attendance);

        Attendance::markAttendanceForClass(
            $studentSubjectClassIds,
            $validated['date'],
            $attendance
        );
        toastr()->success('Điểm danh đã được cập nhật');
        return redirect()->route('attendance.take', $subjectClass->id);
    }

    private function getAttendanceStats(SubjectClass $subjectClass)
    {
        $totalSessions = $subjectClass->schedules()
            ->distinct()
            ->count('date');

        $totalSessionsHeld = $subjectClass->schedules()
            ->where('date', '<=', Carbon::today())
            ->count();

        $studentStats = $subjectClass->studentSubjectClasses()
            ->with(['student', 'attendances'])
            ->get()
            ->map(function ($student) use ($totalSessions) {
                $presentCount = $student->attendances->where('status', 1)->count();
                $absentCount = $student->attendances->where('status', 0)->count();

                $absenceRate = $totalSessions > 0
                    ? round(($absentCount / $totalSessions) * 100, 2)
                    : 0;

                $status = '';
                if ($absenceRate > 20) {
                    $status = 'Fail';
                } elseif ($absenceRate > 10) {
                    $status = 'Cảnh báo';
                } else {
                    $status = 'Tốt';
                }

                return [
                    'student_code' => $student->student->code,
                    'student_name' => $student->student->full_name,
                    'present_count' => $presentCount,
                    'absent_count' => $absentCount,
                    'absence_rate' => $absenceRate,
                    'status' => $status
                ];
            });

        $averageAbsenceRate = $studentStats->avg('absence_rate');
        $warningCount = $studentStats->filter(function ($stat) {
            return $stat['absence_rate'] > 20;
        })->count();

        return [
            'total_sessions' => $totalSessions,
            'total_sessions_held' => $totalSessionsHeld,
            'student_stats' => $studentStats,
            'average_absence_rate' => $averageAbsenceRate,
            'warning_count' => $warningCount
        ];
    }

    private function getAttendanceHistory(SubjectClass $subjectClass)
    {
        $schedules = $subjectClass->schedules()->with('attendances')->get();

        $attendanceHistory = [];

        foreach ($schedules as $schedule) {
            foreach ($schedule->attendances as $attendance) {
                $attendanceHistory[] = [
                    'date' => $schedule->date,
                    'studentSubjectClass' => $attendance->studentSubjectClass,
                    'status' => $attendance->status
                ];
            }
        }

        return collect($attendanceHistory)->sortByDesc('date');
    }

    public function exportGrades(SubjectClass $subjectClass)
    {
        $subjectClassName = $subjectClass->name;
        $day = now()->format('y-m-d');
        $fileName = 'Bang_diem_' . $subjectClassName . '_' . $day . '.xlsx';
        return Excel::download(new StudentSubjectClassExport($subjectClassName, $subjectClass->id), $fileName);
    }

    public function importGrades(Request $request, SubjectClass $subjectClass)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            try {
                $import = new StudentSubjectClassImport($subjectClass);
                Excel::import($import, $file);

                $errors = $import->getErrors();
                if (!empty($errors)) {
                    toastr()->error('Có lỗi trong quá trình nhập dữ liệu:<br>' . implode('<br>', $errors));
                    return back();
                }

                toastr()->success('Nhập điểm thành công!');
                return back();
            } catch (\Throwable $e) {
                toastr()->error('Có lỗi xảy ra: ' . $e->getMessage());
                return back();
            }
        }

        toastr()->error('Vui lòng tải lên file Excel');
        return back();
    }

    // public function exportExamList(SubjectClass $subjectClass)
    // {
    //     return Excel::download(new ExamListExport($subjectClass->id), 'Danh_sach_sinh_vien_thi.xlsx');
    // }
}
