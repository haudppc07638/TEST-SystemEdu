<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScheduleRequest;
use App\Models\Classroom;
use App\Models\Employee;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\SubjectClass;
use App\Models\TimeSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::query();

        // Áp dụng các bộ lọc theo khoa, ngành, môn, và giáo viên
        if ($facultyId = $request->input('facultyId')) {
            $query->whereHas('subjectClass.subject.major', function ($q) use ($facultyId) {
                $q->where('faculty_id', $facultyId);
            });
        }

        if ($majorId = $request->input('majorId')) {
            $query->whereHas('subjectClass.subject', function ($q) use ($majorId) {
                $q->where('major_id', $majorId);
            });
        }

        if ($subjectId = $request->input('subjectId')) {
            $query->whereHas('subjectClass', function ($q) use ($subjectId) {
                $q->where('subject_id', $subjectId);
            });
        }

        if ($teacherId = $request->input('teacherId')) {
            $query->whereHas('subjectClass', function ($q) use ($teacherId) {
                $q->where('employee_id', $teacherId);
            });
        }

        // Lấy danh sách lịch học
        $schedules = $query->paginate(10);

        // Dữ liệu để hiển thị dropdowns
        $faculties = Faculty::all();
        $majors = $facultyId ? Major::where('faculty_id', $facultyId)->get() : [];
        $subjects = $majorId ? Subject::where('major_id', $majorId)->get() : [];
        $teachers = $subjectId ? Employee::whereIn('id', function ($query) use ($subjectId) {
            $query->select('employee_id')->from('subject_classes')->where('subject_id', $subjectId);
        })->get() : [];
        $semesters = Semester::all(); // Thêm dòng này

        return view('admin.schedules.index', compact('schedules', 'faculties', 'majors', 'subjects', 'teachers', 'semesters'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create($semesterId = null)
    {
        if (!$semesterId) {
            toastr()->warning('Bạn cần chọn kỳ học trước khi thêm lịch.');
            return redirect()->route('admin.schedules.select.year');
        }

        $semester = Semester::find($semesterId);
        $semesters = Semester::all();
        $subject_classes = SubjectClass::where('semester_id', $semesterId)->get();
        $classrooms = Classroom::all();
        $time_slots = TimeSlot::all();

        return view('admin.schedules.create', compact('semesters', 'subject_classes', 'classrooms', 'time_slots', 'semesterId', 'semester'));
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

    public function selectYear()
    {
        $years = Semester::select(DB::raw('YEAR(year) as year'))->distinct()->pluck('year');
        return view('admin.schedules.select-year', compact('years'));
    }

    public function selectSemester(Request $request)
    {
        $year = $request->input('year');
        $semesters = Semester::whereYear('year', $year)->get();
        if ($request->has('semesterId')) {
            $semesterId = $request->input('semesterId');
            return redirect()->route('admin.schedules.create', ['semesterId' => $semesterId]);
        }

        return view('admin.schedules.select-semester', compact('semesters', 'year'));
    }

    public function selectFaculty()
    {
        $faculties = Faculty::paginate(10);
        return view('admin.schedules.select-faculty', compact('faculties'));
    }

    public function selectMajor($facultyId)
    {
        $majors = Major::where('faculty_id', $facultyId)->paginate(10);
        return view('admin.schedules.select-major', compact('majors', 'facultyId'));
    }

    public function selectSubject($facultyId, $majorId)
    {
        $subjects = Subject::where('major_id', $majorId)->paginate(10);
        return view('admin.schedules.select-subject', compact('subjects', 'facultyId', 'majorId'));
    }
    public function selectTeacher($facultyId, $majorId, $subjectId)
    {
        $teachers = Employee::whereIn('id', function ($query) use ($subjectId) {
            $query->select('employee_id')
                ->from('subject_classes')
                ->where('subject_id', $subjectId);
        })->paginate(10);

        $subjectsByTeacher = Subject::whereIn('id', function ($query) use ($teachers) {
            $query->select('subject_id')
                ->from('subject_classes')
                ->whereIn('employee_id', $teachers->pluck('id'));
        })->get();

        return view('admin.schedules.select-teacher', compact('teachers', 'facultyId', 'majorId', 'subjectId', 'subjectsByTeacher'));
    }

}
