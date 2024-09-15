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
        $classrooms = Classroom::orderBy('id', 'desc')->get();
        return view('admin.classrooms.index', ['classroomsView' => $classrooms]);
    }
    public function create()
    {
        return view('admin.classrooms.create');
    }
    public function store(ClassroomRequest $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['code']);


        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();
        $classroom = Classroom::create($validatedData);

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
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['code']);

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validatedData = $validator->validated();
        $classroom = Classroom::findOrFail($id);
        $classroom->update($validatedData);

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
                toastr()->error('Không thể xóa phòng học. Nó có liên kết với lịch học.');
                return redirect()->route('admin.classrooms.index');
            }
            toastr()->error('Có lỗi xảy ra khi xóa phòng học. Vui lòng thử lại.');
            return redirect()->route('admin.classrooms.index');
        }
    }
    
}
