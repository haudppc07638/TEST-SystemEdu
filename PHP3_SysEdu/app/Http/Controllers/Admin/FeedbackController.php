<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeedbackRequest;
use App\Models\FeedbackQuestion;
use App\Models\FeedbackResult;
use App\Models\StudentSubjectClass;
use App\Models\SubjectClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $subjectClasses = SubjectClass::orderBy('name', 'asc')->get();
        $feedbackResultsQuery = FeedbackResult::query();

        if ($request->has('subject_class_id') && $request->input('subject_class_id') != '') {
            $feedbackResultsQuery->whereHas('studentSubjectClass', function ($query) use ($request) {
                $query->where('subject_class_id', $request->input('subject_class_id'));
            });
        }

        $feedbackResultsForStudents = $feedbackResultsQuery->whereHas('studentSubjectClass')->with(['studentSubjectClass.student'])->paginate(10);
        $feedbackResultsForTeachers = $feedbackResultsQuery->whereHas('feedbackQuestion.employee')->with(['feedbackQuestion.employee'])->paginate(10);

        return view('admin.feedbacks.index', compact('feedbackResultsForStudents', 'feedbackResultsForTeachers', 'subjectClasses'));
    }

    public function create()
    {
        $subjectClasses = SubjectClass::orderBy('name', 'asc')->get();
        $feedbackQuestions = FeedbackQuestion::all();

        return view('admin.feedbacks.create', compact('subjectClasses', 'feedbackQuestions'));
    }

    public function store(FeedbackRequest $request)
    {
        $questionIds = [];
        foreach ($request->question_name as $questionName) {
            $feedbackQuestion = FeedbackQuestion::create([
                'name' => $questionName,
                'employee_id' => null,
            ]);
            $questionIds[] = $feedbackQuestion->id;
        }
        foreach ($questionIds as $questionId) {
            $feedbackQuestion = FeedbackQuestion::findOrFail($questionId);
            if ($request->subject_class_id) {
                $targets = [];

                if ($request->target === 'student') {
                    $targets = StudentSubjectClass::where('subject_class_id', $request->subject_class_id)->get();
                } elseif ($request->target === 'employee') {
                    $subjectClass = SubjectClass::findOrFail($request->subject_class_id);
                    $targets = $subjectClass->employees;
                }
                if ($targets->isEmpty()) {
                    return redirect()->back()->with('error', 'Không có đối tượng nào trong lớp môn này.');
                }
                foreach ($targets as $target) {
                    $data = [
                        'feedback_question_id' => $questionId,
                        'results' => null,
                        'target_type' => $request->target,
                        'student_subject_class_id' => $target->id,
                    ];

                    // Lưu vào bảng FeedbackResult tùy theo đối tượng
                    if ($request->target === 'employee') {
                        $data['employee_id'] = $target->id;
                    }

                    FeedbackResult::create($data);
                }
            } else {
                return redirect()->back()->with('error', 'Vui lòng chọn lớp môn.');
            }
        }

        return redirect()->route('admin.feedbacks.index')->with('success', 'Tạo câu hỏi phản hồi thành công!');
    }

    public function edit($id)
    {
        $feedbackQuestion = FeedbackQuestion::findOrFail($id);
        return view('admin.feedbacks.edit', compact('feedbackQuestion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $feedbackQuestion = FeedbackQuestion::findOrFail($id);
        $feedbackQuestion->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Cập nhật câu hỏi phản hồi thành công!');
    }

    public function destroy($id)
    {
        $feedbackQuestion = FeedbackQuestion::findOrFail($id);
        $feedbackQuestion->delete();

        return redirect()->route('admin.feedbacks.index')->with('success', 'Xóa câu hỏi phản hồi thành công!');
    }

    public function showFeedbackForm($studentSubjectClassId)
    {
        $feedbackQuestions = FeedbackQuestion::where('student_subject_class_id', $studentSubjectClassId)->get();

        return view('feedback.form', compact('feedbackQuestions', 'studentSubjectClassId'));
    }

    public function storeFeedback(Request $request, $studentSubjectClassId)
    {
        $data = $request->validate([
            'feedback_question_id' => 'required|array',
            'results' => 'required|array',
        ]);

        $studentSubjectClass = StudentSubjectClass::findOrFail($studentSubjectClassId);

        $totalScore = 0;
        $totalQuestions = count($data['feedback_question_id']);

        foreach ($data['feedback_question_id'] as $index => $questionId) {
            $result = new FeedbackResult([
                'feedback_question_id' => $questionId,
                'student_subject_class_id' => $studentSubjectClassId,
                'results' => $data['results'][$index],
            ]);
            $result->save();

            $totalScore += $data['results'][$index];
        }

        $averageScore = $totalScore / $totalQuestions;

        $feedbackResult = FeedbackResult::where('student_subject_class_id', $studentSubjectClassId)->first();
        if ($feedbackResult) {
            $feedbackResult->average_score = $averageScore;
            $feedbackResult->save();
        }

        return response()->json([
            'message' => 'Feedback submitted successfully',
            'average_score' => $averageScore
        ]);
    }

    public function calculateFeedbackScore($subjectClassId)
    {
        $feedbackResults = FeedbackResult::whereHas('studentSubjectClass', function ($query) use ($subjectClassId) {
            $query->where('subject_class_id', $subjectClassId);
        })->get();

        $totalScore = 0;
        $responseCount = 0;

        foreach ($feedbackResults as $result) {
            $score = $this->evaluateFeedback($result->results);
            $totalScore += $score;
            $responseCount++;
        }

        return $responseCount > 0 ? round($totalScore / $responseCount, 2) : null;
    }

    private static function evaluateFeedback($result)
    {
        $scores = [
            'Tốt' => 10,
            'Khá' => 8,
            'Trung bình' => 6,
            'Kém' => 4,
        ];

        return $scores[$result] ?? 0;
    }

    public function showFeedbackSummary($subjectClassId)
    {
        $averageScore = $this->calculateFeedbackScore($subjectClassId);

        return view('feedback.summary', compact('averageScore'));
    }
}
