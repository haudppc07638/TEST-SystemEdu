<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScheduleRequest;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\SubjectClass;
use App\Models\TimeSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Lấy giá trị của semesterId từ query parameters
        $semesterId = $request->query('semesterId');
        
        // Lấy danh sách kỳ học
        $semesters = Semester::all();

        // Lọc lịch học theo kỳ học
        if ($semesterId) {
            $subjectClassIds = SubjectClass::where('semester_id', $semesterId)->pluck('id');
            $schedules = Schedule::whereIn('subject_class_id', $subjectClassIds)->get();
        } else {
            $schedules = Schedule::all();
        }

        return view('admin.schedules.index', compact('schedules', 'semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($semesterId = null)
    {
        if (!$semesterId) {
            toastr()->warning('Bạn cần chọn kỳ học trước khi thêm lịch.');
            return redirect()->route('admin.schedules.select.semester');
        }
    
        $semesters = Semester::all();
        $subject_classes = SubjectClass::where('semester_id', $semesterId)->get();
        $classrooms = Classroom::all();
        $time_slots = TimeSlot::all();
    
        return view('admin.schedules.create', compact('semesters', 'subject_classes', 'classrooms', 'time_slots', 'semesterId'));
    }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleRequest $request): RedirectResponse
    {
        $rules = $request->rules();
        $messages = $request->messages();

        // Lấy semester_id từ dữ liệu gửi đến hoặc từ query parameters
        $semesterId = $request->input('semester_id');
        
        $data = $request->only([
            'schedule_day',
            'time_slot_id',
            'classroom_id',
            'subject_class_id'
        ]);
        $data['semester_id'] = $semesterId; // Thêm thông tin kỳ học vào dữ liệu

        $validator = Schedule::validate($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Schedule::create($data);
        toastr()->success('Thêm lịch học thành công');
        return redirect()->route('admin.schedules.index', ['semesterId' => $semesterId]);
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $schedule = Schedule::findOrFail($id);
        return view('admin.schedules.show', [
            'schedule' => $schedule
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $schedule = Schedule::findOrFail($id);
        $subject_classes = SubjectClass::all();
        $classrooms = Classroom::all();
        $time_slots = TimeSlot::all();

        return view('admin.schedules.edit', compact('schedule', 'subject_classes', 'classrooms', 'time_slots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScheduleRequest $request, string $id): RedirectResponse
    {
        $rules = $request->rules();
        $messages = $request->messages();

        $data = $request->only([
            'schedule_day',
            'time_slot_id',
            'classroom_id',
            'subject_class_id'
        ]);

        $validator = Schedule::validate($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Schedule::where('id', $id)->update($data); // Cập nhật lịch học
        toastr()->success('Cập nhật lịch học thành công');
        return redirect()->route('admin.schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Schedule::destroy($id);
        toastr()->success('Xoá lịch học thành công');
        return redirect()->route('admin.schedules.index');
    }
    public function selectSemester()
    {
        $semesters = Semester::whereHas('subjectClasses')->get();
        return view('admin.schedules.select-semester', compact('semesters'));
    }
}
