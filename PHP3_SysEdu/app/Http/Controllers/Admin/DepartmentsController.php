<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::getNameDepartments();
        return view('admin.departments.index', ['departmentsView' => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request){
   
        $rules = $request->rules();
        $messages = $request->messages();

        $data = $request->only(['name', 'location']);
  
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
        return redirect()->back()
        ->withErrors($validator)
        ->withInput();
        }
        $department = Department::create($data);
        toastr()->success('Thêm thành công phòng ban: ' . $department->name);
        return redirect()->route('admin.departments.index');
        }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $findDepartment = Department::findOrFail($id);
        return view('admin.departments.edit', ['department' => $findDepartment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, $id)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['name', 'location']);

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
            }

        Department::updateDepartment($id, $data);
        toastr()->success('Cập nhập thành công');
        return redirect()->route('admin.departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
        Department::deleteDepartment($id);
        toastr()->success('Xoá thành công');
        return redirect()->route('admin.departments.index');;
    }
    catch (QueryException $e) {
        if ($e->getCode()) {
            return redirect()->route('admin.departments.index');
        }
        return redirect()->route('admin.departments.index');
    }
}
}
