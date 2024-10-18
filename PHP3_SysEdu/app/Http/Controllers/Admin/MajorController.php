<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MajorRequest;
use App\Models\Major;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Major::updateTotalCreditsForAllMajors();
        $majors = Major::getAllMajor();
        return view('admin.majors.index', ['majorsView' => $majors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Major::getFacultiesForCreate();
        return view('admin.majors.create', ['faculties' => $faculties]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MajorRequest $request)
    {
        $data = $request->only(['name', 'faculty_id', 'code']);
        $validator = Major::validate($data, $request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validate();
        $major = Major::createMajor($validatedData);
        toastr()->success('Thêm thành công chuyên ngành: ' . $major->name);
        return redirect()->route('admin.majors.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $major = Major::findMajorById($id);
        $faculties = Major::getFacultiesForEdit();
        return view('admin.majors.edit', ['major' => $major, 'faculties' => $faculties]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MajorRequest $request, string $id)
    {
        $data = $request->only(['name', 'faculty_id', 'code']);
        $validator = Major::validate($data, $request);

        if ($validator->fails()) {
            return redirect()->route('admin.majors.edit')
                ->withErrors($validator)
                ->withInput();
        }
        $validatedData = $validator->validate();
        $major = Major::updateMajor($id, $validatedData);
        toastr()->success('Cập nhật thành công chuyên ngành: ' . $major->name);
        return redirect()->route('admin.majors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Major::deleteMajor($id);
            toastr()->success('Xoá thành công');
            return redirect()->route('admin.majors.index');
        } catch (QueryException $e) {
            if ($e->getCode()) {
                return redirect()->route('admin.majors.index');
            }
            return redirect()->route('admin.majors.index');
        }
    }
}
