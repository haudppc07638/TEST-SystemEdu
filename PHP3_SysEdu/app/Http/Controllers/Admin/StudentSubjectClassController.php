<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentSubjectClass;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentSubjectClassRequest;

class StudentSubjectClassController extends Controller
{
    public function index(){
        $studentSubjectClasses = StudentSubjectClass::getAllStudentSubClass();
        return view('admin.studentsubjectclass.index',['studentSubjectClassView' => $studentSubjectClasses ]);
    }
    public function create(){
        // return view('admin.studentsubclass.create');
    }
    public function show($id){

    }
    public function store(){

    }
    public function edit($id){
        $studentSubClass = StudentSubjectClass::editStudentSubClass($id);
        $profile = Student::getProfileStudent();
        return view('admin.studentsubjectclass.edit',[
            'editstudentsubjectclass' => $studentSubClass,
            'student' => $profile
      ]);
    }
    public function update(StudentSubjectClassRequest $request, $id){
        $data = $request->only('student_id' ,'midterm_score', 'final_score');
        $validator = StudentSubjectClass::validate($data, $request);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->route('admin.studentsubjectclass.edit', ['id' => $request->id])
                ->withErrors($validator)
                ->withInput();
        }
        $studentsubjectclass = StudentSubjectClass::updateStudentSubClass($id, $data);
        return redirect()->route('admin.studentsubjectclass.index')->with('success', 'Cập nhật thành công điểm sinh viên: ' . $studentsubjectclass->student->fullname);
    }
    public function destroy(){
        
    }
}
