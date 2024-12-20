<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::paginate(10);
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function detail($id)
    {
        $enrollment = Enrollment::find($id);
        return view('admin.enrollments.detail', compact('enrollment'));
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::find($id);
        $enrollment->delete();
        toastr()->success('Đăng ký đã được xóa thành công');
        return redirect()->route('admin.enrollments.index');
    }
}
