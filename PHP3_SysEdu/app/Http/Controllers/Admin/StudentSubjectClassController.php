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
use App\Models\Score;
use App\Models\Subject;
use App\Models\SubjectScoreType;
use Maatwebsite\Excel\Facades\Excel;

class StudentSubjectClassController extends Controller
{
    public function index($id)
    {
        $studentSubjectClasses = StudentSubjectClass::getStudentSubClass($id);
        foreach ($studentSubjectClasses as $studentSubjectClass) {
            $studentSubjectClass->save();
        }
        $subjectClass = SubjectClass::findSubjectClassById($id);
        $scoreTypes = SubjectScoreType::getScoreTypesForSubjectClass($subjectClass->subject_id);

        $today = now();
        $isBeforeStart = $subjectClass->start_date > $today;

        return view('admin.studentsubjectclass.index', [
            'studentSubjectClasses' => $studentSubjectClasses,
            'subjectClass' => $subjectClass,

            'isBeforeStart' => $isBeforeStart,
            'scoreTypes' => $scoreTypes
        ]);
    }

    public function edit($id)
    {
        $studentSubClass = StudentSubjectClass::with(['scores', 'subjectClass.subject.subjectScoreTypes.scoreType'])->findOrFail($id);

        $profile = $studentSubClass->student;
        $subjectScoreTypes = $studentSubClass->subjectClass->subject->subjectScoreTypes;

        return view('admin.studentsubjectclass.edit', [
            'editstudentsubjectclass' => $studentSubClass,
            'student' => $profile,
            'subjectScoreTypes' => $subjectScoreTypes,
        ]);
    }




    public function update(StudentSubjectClassRequest $request, $id)
    {
        $scores = $request->input('scores');

        foreach ($scores as $subjectScoreTypeId => $scoreValue) {
            Score::updateOrCreate(
                [
                    'student_subject_class_id' => $id,
                    'subject_score_type_id' => $subjectScoreTypeId,
                ],
                ['score' => $scoreValue]
            );
        }

        toastr()->success('Cập nhật thành công điểm.');
        return redirect()->route('admin.studentsubjectclass.index', $id);
    }


    public function destroy() {}

    public function export($id)
    {
        $subjectClass = SubjectClass::findOrFail($id);
        $subjectClassName = $subjectClass->name;
        $day = now()->format('y-m-d');
        $fileName = 'Bang_diem_lop_' . $subjectClassName . '_' . $day . '.xlsx';
        return Excel::download(new StudentSubjectClassExport($subjectClassName, $id), $fileName);
    }

    public function import(Request $request, $subjectClassId)
    {
        // Tìm lớp môn dựa trên id
        $subjectClass = SubjectClass::findOrFail($subjectClassId);

        // Kiểm tra nếu có file được upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            try {
                // Import file và truyền SubjectClass
                $import = new StudentSubjectClassImport($subjectClass);
                Excel::import($import, $file);

                // Kiểm tra lỗi trong quá trình import
                $errors = $import->getErrors();
                if (!empty($errors)) {
                    toastr()->error('Có lỗi trong quá trình nhập dữ liệu:<br>' . implode('<br>', $errors));
                    return back();
                }

                toastr()->success('Nhập điểm thành công!');
                return back();
            } catch (\Throwable $e) {
                // Xử lý ngoại lệ
                toastr()->error('Có lỗi xảy ra: ' . $e->getMessage());
                return back();
            }
        }

        toastr()->error('Vui lòng tải lên file Excel');
        return back();
    }
}
