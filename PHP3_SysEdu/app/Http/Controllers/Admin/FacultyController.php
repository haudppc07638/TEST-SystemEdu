<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Http\Requests\Admin\FacultyRequest;
use Illuminate\Database\QueryException;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $faculty = Faculty::getAllFaculty($search);
        return view('admin.faculties.index',['facultiesView' => $faculty]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faculties.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(FacultyRequest $request)
    {
        $data = $request->only(['name', 'code', 'dean', 'asisstant_dean', 'description']);
        $validator = Faculty::validate($data, $request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Faculty::createFaculty($data);
        toastr()->success('Thêm Thành Công');
        return redirect()->route('admin.faculties.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $findFaculty = Faculty::getFacultyId($id);
        return view('admin.faculties.edit',['faculty' => $findFaculty]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FacultyRequest $request,$id)
    {
        
        $data = $request->only(['name', 'code', 'dean', 'asisstant_dean', 'description']);
        $validator = Faculty::validate($data, $request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Faculty::updateFacultyId($id, $data);
        toastr()->success('Cập nhật thành công');
        return redirect()->route('admin.faculties.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        Faculty::deleteFacultyId($id);
            toastr()->success('Xoá thành công');
            return redirect()->route('admin.faculties.index');
        }
        catch (QueryException $e) {
            if ($e->getCode()) {
                return redirect()->route('admin.faculties.index');  
            }
            return redirect()->route('admin.faculties.index');
        }
    }
}