<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentSubjectClassImport;
use App\Models\Student;
use App\Models\StudentSubjectClass;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentSubjectClassRequest;
use App\Models\SubjectClass;
use App\Exports\StudentSubjectClassExport;
use App\Models\Score;
use App\Models\SubjectScoreType;
use Carbon\Carbon;
use App\Exports\EligibleStudentsExport;
use Maatwebsite\Excel\Facades\Excel;
class StudentSubjectClassController extends Controller
{
    public function index($id)
    {
        $studentSubjectClasses = StudentSubjectClass::getStudentSubClass($id);
        foreach ($studentSubjectClasses as $studentSubjectClass) {
            $studentSubjectClass->save();
        }

        $subjectClass = SubjectClass::findSubjectClassById($id);
        $scoreTypes = SubjectScoreType::getScoreTypesForSubjectClass($subjectClass->subject_id);

        $students = StudentSubjectClass::where('subject_class_id', $subjectClass->id)->with('student')->get();
        $attendanceStats = $this->getAttendanceStats($subjectClass);
        $attendanceHistory = $this->getAttendanceHistory($subjectClass);

        $today = now();
        $isBeforeStart = $subjectClass->start_date > $today;

        return view('admin.studentsubjectclass.index', [
            'studentSubjectClasses' => $studentSubjectClasses,
            'subjectClass' => $subjectClass,
            'isBeforeStart' => $isBeforeStart,
            'scoreTypes' => $scoreTypes,
            'students' => $students,
            'attendanceStats' => $attendanceStats,
            'attendanceHistory' => $attendanceHistory
        ]);
    }

    public function edit($id)
    {
        $studentSubClass = StudentSubjectClass::with(['scores', 'subjectClass.subject.subjectScoreTypes.scoreType'])->findOrFail($id);

        $profile = $studentSubClass->student;
        $subjectScoreTypes = $studentSubClass->subjectClass->subject->subjectScoreTypes;

        return view('admin.studentsubjectclass.edit', [
            'editstudentsubjectclass' => $studentSubClass,
            'student' => $profile,
            'subjectScoreTypes' => $subjectScoreTypes,
        ]);
    }




    public function update(StudentSubjectClassRequest $request, $id)
    {
        $scores = $request->input('scores');

        foreach ($scores as $subjectScoreTypeId => $scoreValue) {
            Score::updateOrCreate(
                [
                    'student_subject_class_id' => $id,
                    'subject_score_type_id' => $subjectScoreTypeId,
                ],
                ['score' => $scoreValue]
            );
        }

        toastr()->success('Cập nhật thành công điểm.');
        return redirect()->route('admin.studentsubjectclass.index', $id);
    }


    public function destroy() {}

    public function export($id)
    {
        $subjectClass = SubjectClass::findOrFail($id);
        $subjectClassName = $subjectClass->name;
        $day = now()->format('y-m-d');
        $fileName = 'Bang_diem_lop_' . $subjectClassName . '_' . $day . '.xlsx';
        return Excel::download(new StudentSubjectClassExport($subjectClassName, $id), $fileName);
    }

    public function import(Request $request, $subjectClassId)
    {
        // Tìm lớp môn dựa trên id
        $subjectClass = SubjectClass::findOrFail($subjectClassId);

        // Kiểm tra nếu có file được upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            try {
                // Import file và truyền SubjectClass
                $import = new StudentSubjectClassImport($subjectClass);
                Excel::import($import, $file);

                // Kiểm tra lỗi trong quá trình import
                $errors = $import->getErrors();
                if (!empty($errors)) {
                    toastr()->error('Có lỗi trong quá trình nhập dữ liệu:<br>' . implode('<br>', $errors));
                    return back();
                }

                toastr()->success('Nhập điểm thành công!');
                return back();
            } catch (\Throwable $e) {
                // Xử lý ngoại lệ
                toastr()->error('Có lỗi xảy ra: ' . $e->getMessage());
                return back();
            }
        }

        toastr()->error('Vui lòng tải lên file Excel');
        return back();
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

                return [
                    'student_code' => $student->student->code,
                    'student_name' => $student->student->full_name,
                    'present_count' => $presentCount,
                    'absent_count' => $absentCount,
                    'absence_rate' => $absenceRate,
                ];
            });

        $averageAbsenceRate = $studentStats->avg('absence_rate');

        return [
            'total_sessions' => $totalSessions,
            'total_sessions_held' => $totalSessionsHeld,
            'student_stats' => $studentStats,
            'average_absence_rate' => $averageAbsenceRate,
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

    public function exportEligible($id)
    {
        $subjectClass = SubjectClass::findOrFail($id);

        $subjectClassName = $subjectClass->name;
        $day = now()->format('y-m-d');
        $fileName = 'DSSV_đủ_điều_kiện_thi_lớp_' . $subjectClassName . '_' . $day . '.xlsx';

        // Lấy dữ liệu điểm danh
        $attendanceStats = $this->getAttendanceStats($subjectClass);

        $lowAttendanceStudents = $attendanceStats['student_stats']->filter(function ($stat) {
            return $stat['absence_rate'] < 20;
        });

        // Chuẩn bị dữ liệu cho file Excel
        $exportData = $lowAttendanceStudents->map(function ($student, $index) {
            return [
                'STT' => $index + 1,
                'Mã sinh viên' => $student['student_code'],
                'Họ và tên' => $student['student_name'],
                'Số buổi vắng' => $student['absent_count'],
                'Tỷ lệ vắng (%)' => $student['absence_rate'],
            ];
        })->toArray();

        // Xuất file Excel
        return Excel::download(new EligibleStudentsExport($exportData, $subjectClassName), $fileName);
    }
}
