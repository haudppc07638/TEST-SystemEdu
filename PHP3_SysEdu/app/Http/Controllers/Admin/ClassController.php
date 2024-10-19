<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClassesRequest;
use App\Models\Employee;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\StuClass;
use App\Models\Student;
use Illuminate\Database\QueryException;
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
        $studentQuantities = [];
        foreach ($classes as $class) {
            $studentQuantities[$class->id] = StuClass::studentCount($class->id);
        }

        $major = Major::getNameMajorById($id);
        return view('admin.classes.classes', [
            'classes' => $classes,
            'major' => $major,
            'studentQuantities' => $studentQuantities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $major = Major::getNameMajorById($id);
        $employees = Employee::getAvailableTeachers($id);
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
        $data = $request->only(['name', 'training_system', 'major_id', 'start_date', 'quantity', 'employee_id']);

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
            toastr()->error('Lớp học đã kết thúc và không thể chỉnh sửa.');
            return redirect()->route('admin.classes', $class->major_id);
        }

        $employees = Employee::getAvailableTeachers($class->major_id);
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
        $data = $request->only(['name', 'training_system', 'major_id', 'start_date', 'quantity', 'employee_id']);

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
        try {
            StuClass::deleteClass($id);
            toastr()->success('Xóa thành công ');
            return redirect()->route('admin.classes', $class->major_id);
        } catch (QueryException $e) {     
            toastr()->error('Không thể xóa do có sinh viên trong lớp !');
            return redirect()->route('admin.classes', $class->major_id);    
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
}
