<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentSubjectClassImport;
use App\Models\Student;
use App\Models\StudentSubjectClass;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentSubjectClassRequest;
use App\Models\SubjectClass;
use App\Exports\StudentSubjectClassExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentSubjectClassController extends Controller
{
    public function index($id)
    {
        $studentSubjectClasses = StudentSubjectClass::getStudentSubClass($id);
        $subjectClass = SubjectClass::findSubjectClassById($id);
        $today = now();
        $isExpired = $subjectClass->end_date <= $today;
        $isBeforeStart = $subjectClass->start_date > $today;

        return view('admin.studentsubjectclass.index', [
            'studentSubjectClasses' => $studentSubjectClasses,
            'subjectClassId' => $id,
            'isExpired' => $isExpired,
            'isBeforeStart' => $isBeforeStart
        ]);
    }
    public function create()
    {
        // return view('admin.studentsubclass.create');
    }
    public function show($id)
    {

    }
    public function store()
    {

    }
    public function edit($id)
    {
        $studentSubClass = StudentSubjectClass::editStudentSubClass($id);
        $profile = Student::getProfileStudent();
        return view('admin.studentsubjectclass.edit', [
            'editstudentsubjectclass' => $studentSubClass,
            'student' => $profile
        ]);
    }
    public function update(StudentSubjectClassRequest $request, $id)
    {
        $data = $request->only('student_id', 'midterm_score', 'final_score');
        $validator = StudentSubjectClass::validate($data, $request);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->route('admin.studentsubjectclass.edit', ['id' => $request->id])
                ->withErrors($validator)
                ->withInput();
        }
        $studentsubjectclass = StudentSubjectClass::updateStudentSubClass($id, $data);
        toastr()->success('Cập nhật thành công điểm sinh viên: ' . $studentsubjectclass->student->fullname);
        return redirect()->route('admin.studentsubjectclass.index',$studentsubjectclass->subjectClass->id);
    }
    public function destroy()
    {

    }

    public function export($id)
    {
        $subjectClass = SubjectClass::findOrFail($id);
        $subjectClassName = $subjectClass->name;
        $day = now()->format('y-m-d');
        $fileName = 'Bang_diem_lop_'.$subjectClassName.'_'.$day.'.xlsx';
        return Excel::download(new StudentSubjectClassExport($subjectClassName, $id), $fileName);
    }

    public function import(Request $request, $subjectClassId)
    {
        // Tìm lớp môn dựa trên id
        $subjectClass = SubjectClass::findOrFail($subjectClassId);

        // Kiểm tra nếu có file được upload
        if ($request->hasFile('file')) {
            $file = $request->file(key: 'file');

            try {
                // Import file và truyền tên lớp môn
                $import = new StudentSubjectClassImport($subjectClass->name);
                Excel::import($import, $file);

                // Kiểm tra nếu có lỗi trong quá trình import
                $errors = $import->getErrors();
                if (!empty($errors)) {
                    // Nếu có lỗi, hiển thị lỗi
                    toastr()->error('Có lỗi trong quá trình nhập dữ liệu:<br>' . implode('<br>', $errors));
                    return back();
                }

                toastr()->success('Nhập điểm thành công!');
                return back();
            } catch (\Exception $e) {
                // Xử lý ngoại lệ nếu có lỗi trong quá trình import
                toastr()->error('Có lỗi xảy ra: ' . $e->getMessage());
                return back();
            }
        }

        toastr()->error('Vui lòng tải lên file Excel');
        return back();
    }
}
