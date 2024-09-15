<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentSubjectClass;
use App\Models\SubjectClass;
use App\Models\Semester;
class EducationalHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Lấy giá trị từ request
        $semesterId = $request->input('semester');
        $yearId = $request->input('year');

        // Khởi tạo query cơ bản
        $query = StudentSubjectClass::query();

        // Áp dụng lọc theo kỳ học nếu có
        if ($semesterId) {
            $query->whereHas('subjectclass.semester', function($q) use ($semesterId) {
                $q->where('id', $semesterId);
            });
        }

        // Áp dụng lọc theo năm học nếu có
        if ($yearId) {
            $query->whereHas('subjectclass.semester', function($q) use ($yearId) {
                $q->where('id', $yearId);
            });
        }

        // Lấy dữ liệu đã lọc
        $showHistorys = $query->get();

        // Lấy tất cả các kỳ học và năm học để hiển thị trong dropdown
        $semesters = Semester::distinct()->get(['id', 'block']);
        $years = Semester::distinct()->get(['id', 'year']);

        // Trả về view với dữ liệu đã lọc
        return view('client.educational-history', [
            'showHistorys' => $showHistorys,
            'semesters' => $semesters,
            'years' => $years,
        ]);
    }
}
