<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\StudentSubjectClass;
use App\Models\Subject;
use App\Models\SubjectClass;
use Illuminate\Support\Facades\Auth;
use App\Models\Tuition;
use App\Models\TotalTuition;
use App\Models\PrerequisiteSubject;
use App\Models\SubjectHistory;
use App\Models\Student;
use App\Models\Semester;
use Illuminate\Support\Facades\Log;

class RegisterSubjectController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        $subjects = Subject::getAvailableSubjectsForStudent($student->major_id);
        // dd($subjects);
        return view('client.register-subject', [
            'subjects' => $subjects
        ]);
    }

    public function detailSubjectById($id)
{
    $student = Auth::guard('student')->user();
    $currentDate = now()->toDateString();

    $availableClasses = SubjectClass::getAvailableClassesForMajor($student->major_id, $currentDate, $id);

    $registeredClasses = StudentSubjectClass::where('student_id', $student->id)
        ->whereHas('subjectClass', function ($query) use ($id) {
            $query->where('subject_id', $id);
        })
        ->get();

    return view('client.detail-subject', [
        'subjectClasses' => $availableClasses,
        'registeredClasses' => $registeredClasses,
    ]);
}

    public function joinClass($id)
    {
        $student = Auth::guard('student')->user();
        $subjectClass = SubjectClass::findOrFail($id);

        if ($subjectClass->isFull()) {
            toastr()->warning('Lớp học đã đầy. Không thể tham gia. Vui lòng chọn lớp khác!');
            return redirect()->route('client.subject.classes.show', $subjectClass->subject_id);
        }

        if ($subjectClass->conflictsWith($student->id)) {
            toastr()->error('Lịch học của lớp bị trùng với một lớp bạn đã đăng ký!');
            return redirect()->route('client.subject.classes.show', $subjectClass->subject_id);
        }

        $missingPrerequisites = $subjectClass->checkPrerequisites($student->id);
        if ($missingPrerequisites) {
            toastr()->error('Bạn chưa hoàn thành môn tiên quyết: ' . implode(', ', $missingPrerequisites));
            return redirect()->route('client.subject.classes.show', $subjectClass->subject_id);
        }
        // $subjectHistory = SubjectHistory::whereHas('studentSubjectClass.subjectClass', function ($query) use ($student, $subjectClass) {
        //     $query->where('subject_id', $subjectClass->subject_id); // Lọc theo subject_id của môn học
        // })
        // ->whereHas('studentSubjectClass', function ($query) use ($student) {
        //     $query->where('student_id', $student->id); // Lọc theo sinh viên
        // })
        // ->latest()
        // ->first();

        $type = StudentSubjectClass::determineType($subjectClass, $student->id);

        $studentSubjectClass = StudentSubjectClass::insertStudentSubjectClass($student->id, $id);
        if ($studentSubjectClass) {
            // $status = StudentSubjectClass::determineType($subjectClass, $student->id);
            if (now()->lessThanOrEqualTo($subjectClass->registration_deadline)) {
                SubjectHistory::create([
                    'student_subject_class_id' => $studentSubjectClass->id,
                    'type' => $type,
                ]);
            }
            Tuition::insertTuitionJoinClass($studentSubjectClass->id);
            TotalTuition::insertTuitionSubject($studentSubjectClass->student_id);

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

        $studentSubjectClass = StudentSubjectClass::where('student_id', $student->id)
        ->where('subject_class_id', $subjectClass->id)
        ->first();

    if ($studentSubjectClass) {
        $studentSubjectClass->delete();  // Hủy đăng ký lớp
        toastr()->success('Bạn đã hủy đăng ký lớp thành công.');
    } else {
        toastr()->error('Bạn chưa đăng ký lớp này.');
    }
        
        return redirect()->route('client.subject.classes.show', $subjectClass->subject_id);
    }

    private function determineRegistrationType($subjectHistory)
    {
        if (!$subjectHistory) {
            return 'mới';
        } elseif ($subjectHistory->type === 'fail') {
            return 'học lại';
        } elseif ($subjectHistory->type === 'pass') {
            return 'cải thiện điểm';
        }
        return null;
    }
}
