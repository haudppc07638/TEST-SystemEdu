<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubjectLecturerRequest;
use App\Models\Subject;
use App\Models\Employee;
use App\Models\Major;
use App\Models\SubjectLecturer;
use Illuminate\Http\Request;

class SubjectLecturerController extends Controller
{
    public function create(Request $request)
    {
        $majorId = $request->input('major_id');
        $subjects = Subject::all();
        $employees = Employee::all();
        $majors = Major::all();

        return view('admin.subject_lecturers.create', compact('subjects', 'employees', 'majors', 'majorId'));
    }


    public function storeOrUpdate(SubjectLecturerRequest $request)
    {
        $request->validated();
        $subject = Subject::findOrFail($request->subject_id);

        $subject->syncLecturers($request->employee_ids);

        toastr()->success('Đăng ký giảng viên thành công.');
        return redirect()->route('admin.subject_lecturers.create');
    }


    public function filter(Request $request)
    {
        $majorId = $request->input('major_id');

        $subjects = Subject::with('lecturers.employee')
            ->when($majorId !== null, function ($query) use ($majorId) {
                return $query->where('major_id', $majorId);
            })
            ->get();

        return response()->json($subjects);
    }

    public function getLecturersBySubject(Request $request)
    {
        $subjectId = $request->input('subject_id');

        $lecturers = SubjectLecturer::with('employee')
            ->where('subject_id', $subjectId)
            ->get()
            ->pluck('employee');

        return response()->json($lecturers);
    }
}
