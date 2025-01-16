<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClassroomRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Classroom;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::orderBy('id', 'desc')->paginate(10);
        return view('admin.classrooms.index', ['classroomsView' => $classrooms]);
    }
    public function create()
    {
        return view('admin.classrooms.create');
    }
    public function store(ClassroomRequest $request)
    {
        $validated = $request->validated();
        $classroom = Classroom::create($validated);

        toastr()->success('Thêm thành công: ' . $classroom->code);
        return redirect()->route('admin.classrooms.index');
    }
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('admin.classrooms.edit', ['classroom' => $classroom]);
    }
    public function update(ClassroomRequest $request, string $id)
    {
        $validated = $request->validated();
        $classroom = Classroom::findOrFail($id);
        $classroom->update($validated);
        toastr()->success('Cập nhật thành công: ' . $classroom->code);
        return redirect()->route('admin.classrooms.index');
    }

    public function destroy($id)
    {
        try {
            $classroom = Classroom::findOrFail($id);
            $code = $classroom->code;
            $classroom->delete();
            toastr()->success('Xóa phòng học thành công: ' . $code);
            return redirect()->route('admin.classrooms.index');
            
        }
        catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                toastr()->warning('Không thể xóa phòng học này vì có dữ liệu phụ thuộc !');
                return redirect()->route('admin.classrooms.index');
            }
            toastr()->warning('Không thể xóa phòng học này vì có dữ liệu phụ thuộc !');
            return redirect()->route('admin.classrooms.index');
        }
    }
    
}
