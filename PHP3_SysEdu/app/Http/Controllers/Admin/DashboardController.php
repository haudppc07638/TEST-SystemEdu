<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\Student;
use App\Models\StudentSubjectClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $faculties = Faculty::getNameFaculties();
        $majors = Major::getNameMajors();
        $chartData = []; // Khởi tạo biến chartData mặc định

        if ($request->has('major_id')) {
            $major_id = $request->input('major_id');
      
            $chartData = StudentSubjectClass::getChartDataByMajorId($major_id);
        }

        return view('admin.dashboard', [
            'faculties' => $faculties,
            'majors' => $majors,
            'chartData' => $chartData,
        ]);
    }

    public function getMajorsByFaculty(Request $request)
    {
        $faculty_id = $request->input('faculty_id');
        $majors = Major::where('faculty_id', $faculty_id)->get();
        return response()->json($majors);
    }
}
