<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherFreeSlot;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TeacherFreeController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('employee')->user();
        $freeSlots = TeacherFreeSlot::where('employee_id', $teacher->id)->get();
        $timeSlots = TimeSlot::all();
        
        return view('teacher.teacherfreeslots.index', compact('teacher', 'freeSlots', 'timeSlots'));
    }

    public function update(Request $request)
    {
        $teacher = Auth::guard('employee')->user();
        $freeSlot = TeacherFreeSlot::where('employee_id', $teacher->id)->latest()->first();
        if ($freeSlot) {
            $currentDateTime = Carbon::now();

            if ($currentDateTime->between(Carbon::parse($freeSlot->start_day), Carbon::parse($freeSlot->end_day))) {
                $selectedTimeSlots = $request->input('time_slots', []);
                $currentTimeSlots = TeacherFreeSlot::getTimeSlotIds($teacher->id);
                $toDelete = array_diff($currentTimeSlots, $selectedTimeSlots);

                TeacherFreeSlot::deleteUnusedTimeSlots($teacher->id, $toDelete);
                TeacherFreeSlot::addFreeTimeSlots($teacher->id, $selectedTimeSlots, $freeSlot->start_day, $freeSlot->end_day);

                toastr()->success('Ca dạy rảnh đã được cập nhật thành công.');
            } else {
                toastr()->error('Không thể cập nhật lịch vì đã quá hạn đăng ký.');
            }
        } else {
            toastr()->error('Không có ca rảnh nào để cập nhật.');
        }

        return redirect()->route('teacher.free_slot.index');
    }
}
