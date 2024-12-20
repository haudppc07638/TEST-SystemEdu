<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClassesRequest;
use App\Models\Employee;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\StuClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $faculties = Faculty::all();
        $majorClasses = StuClass::query();

        if ($request->filled('faculty_id')) {
            $majorClasses->whereHas('major.faculty', function ($query) use ($request) {
                $query->where('id', $request->faculty_id);
            });
        }

        if ($request->filled('major_id')) {
            $majorClasses->where('major_id', $request->major_id);
        }

        $majorClasses = $majorClasses->get();
        return view('admin.classes.index', compact('faculties', 'majorClasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $major = Major::all();
        $employees = Employee::getAvailableTeachers();
        return view('admin.classes.create', [
            'major' => $major,
            'employees' => $employees,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassesRequest $request)
    {
        $data = $request->validated();
        $class = StuClass::create($data);
        toastr()->success('Thêm thành công lớp chuyên ngành: ' . $class->name);
        return redirect()->route('admin.classes.index', $data['major_id']);
    }

    /**
     * Display the specified resource.
     */
    public function updateStatus($id)
    {
        $class = StuClass::getClassById($id);
        if ($class->status == 0) {
            $class->status = 1;
            $class->end_date = now();
            $class->save();
            toastr()->success('Trạng thái lớp ' . $class->name . ' đã hoàn thành !".');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $class = StuClass::getClassById($id);

        if ($class->status == 1) {
            toastr()->warning('Lớp học đã kết thúc và không thể chỉnh sửa.');
            return redirect()->route('admin.classes.index', $class->major_id);
        }

        $employees = Employee::getAvailableTeachers();
        return view('admin.classes.edit', [
            'class' => $class,
            'employees' => $employees
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ClassesRequest $request, $id)
    {
        $data = $request->validated();
        $class = StuClass::updateClassById($id, $data);
        toastr()->success('Cập nhập thành công thông tin của lớp: ' . $class->name);
        return redirect()->route('admin.classes.index', $data['major_id']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $class = StuClass::getClassById($id);
        try {
            StuClass::deleteClass($id);
            toastr()->success('Xóa thành công ');
            return redirect()->route('admin.classes.index', $class->major_id);
        } catch (QueryException $e) {
            toastr()->error('Không thể xóa do có sinh viên trong lớp !');
            return redirect()->route('admin.classes.index', $class->major_id);
        }
    }

    public function showClassDetail($classId)
    {
        $class = StuClass::detailMajorClass($classId);
        $students = Student::getStudentsByMajorClass($classId);

        return view('admin.classes.detail', [
            'class' => $class,
            'students' => $students,
        ]);
    }

    public function getMajorClassesBySubject(Request $request)
    {
        $subject = Subject::find($request->subject_id);

        if ($subject && $subject->major_id) {
            $majorClasses = StuClass::where('major_id', $subject->major_id)->get();
        } else {
            $majorClasses = StuClass::all();
        }

        return response()->json($majorClasses);
    }
}
