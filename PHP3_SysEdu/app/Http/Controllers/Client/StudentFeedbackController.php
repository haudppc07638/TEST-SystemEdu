<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FeedbackResult;
use App\Models\FeedbackQuestion;
use App\Models\StudentSubjectClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentFeedbackController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $studentId = $student->id;
        $studentClasses = StudentSubjectClass::where('student_id', $studentId)->pluck('id');
        
        // Lấy các câu hỏi feedback theo lớp môn của sinh viên
        $feedbackResults = FeedbackResult::whereIn('student_subject_class_id', $studentClasses)
            ->whereNull('results') // Chỉ lấy các câu hỏi chưa có kết quả
            ->with('feedbackQuestion', 'studentSubjectClass')
            ->get()
            ->groupBy('student_subject_class_id'); // Nhóm theo lớp môn
        
        return view('client.feedback', compact('feedbackResults'));
    }
    
    public function showFeedbackForm($studentSubjectClassId)
    {
        $student = Auth::guard('student')->user();
        $studentId = $student->id;
        $studentClass = StudentSubjectClass::where('id', $studentSubjectClassId)
            ->where('student_id', $studentId)
            ->firstOrFail();
        $feedbackQuestions = FeedbackQuestion::whereHas('feedbackResults', function ($query) use ($studentSubjectClassId) {
            $query->where('student_subject_class_id', $studentSubjectClassId)->whereNull('results');
        })->get();
        return view('client.feedback-form', compact('feedbackQuestions', 'studentSubjectClassId'));
    }

    public function storeFeedback(Request $request, $studentSubjectClassId)
    {
        $student = Auth::guard('student')->user();
        $studentId = $student->id;
        $studentClass = StudentSubjectClass::where('id', $studentSubjectClassId)
            ->where('student_id', $studentId)
            ->firstOrFail();
        $data = $request->validate([
            'feedback_question_id' => 'required|array',
            'results' => 'required|array',
            'expertise' => 'nullable|string|max:255',
        ]);

        foreach ($data['feedback_question_id'] as $index => $questionId) {
            FeedbackResult::updateOrCreate(
                [
                    'student_subject_class_id' => $studentSubjectClassId,
                    'feedback_question_id' => $questionId,
                ],
                [
                    'student_id' => $studentId,
                    'results' => $data['results'][$index],
                    'expertise' => $data['expertise']
                ]
            );
        }

        return redirect()->route('feedback.list')
            ->with('success', 'Feedback đã được gửi thành công!');
    }

}
