<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScheduleRequest;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\SubjectClass;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function create()
    {
        $subjectClasses = SubjectClass::all();
        $timeSlots = TimeSlot::all();
        $classrooms = Classroom::all();

        $dates = SubjectClass::getAllDates();

        return view('admin.schedules.create', compact('subjectClasses', 'timeSlots', 'classrooms', 'dates'));
    }

    public function store(ScheduleRequest $request)
    {
        $validator = Validator::make(
            $request->only([
                'time_slot_id',
                'classroom_id',
                'subject_class_id',
                'start_date',
                'end_date',
                'schedule_type',
            ]),
            $request->rules(),
            $request->messages()
        );

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Log::info('Data from request: ', $request->all());

        Schedule::createSchedule($request->all(), $request->schedule_type);

        toastr()->success('Tạo lịch tự động thành công.');
        return redirect()->route('admin.schedules.index');
    }

    public function index()
    {
        $schedules = Schedule::getPaginatedSchedules();
        return view('admin.schedules.index', compact('schedules'));
    }
}

