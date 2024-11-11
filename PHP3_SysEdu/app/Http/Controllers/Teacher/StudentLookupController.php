<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentLookupController extends Controller
{
    public function index()
    {
        return view('teacher.student-lookup.index');
    }

    public function search(Request $request)
    {
        try {
            $searchTerm = $request->search_term;

            if (empty($searchTerm)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vui lòng nhập từ khóa tìm kiếm'
                ]);
            }

            $students = Student::searchStudents($searchTerm);
            $view = view('teacher.student-lookup.searchResults', compact('students'))->render();

            return response()->json([
                'status' => 'success',
                'data' => $view
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra vui lòng thử lại sau !'
            ]);
        }
    }

    public function show($id)
    {
        try {
            $student = Student::getDetailedStudent($id);
            return view('teacher.student-lookup.show', compact('student'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không tìm thấy sinh viên');
        }
    }
}