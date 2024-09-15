<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClassesRequest;
use App\Models\Employee;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\StuClass;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showFaculties()
    {
        $faculties = Faculty::getNameFaculties();
        return view('admin.classes.faculties', [
            'faculties' => $faculties
        ]);
    }

    public function showMajors($id)
    {
        $majors = Major::getMajorsWithFacultyId($id);

        return view('admin.classes.majors', [
            'majors' => $majors
        ]);
    }

    public function showClasses($id)
    {

        $classes = StuClass::getClassesWithMajorId($id);
        foreach ($classes as $class) {
            StuClass::updateStudentCount($class->id);
        }
        $major = Major::getNameMajorById($id);

        return view('admin.classes.classes', [
            'classes' => $classes,
            'major' => $major,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $major = Major::getNameMajorById($id);
        $faculty_id = $major->faculty_id;
        $employees = Employee::getAvailableTeachers($faculty_id);
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
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['name', 'trainingsystem', 'major_id', 'employee_id']);

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $class = StuClass::createClass($data);
        toastr()->success('Thêm thành công lớp: ' . $class->name);
        return redirect()->route('admin.classes', $data['major_id']);
    }

    /**
     * Display the specified resource.
     */
    public function updateStatus($id)
    {
        $class = StuClass::getClassById($id);
        if ($class->status == 0) {
            $class->status = 1;
            $class->save();
            toastr()->success('Trạng thái lớp ' . $class->name . ' đã được cập nhật thành "Đã kết thúc".');
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
            toastr()->error('Lớp học đã kết thúc và không thể chỉnh sửa.');
            return redirect()->route('admin.classes', $class->major_id);
        }
        $major = Major::getNameMajorById($class->major_id);
        $faculty_id = $major->faculty_id;
        $employees = Employee::getAvailableTeachers($faculty_id);
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
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['name', 'trainingsystem', 'major_id', 'employee_id']);

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $class = StuClass::updateClassById($id, $data);
        toastr()->success('Cập nhập thành công thông tin của lớp: ' . $class->name);
        return redirect()->route('admin.classes', $data['major_id']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $class = StuClass::getClassById($id);
        StuClass::deleteClass($id);
        toastr()->success('Xóa thành công ');
        return redirect()->route('admin.classes', $class->major_id);
    }
}
