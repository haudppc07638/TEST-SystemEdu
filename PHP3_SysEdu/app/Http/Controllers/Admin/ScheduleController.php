<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScheduleRequest;
use App\Http\Requests\Admin\UpdateScheduleRequest;
use App\Models\Classroom;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\SubjectClass;
use App\Models\TeacherFreeSlot;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function create(Request $request)
    {
        $subjectClassId = $request->get('subject_class_id');
        $subjectClass = SubjectClass::findOrFail($subjectClassId);
        $employeeId = $subjectClass->employee_id;
    
        $teacherFreeSlots = TeacherFreeSlot::where('employee_id', $employeeId)->pluck('time_slot_id')->toArray();
        if (!empty($teacherFreeSlots)) {
            $timeSlots = TimeSlot::whereIn('id', $teacherFreeSlots)->get();
        } else {
            $timeSlots = TimeSlot::all();
        }
    
        $classrooms = Classroom::all();
    
        return view('admin.schedules.create', compact('subjectClass', 'timeSlots', 'classrooms'));
    }
    


    public function store(ScheduleRequest $request)
    {
        // dd($request->days);
        $daysOfWeek = $request->input('days_of_week', []);
        $validator = Validator::make(
            $request->only([
                'time_slot_id',
                'classroom_id',
                'subject_class_id',
                'start_date',
                'end_date',
                'days_of_week',
            ]),
            $request->rules(),
            $request->messages()
        );
        Log::info('Data from request: ', $request->all());
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()   
                ->withErrors($validator)
                ->withInput();
        }

        Log::info('Data from request: ', $request->all());

        Schedule::createSchedule($request->all(), $daysOfWeek);

        toastr()->success('Tạo lịch tự động thành công.');
        $subjectClassId = $request->subject_class_id;

        return redirect()->route('admin.schedules.view-schedule', ['subject_class_id' => $subjectClassId]);
    }   

    public function edit($id)
    {
        $schedule = Schedule::find($id);
        if (Carbon::parse($schedule->date)->lt(Carbon::today())) {
            toastr()->error('Không thể chỉnh sửa lịch đã qua ngày hiện tại.');
            return redirect()->route('admin.schedules.view-schedule', ['subject_class_id' => $schedule->subject_class_id]);
        }    
        if ($schedule && $schedule->date) {
            $schedule->date = Carbon::parse($schedule->date)  ;
        }
        
        $teachers = Employee::all(['id', 'full_name']);
        $subjectClasses = SubjectClass::all();
        $timeSlots = TimeSlot::all();
        $classrooms = Classroom::all();

        return view('admin.schedules.edit', compact('schedule', 'subjectClasses', 'timeSlots', 'classrooms', 'teachers'));
    }


    public function update(UpdateScheduleRequest $request, $id)
    {   
        Log::info('Update Request Data:', $request->all());
        $schedule = Schedule::findOrFail($id);

        $schedule->update([
            'time_slot_id' => $request->time_slot_id,
            'classroom_id' => $request->classroom_id,
            'date' => $request->date,
            'substitute_employee_id' => $request->substitute_employee_id,
        ]);

        toastr()->success('Cập nhật lịch học thành công.');
        $subjectClassId = $request->subject_class_id;

        return redirect()->route('admin.schedules.view-schedule', ['subject_class_id' => $subjectClassId]);
    }


    public function viewSchedule($subjectClassId)
    {
        $subjectClass = SubjectClass::findOrFail($subjectClassId);
        $schedules = Schedule::getSchedulesBySubjectClassId($subjectClassId);
        $editedCount = Schedule::countEditedSchedulesBySubjectClass($subjectClassId);

        return view('admin.schedules.index', compact('subjectClass', 'schedules', 'editedCount'));
    }

}

