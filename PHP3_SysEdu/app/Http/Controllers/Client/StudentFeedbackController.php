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
    public function showFeedbackForm($studentSubjectClassId)
{
    $student = Auth::guard('student')->user();
    $studentSubjectClass = StudentSubjectClass::findOrFail($studentSubjectClassId);
    $completedFeedback = FeedbackResult::where('student_subject_class_id', $studentSubjectClassId)
        ->whereNotNull('results')   
        ->exists();

    $feedbackQuestions = FeedbackQuestion::whereHas('feedbackResults.studentSubjectClass', function ($query) use ($studentSubjectClass) {
        $query->where('subject_class_id', $studentSubjectClass->subject_class_id);
    })->get();

    return view('client.feedback-form', compact('feedbackQuestions', 'studentSubjectClassId'));
}

    public function storeFeedback(Request $request, $studentSubjectClassId)
    {
        $student = Auth::guard('student')->user();
        $request->validate([
            'feedback_question_id' => 'required|array',
            'results' => 'required|array',
        ]);

        $totalScore = 0;
        $totalQuestions = count($request->feedback_question_id);

        foreach ($request->feedback_question_id as $index => $questionId) {
            $result = new FeedbackResult([
                'feedback_question_id' => $questionId,
                'student_subject_class_id' => $studentSubjectClassId,
                'results' => $request->results[$index],
                'student_id' => $student->id,
            ]);
            $result->save();

            $totalScore += $request->results[$index];
        }

        $averageScore = $totalScore / $totalQuestions;
        $feedbackResult = FeedbackResult::where('student_subject_class_id', $studentSubjectClassId)
                    ->whereHas('feedbackQuestion', function ($query) use ($student) {
                        $query->where('student_id', $student->id);
                    })->first();
        if ($feedbackResult) {
            $feedbackResult->average_score = $averageScore;
            $feedbackResult->save();
        }
        return redirect()->route('student.home')->with('success', 'Bạn đã hoàn thành feedback!');
    }
    public function checkFeedbackCompletion($studentSubjectClassId)
    {
        $student = Auth::guard('student')->user();
        $feedbackCompleted = FeedbackResult::where('student_subject_class_id', $studentSubjectClassId)
                                           ->where('student_id', $student->id)
                                           ->whereNotNull('results')
                                           ->exists();
        return response()->json(['completed' => $feedbackCompleted]);
    }
}
