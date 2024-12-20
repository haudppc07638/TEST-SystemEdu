<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SemesterRequest;
use App\Models\Semester;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class SemesterController extends Controller
{

    public function index()
    {
        $semesters = Semester::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.semesters.index', ['semestersView' => $semesters]);
    }


    public function create()
    {
        return view('admin.semesters.create');
    }


    public function store(SemesterRequest $request)
    {
        $validated = $request->validated();
        $semester = Semester::create($validated);
        
        toastr()->success('Thêm thành công: ' . $semester->block);
        return redirect()->route('admin.semesters.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $semester = Semester::findOrFail($id);
        return view('admin.semesters.edit', ['semester' => $semester]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SemesterRequest $request, $id)
    {
        $validated = $request->validated();
        $semester = Semester::findOrFail($id);
        $semester->update($validated);
        toastr()->success('Cập nhật thành công: ' . $semester->block);
        return redirect()->route('admin.semesters.index');
    }

    public function destroy($id)
    {
        try {
            $isDeleted = Semester::findOrFail($id);
            $isDeleted->delete();
            
            if ($isDeleted) {
                toastr()->success('Xóa thành công');
            } else {
                toastr()->warning('Hiện tại học kỳ đang có dữ liệu phụ thuộc!');
            }
    
            return redirect()->route('admin.semesters.index');
        } catch (QueryException $e) {
            toastr()->warning('Đã xảy ra lỗi khi xóa học kỳ. Vui lòng thử lại!');
            return redirect()->route('admin.semesters.index');
        }
    }
}
