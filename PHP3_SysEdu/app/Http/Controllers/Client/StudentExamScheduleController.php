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

        $timeRange = $request->get('time_range', '7 days ahead');
        $startDate = now();
        $endDate = now();

        switch ($timeRange) {
            case '7 days ahead':
                $endDate = now()->addDays(7);
                break;
            case '14 days ahead':
                $endDate = now()->addDays(14);
                break;
            case '30 days ahead':
                $endDate = now()->addDays(30);
                break;
            case '60 days ahead':
                $endDate = now()->addDays(60);
                break;
            case '90 days ahead':
                $endDate = now()->addDays(90);
                break;
            case '7 days before':
                $startDate = now()->subDays(7);
                break;
            case '14 days before':
                $startDate = now()->subDays(14);
                break;
            case '30 days before':
                $startDate = now()->subDays(30);
                break;
            case '60 days before':
                $startDate = now()->subDays(60);
                break;
            case '90 days before':
                $startDate = now()->subDays(90);
                break;
        }

        $examStudents = ExamStudent::where('student_id', $studentId)
        ->join('exam_schedules', 'exam_students.exam_schedule_id', '=', 'exam_schedules.id')
        ->join('schedules', 'exam_schedules.schedule_id', '=', 'schedules.id')
        ->whereBetween('schedules.date', [$startDate, $endDate])
        ->with(['examSchedule.schedule', 'examSchedule.schedule.subjectClass'])
        ->orderBy('schedules.date', 'asc') // Sắp xếp theo cột date trong bảng schedules
        ->paginate(10);

        return view('client.exam-schedule', compact('examStudents', 'timeRange'));
    }

}
