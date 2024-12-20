<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\Student;
use App\Models\StudentSubjectClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $faculties = Faculty::getNameFaculties();
        $majors = Major::getNameMajors();

        $facultyCount = Faculty::count();
        $majorCount = Major::count();
        $studentCount = Student::count();
        $employeeCount = Employee::count();

        // Lấy dữ liệu từ database
        $rawChartData = Student::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Tạo danh sách từ tháng 1 đến tháng 12
        $chartData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create()->month($month)->format('F');
            $chartData[$monthName] = $rawChartData[$month] ?? 0; // Gán giá trị 0 nếu không có dữ liệu
        }

        return view('admin.dashboard', [
            'faculties' => $faculties,
            'majors' => $majors,
            'chartData' => $chartData,
            'facultyCount' => $facultyCount,
            'majorCount' => $majorCount,
            'studentCount' => $studentCount,
            'employeeCount' => $employeeCount,
        ]);
    }



    public function getMajorsByFaculty(Request $request)
    {
        $faculty_id = $request->input('faculty_id');
        $majors = Major::where('faculty_id', $faculty_id)->get();
        return response()->json($majors);
    }
}
