<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TeacherExamScheduleController extends Controller
{
    /**
     * Hiển thị danh sách lịch gác thi cho giáo viên.
     */
    public function index()
    {
        // Lấy thông tin giáo viên đã đăng nhập
        $teacher = Auth::guard('employee')->user();
        $today = Carbon::today(); // Lấy ngày hiện tại

        // Lấy danh sách lịch gác thi của giáo viên, cả teacher_1 và teacher_2
        $examSchedules = ExamSchedule::where(function ($query) use ($teacher) {
                // Lọc theo giáo viên là teacher_1 hoặc teacher_2
                $query->where('exam_schedules.teacher_1', $teacher->id)
                      ->orWhere('exam_schedules.teacher_2', $teacher->id);
            })
            ->join('schedules', 'exam_schedules.schedule_id', '=', 'schedules.id') // Kết nối với bảng schedules
            ->where('schedules.date', '>=', $today) // Chỉ lấy lịch từ hôm nay trở đi
            ->with(['schedule.subjectClass', 'schedule.timeSlot', 'schedule.classroom']) // Quan hệ liên quan
            ->orderBy('schedules.date', 'asc') // Sắp xếp theo ngày
            ->paginate(10);

        // Trả về view hiển thị lịch gác thi
        return view('teacher.exam_schedules.index', compact('teacher', 'examSchedules'));
    }

    /**
     * Lọc lịch gác thi theo lớp môn hoặc ngày.
     */
    public function filter(Request $request)
    {
        // Lấy thông tin giáo viên đã đăng nhập
        $teacher = Auth::guard('employee')->user();

        // Lấy các tham số từ request
        $subjectClassId = $request->input('subject_class_id');
        $date = $request->input('date');

        // Lọc danh sách lịch gác thi của giáo viên
        $examSchedules = ExamSchedule::where(function ($query) use ($teacher) {
                // Lọc theo giáo viên là teacher_1 hoặc teacher_2
                $query->where('exam_schedules.teacher_1', $teacher->id)
                      ->orWhere('exam_schedules.teacher_2', $teacher->id);
            })
            ->join('schedules', 'exam_schedules.schedule_id', '=', 'schedules.id')
            ->when($subjectClassId, function ($query) use ($subjectClassId) {
                $query->where('schedules.subject_class_id', $subjectClassId);
            })
            ->when($date, function ($query) use ($date) {
                $query->whereDate('schedules.date', $date);
            })
            ->with(['schedule.subjectClass', 'schedule.timeSlot', 'schedule.classroom'])
            ->orderBy('schedules.date', 'asc')
            ->paginate(10);

        // Trả về bảng HTML với lịch gác thi đã lọc
        return view('teacher.exam_schedules._schedule_table', compact('examSchedules'))->render();
    }
}
