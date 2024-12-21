<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MajorRequest;
use App\Models\Major;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Subject;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $faculties = Faculty::select('id', 'name')->get();

        $facultyId = $request->get('faculty_id', null);
        $search = $request->get('search', null);
        $search = $request->input('search');
        $majors = Major::getAllMajor($facultyId, $search);

        foreach ($majors as $major) {
            $totalSubjectCredits = Subject::where('major_id', $major->id)
                ->sum('credit');
            $totalBasicCredits = Subject::whereNull('major_id')
                ->sum('credit');

            $major->total_subject_credits = $totalSubjectCredits + $totalBasicCredits;
        }

        return view('admin.majors.index', [
            'majorsView' => $majors,
            'faculties' => $faculties,
            'facultyId' => $facultyId,
            'search' => $search,
        ]);
    }

    public function list(Request $request)
    {
        $majors = Major::all();
        $majors = $majors->map(function ($major) {
            $major->image = $major->image ?? 'default-image.jpg';
            return $major;
        });
        if ($request->expectsJson()) {
            return response()->json($majors, 201)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
        }
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
        $validated = $request->validated();

        $major = Major::create($validated);

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
        $validated = $request->validated();

        $totalSubjectCredits = Subject::where('major_id', $id)->sum('credit');
        $totalBasicSubjectCredits = Subject::whereNull('major_id')->sum('credit');
        $total = $totalSubjectCredits + $totalBasicSubjectCredits;
        // Kiểm tra xem total_credits có nhỏ hơn total_subject_credits không
        if ($validated['total_credits'] < $total) {
            return redirect()->back()->withErrors([
                'total_credits' => 'Tổng tín chỉ của chuyên ngành không được nhỏ hơn '.$total.' tổng tín chỉ của các môn học đã có.'
            ])->withInput();
        }
        $major = Major::updateMajor($id, $validated);

        toastr()->success('Cập nhật thành công chuyên ngành: ' . $major->name);
        return redirect()->route('admin.majors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $isDeleted = Major::findOrFail($id);
            $isDeleted->delete();

            if ($isDeleted) {
                toastr()->success('Xóa thành công');
            } else {
                toastr()->warning('Hiện tại chuyên ngành đang có dữ liệu phụ thuộc!');
            }

            return redirect()->route('admin.majors.index');
        } catch (QueryException $e) {
            toastr()->warning('Hiện tại chuyên ngành đang có dữ liệu phụ thuộc!');
            return redirect()->route('admin.majors.index');
        }
    }
}
