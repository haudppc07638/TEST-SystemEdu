<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherFreeSlotRequest;
use App\Models\Employee;
use App\Models\TeacherFreeSlot;
use App\Models\TimeSlot;

class TeacherFreeSlotController extends Controller
{
    public function createOrUpdate($id)
    {
        $employee = Employee::findOrFail($id);
        $timeSlots = TimeSlot::all();
        $employeeTimeSlots = TeacherFreeSlot::getTimeSlotIds($id);
        $freeSlot = TeacherFreeSlot::where('employee_id', $id)->latest()->first();

        return view('admin.teacher_free_slots.create', compact('employee', 'timeSlots', 'freeSlot', 'employeeTimeSlots'));
    }

    public function storeOrUpdate(TeacherFreeSlotRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $currentTimeSlots = TeacherFreeSlot::getTimeSlotIds($id);
        $selectedTimeSlots = $request->input('time_slots', []);

        $toDelete = array_diff($currentTimeSlots, $selectedTimeSlots);
        TeacherFreeSlot::deleteUnusedTimeSlots($id, $toDelete);
        
        TeacherFreeSlot::addFreeTimeSlots($id, $selectedTimeSlots, $request->start_day, $request->end_day);

        toastr()->success('Ca dạy rảnh đã được cập nhật thành công.');
        return redirect()->route('admin.teacher_free_slots.createOrUpdate', ['id' => $id]);
    }
}
