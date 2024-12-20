<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExamScheduleRequest;
use App\Models\Employee;
use App\Models\ExamSchedule;
use App\Models\ExamStudent;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\SubjectClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExamScheduleController extends Controller
{
    public function index(Request $request)
    {
        $subjectClassId = $request->get('subject_class_id');

        $subjectClass = SubjectClass::findOrFail($subjectClassId);
        $examSchedules = ExamSchedule::whereHas('schedule', function ($query) use ($subjectClassId) {
            $query->where('subject_class_id', $subjectClassId);
        })->with(['schedule', 'students'])->paginate(10);

        return view('admin.exam_schedules.index', compact('examSchedules', 'subjectClassId', 'subjectClass'));
    }

    public function show($examScheduleId)
    {
        $examSchedule = ExamSchedule::with(['students.student', 'schedule'])->findOrFail($examScheduleId);

        return view('admin.exam_schedules.show', compact('examSchedule'));
    }

    public function create(Request $request)
    {
        $subjectClassId = $request->get('subject_class_id');

        $subjectClass = SubjectClass::findOrFail($subjectClassId);
        $lastThreeSchedules = Schedule::where('subject_class_id', $subjectClassId)
            ->orderBy('date', 'desc')
            ->take(3)
            ->get();

        $allDaysHaveExams = $lastThreeSchedules->every(function ($schedule) {
            return $schedule->examSchedule()->exists();
        });

        if ($allDaysHaveExams) {
            toastr()->error('Lớp môn đã đủ lịch thi hoặc chưa có lịch học.');
            return redirect()->back();
        }

        $lastSchedules = $lastThreeSchedules->filter(function ($schedule) {
            return !$schedule->examSchedule()->exists();
        });

        $examStudentIds = ExamSchedule::whereIn('schedule_id', $lastThreeSchedules->pluck('id'))
            ->with('students')
            ->get()
            ->pluck('students.*.id')
            ->flatten()
            ->unique();

        $students = Student::whereHas('studentSubjectClasses', function ($query) use ($subjectClassId) {
            $query->where('subject_class_id', $subjectClassId);
        })
            ->whereNotIn('id', $examStudentIds)
            ->get();

        $teachers = Employee::all(['id', 'full_name', 'code']);

        return view('admin.exam_schedules.create', compact('lastSchedules', 'students', 'subjectClassId', 'teachers', 'subjectClass'));
    }


    public function store(ExamScheduleRequest $request)
    {
        $teacher1 = $request->teacher_1;
        $teacher2 = $request->teacher_2;

        if ($teacher1 === $teacher2) {
            return back()->withErrors(['teacher_2' => 'Giám thị 1 và Giám thị 2 không được trùng nhau.'])->withInput();
        }

        $scheduleId = $request->schedule_id;
        $selectedSchedule = Schedule::findOrFail($scheduleId);

        $conflictingTeacher = ExamSchedule::whereHas('schedule', function ($query) use ($selectedSchedule) {
            $query->where('date', $selectedSchedule->date)
                ->where('time_slot_id', $selectedSchedule->time_slot_id);
        })->where(function ($query) use ($teacher1, $teacher2) {
            $query->where('teacher_1', $teacher1)
                ->orWhere('teacher_1', $teacher2)
                ->orWhere('teacher_2', $teacher1)
                ->orWhere('teacher_2', $teacher2);
        })->exists();

        if ($conflictingTeacher) {
            return back()->withErrors(['teacher_1' => 'Giáo viên được chọn đã có lịch thi trong ngày và khung giờ này.'])->withInput();
        }

        // Tạo lịch thi
        $examSchedule = ExamSchedule::create([
            'schedule_id' => $scheduleId,
            'teacher_1' => $teacher1,
            'teacher_2' => $teacher2,
        ]);

        foreach ($request->student_ids as $studentId) {
            ExamStudent::create([
                'exam_schedule_id' => $examSchedule->id,
                'student_id' => $studentId,
            ]);
        }

        toastr()->success('Tạo lịch thi thành công.');
        return redirect()->route('admin.examschedules.index', ['subject_class_id' => $request->subject_class_id]);
    }

    public function edit($id)
    {
        $examSchedule = ExamSchedule::with(['schedule', 'students'])->findOrFail($id);
        $subjectClassId = $examSchedule->schedule->subject_class_id;

        $students = Student::whereHas('studentSubjectClasses', function ($query) use ($subjectClassId) {
            $query->where('subject_class_id', $subjectClassId);
        })->get();

        return view('admin.exam_schedules.edit', compact('examSchedule', 'students'));
    }

    public function update(ExamScheduleRequest $request, $id)
    {
        $examSchedule = ExamSchedule::findOrFail($id);

        $examSchedule->update([
            'teacher_1' => $request->teacher_1,
            'teacher_2' => $request->teacher_2,
        ]);

        ExamStudent::where('exam_schedule_id', $examSchedule->id)->delete();
        foreach ($request->student_ids as $studentId) {
            ExamStudent::create([
                'exam_schedule_id' => $examSchedule->id,
                'student_id' => $studentId,
            ]);
        }

        toastr()->success('Cập nhật lịch thi thành công.');
        return redirect()->route('admin.exam_schedules.index', ['subject_class_id' => $examSchedule->schedule->subject_class_id]);
    }
}
