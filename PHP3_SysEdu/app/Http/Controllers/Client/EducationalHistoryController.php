<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubjectHistory;
use App\Models\Semester;
use App\Models\Student;

class EducationalHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Lấy giá trị từ request
        $semesterId = $request->input('semester');
        $yearId = $request->input('year');

        // Lấy thông tin sinh viên đã đăng nhập
        $student = Auth::guard('student')->user();

        // Kiểm tra xem sinh viên có hợp lệ không
        if (!$student) {
            return redirect()->back()->with('error', 'Không tìm thấy sinh viên.');
        }

        // Tạo query cơ bản cho SubjectHistory
        $query = SubjectHistory::whereHas('studentSubjectClass', function ($q) use ($student) {
            $q->where('student_id', $student->id);
        });

        // Áp dụng lọc theo kỳ học nếu có
        if ($semesterId) {
            $query->whereHas('studentSubjectClass.subjectClass.semester', function ($q) use ($semesterId) {
                $q->where('id', $semesterId);
            });
        }

        // Áp dụng lọc theo năm học nếu có
        if ($yearId) {
            $query->whereHas('studentSubjectClass.subjectClass.semester', function ($q) use ($yearId) {
                $q->where('year', $yearId);
            });
        }

        // Nạp các mối quan hệ cần thiết và loại bỏ các bản ghi lặp lại
        $showHistorys = $query->with([
            'studentSubjectClass.subjectClass.subject',
            'studentSubjectClass.subjectClass.semester'
        ])->get()->unique('student_subject_class_id');

        // Tính tổng điểm và tổng tín chỉ
        $totalScore = 0;
        $totalCredits = 0;
        $subjectCount = 0;

        $major = Major::where('id', $student->major_id)->first();
        $totalCreditsMajor = $major->total_credits;

        foreach ($showHistorys as $history) {
            // Cộng điểm tổng (total_score có thể phải tính lại tùy vào cách lưu trữ điểm)
            $totalScore += $history->studentSubjectClass->total_score ?? 0;
            // Cộng tín chỉ
            $totalCredits += $history->studentSubjectClass->subjectClass->subject->credit ?? 0;

            if ($history->studentSubjectClass->total_score) {
                $subjectCount++;
            }
        }

        $averageScore = $subjectCount > 0 ? $totalScore / $subjectCount : 0;

        // Lấy danh sách các kỳ học và năm học để hiển thị bộ lọc
        $semesters = Semester::distinct()->get(['id', 'block']);
        $years = Semester::distinct()->get(['id', 'year']);

        // Trả về view với dữ liệu đã lọc
        return view('client.educational-history', [
            'showHistorys' => $showHistorys,
            'semesters' => $semesters,
            'years' => $years,
            'averageScore' => $averageScore,
            'totalCredits' => $totalCredits,
            'totalCreditsMajor' => $totalCreditsMajor,
        ]);
    }
}
