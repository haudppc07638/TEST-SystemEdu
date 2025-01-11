<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ExamStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamSchedule;
use Carbon\Carbon;

class StudentExamScheduleController extends Controller
{
    public function index(Request $request)
    {
        // Lấy thông tin học sinh đã đăng nhập - Haudp
        $studentId = Auth::guard('student')->user()->id;

        $examStudents = ExamStudent::where('student_id', $studentId)
        ->join('exam_schedules', 'exam_students.exam_schedule_id', '=', 'exam_schedules.id')
        ->join('schedules', 'exam_schedules.schedule_id', '=', 'schedules.id')
        ->with(['examSchedule.schedule', 'examSchedule.schedule.subjectClass'])
        ->orderBy('schedules.date', 'asc') // Sắp xếp theo cột date trong bảng schedules
        ->paginate(10);

        return view('client.exam-schedule', compact('examStudents'));
    }

}
