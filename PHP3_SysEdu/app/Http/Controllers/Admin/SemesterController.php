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
        $semesters = Semester::getAllSemester();
        return view('admin.semesters.index', ['semestersView' => $semesters]);
    }


    public function create()
    {
        return view('admin.semesters.create');
    }


    public function store(SemesterRequest $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['block', 'year']);
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();

        }
        $validatedData = $validator->validated();
        $semester = Semester::create($validatedData);
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
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['block', 'year']);

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validatedData = $validator->validated();
        $semester = Semester::findOrFail($id);
        $semester->update($validatedData);
        toastr()->success('Cập nhật thành công: ' . $semester->block);
        return redirect()->route('admin.semesters.index');
    }

    public function destroy($id)
    {
        try {
            $semester = Semester::find($id);
            $block = $semester->block;
            $semester->delete();
            return redirect()->route('admin.semesters.index');

        } catch (QueryException $e) {
            if ($e->getCode()) {
                return redirect()->route('admin.semesters.index');
            }
            return redirect()->route('admin.semesters.index');
        }
    }
}
