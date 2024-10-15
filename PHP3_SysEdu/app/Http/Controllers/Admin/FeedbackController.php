<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeedbackRequest;
use App\Models\Feedback;
use App\Models\StudentSubjectClass;
use App\Models\SubjectClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $subjectClasses = SubjectClass::all();

        // Khởi tạo truy vấn feedback
        $query = Feedback::with('student'); // Sử dụng eager loading

        // Kiểm tra xem có lọc theo lớp môn không
        if ($request->has('subject_class_id')) {
            $subjectClassId = $request->input('subject_class_id');
            $query->where('subject_class_id', $subjectClassId);
        }

        // Lấy tất cả feedbacks (hoặc theo filter nếu có)
        $feedbacks = $query->get(); // Lấy danh sách feedbacks

        return view('admin.feedbacks.index', compact('feedbacks', 'subjectClasses'));
    }


    public function create()
    {
        $subjectClasses = SubjectClass::all();
        return view('admin.feedbacks.create', compact('subjectClasses'));
    }

    public function store(FeedbackRequest $request)
    {
        // Lấy subject_class_id từ request
        $subjectClassId = $request->input('subject_class_id');
        $user = Auth::guard('employee')->user();

        // Tạo feedback với phản hồi của giáo viên/admin cho lớp môn học
        Feedback::create([
            'employee_id' => $user->id,
            'subject_class_id' => $subjectClassId,
            'admin_feedback' => $request->admin_feedback,
        ]);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback đã được gửi thành công.');
    }


    public function showForStudent()
    {
        $studentId = Auth::guard('student')->user()->id;

        $subjectClassIds = StudentSubjectClass::where('student_id', $studentId)
            ->pluck('subject_class_id')
            ->toArray();
        $feedbacks = Feedback::whereIn('subject_class_id', $subjectClassIds)->get();

        return view('client.feedback', compact('feedbacks'));
    }

    public function submitStudentFeedback(FeedbackRequest $request, $id)
    {
        $data = $request->only(['student_feedback', 'rating']);
        $feedback = Feedback::findOrFail($id);
        $studentId = Auth::guard('student')->user()->id;
        $feedback->update([
            'student_feedback' => $data['student_feedback'],
            'rating' => $data['rating'],
            'student_id' => $studentId
        ]);

        return redirect()->back()->with('success', 'Phản hồi đã được gửi thành công.');
    }

}
