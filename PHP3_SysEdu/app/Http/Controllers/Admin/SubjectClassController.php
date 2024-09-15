<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubjectClass;
use App\Models\Subject;
use App\Models\Employee;
use App\Models\Semester;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\SubjectClassRequest;

class SubjectClassController extends Controller
{
    public function index()
    {
        $subjectClasses = SubjectClass::all();
        return view('admin.subjectclasses.index', ['subjectClasses' => $subjectClasses]);
    }

    public function create()
    {
        
        $subjects = Subject::getCodeSubject();
        $semesters = Semester::getSemester(); 
        $employees = Employee::getNameEmployees();
       
        return view('admin.subjectclasses.create',[
            'subjects'  =>$subjects,
            'semesters'=>$semesters,
            'employees' =>$employees,
        ]);
    }
    
    public function store(SubjectClassRequest $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();;
        $data = $request->only([
            'quantity',
            'name',
            'start_date',
            'end_date',
            'registration_deadline',
            'employee_id',
            'subject_id',
            'semester_id',
        ]);
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validatedData = $validator->validated();
        SubjectClass::create($validatedData);
        toastr()->success('Lớp học được tạo thành công');
        return redirect()->route('admin.subjectclasses.index');
    }

    public function edit($id)
    {
        $subjectClass = SubjectClass::findOrFail($id);
    
        $subjects = Subject::getCodeSubject();
        $semesters = Semester::getSemester();
        $employees = Employee::getNameEmployees();
    
        return view('admin.subjectclasses.edit', [
            'subjectClass' => $subjectClass,
            'subjects' => $subjects,
            'semesters' => $semesters,
            'employees' => $employees,
        ]);
    }
    
    public function update(SubjectClassRequest $request, $id)
    {
        $rules = $request->rules();
        $messages = $request->messages();;
        $data = $request->only([
            'quantity',
            'name',
            'start_date',
            'end_date',
            'employee_id',
            'subject_id',
            'semester_id',
            'registration_deadline',
        ]);
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validatedData = $validator->validated();
        $subjectClass = SubjectClass::findOrFail($id);
        $subjectClass->update($validatedData);
        toastr()->success('Lớp học được cập nhật thành công.');
        return redirect()->route('admin.subjectclasses.index');
    }

    public function destroy($id)
    {
        try {
        $subjectClass = SubjectClass::findOrFail($id);
        $subjectClass->delete();
        toastr()->success('Lớp học được xóa thành công.');
        return redirect()->route('admin.subjectclasses.index');
    }
    catch (QueryException $e) {
        if ($e->getCode()) {
            return redirect()->route('admin.subjectclasses.index');
        }
        return redirect()->route('admin.subjectclasses.index');
    }
}
}