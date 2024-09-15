<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\StudentSubjectClass;
use App\Models\Subject;
use App\Models\SubjectClass;
use Illuminate\Support\Facades\Auth;

class RegisterSubjectController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        $subjects = Subject::getAvailableSubjectsForStudent($student->major_id);

        return view('client.register-subject', [
            'subjects' => $subjects
        ]);
    }

    public function detailSubjectById($id)
    {
        $student = Auth::guard('student')->user();
        $currentDate = now()->toDateString();

        $availableClasses = SubjectClass::getAvailableClassesForMajor($student->major_id, $currentDate, $id);
        $registeredClass = StudentSubjectClass::getRegisteredClassForSubject($student->id, $id);

        return view('client.detail-subject', [
            'subjectClasses' => $availableClasses,
            'registeredClass' => $registeredClass,
        ]);
    }

    public function joinClass($id)
    {
        $student = Auth::guard('student')->user();
        $subjectClass = SubjectClass::findOrFail($id);

        if ($subjectClass->isFull()) {
            toastr()->warning('Lớp học đã đầy. Không thể tham gia. Vui lòng chọn lớp khác !');
            return redirect()->route('client.subject.classes.show', $subjectClass->subject_id);
        }
        
        $registration = StudentSubjectClass::insertStudentSubjectClass($student->id, $id);
        toastr()->success('Bạn đã tham gia lớp thành công.');
        return redirect()->route('client.subject.classes.show', $subjectClass->subject_id);
    }

    public function cancelClass($id)
    {
        $student = Auth::guard('student')->user();
        $subjectClass = SubjectClass::findOrFail($id);

        StudentSubjectClass::cancelStudentSubjectClass($student->id, $id);

        toastr()->success('Bạn đã hủy đăng ký lớp thành công.');
        return redirect()->route('client.subject.classes.show', $subjectClass->subject_id);
    }
}
