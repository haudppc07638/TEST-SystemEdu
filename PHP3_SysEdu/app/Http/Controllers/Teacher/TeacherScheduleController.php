<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = Auth::guard('employee')->user();
        $schedules = Schedule::getSchedulesByTeacher($teacher->id);

        return view('teacher.schedule.index', compact('teacher', 'schedules'));
    }

    public function filter(Request $request)
    {
        $teacher = Auth::guard('employee')->user();

        $subjectClassId = $request->input('subject_class_id');
        $date = $request->input('date');
        $schedules = Schedule::getSchedulesByTeacher($teacher->id, $subjectClassId, $date);

        return view('teacher.schedule._schedule_table', compact('schedules'))->render();
    }
}
