<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TimeSlotRequest;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class TimeSlotController extends Controller
{
    public function index()
    {
        $timeSlots = TimeSlot::orderBy('id', 'desc')->get();
        return view('admin.timeslots.index', ['timeSlotsView' => $timeSlots]);
    }

    public function create()
    {
        return view('admin.timeslots.create');
    }

    public function store(TimeSlotRequest $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['slot', 'start_time', 'end_time']);
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validatedData = $validator->validated();
        $timeSlot = TimeSlot::create($validatedData);
        toastr()->success('Thêm thành công: ' . $timeSlot->slot);
        return redirect()->route('admin.timeslots.index');
    }

    public function edit($id)
    {
        $timeSlot = TimeSlot::findOrFail($id);
        return view('admin.timeslots.edit', ['timeSlot' => $timeSlot]);
    }

    public function update(TimeSlotRequest $request, $id)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['slot', 'start_time', 'end_time']);
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validatedData = $validator->validated();
        $timeSlot = TimeSlot::findOrFail($id);
        $timeSlot->update($validatedData);
        toastr()->success('Cập nhật thành công thông tin: ' . $timeSlot->slot);
        return redirect()->route('admin.timeslots.index');
    }

    public function destroy($id)
    {
        try {
            $timeSlot = TimeSlot::find($id);
            $slot = $timeSlot->slot;
            $timeSlot->delete();
            toastr()->success('Xóa thời gian thành công: ' . $slot);
            return redirect()->route('admin.timeslots.index');
        } catch (QueryException $e) {
            if ($e->getCode()) {
                return redirect()->route('admin.timeslots.index');
            }
            return redirect()->route('admin.timeslots.index');
        }
    }
}
