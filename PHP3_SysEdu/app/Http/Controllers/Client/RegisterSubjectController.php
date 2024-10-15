<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\StudentSubjectClass;
use App\Models\Subject;
use App\Models\SubjectClass;
use Illuminate\Support\Facades\Auth;
use App\Models\Tuition;
use App\Models\TotalTuition;

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
        $student = Auth::guard(name: 'student')->user();
        $subjectClass = SubjectClass::findOrFail(id: $id);
        // $studentSubjectClass = StudentSubjectClass::findOrFail($studentSubjectClassId);

        if ($subjectClass->isFull()) {
            toastr()->warning(message: 'Lớp học đã đầy. Không thể tham gia. Vui lòng chọn lớp khác !');
            return redirect()->route('client.subject.classes.show', $subjectClass->subject_id);
        }
        
        $studentSubjectClasses = StudentSubjectClass::insertStudentSubjectClass($student->id, $id);

        if ($studentSubjectClasses) {
            
            Tuition::insertTuitionJoinClass($studentSubjectClasses->id);
            TotalTuition::insertTuitionSubject($studentSubjectClasses->student_id);
    
            toastr()->success('Bạn đã tham gia lớp thành công.');
        } else {
            toastr()->error('Đăng ký lớp thất bại.');
        }        
        return redirect()->route('client.subject.classes.show',  $subjectClass->subject_id);
    }

    public function cancelClass($id)
    {
        $student = Auth::guard('student')->user();
        $subjectClass = SubjectClass::findOrFail($id);

        $studentSubjectClass = StudentSubjectClass::cancelStudentSubjectClass($student->id, $id);
        if($studentSubjectClass){
            // Tuition::where('student_subject_class_id', $studentSubjectClass->id)->delete();
            // Tuition::cancelTuitionJoinClass($studentSubjectClass->id);
            toastr()->success('Bạn đã hủy đăng ký lớp thành công.');
        }else{
            toastr()->error('Bạn đã hủy đăng ký lớp thất bại.');
        }
        return redirect()->route('client.subject.classes.show', $subjectClass->subject_id);
    }
}
