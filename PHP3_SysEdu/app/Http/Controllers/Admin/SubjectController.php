<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubjectRequest;
use App\Models\Subject;
use App\Models\Major;
use App\Models\ScoreType;
use App\Models\SubjectScoreType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::getAllSubjects();
        return view('admin.subjects.index', ['subjectView' => $subjects]);
    }

    public function detail(string $id)
    {
        $subject = Subject::detailSubject($id);
        return view('admin.subjects.detail', ['subject' => $subject]);
    }

    public function create()
    {
        $majors = Major::getAllMajor();
        $subjects = Subject::getAllSubjects();
        $scoreTypes = ScoreType::all();
        return view('admin.subjects.create', ['majors' => $majors, 'subjects' => $subjects, 'scoreTypes' => $scoreTypes]);
    }

    public function store(SubjectRequest $request)
    {
        $validated = $request->validated();

        $totalWeight = 0;
        foreach ($request->score_types as $scoreTypeId) {
            $weight = $request->weights[$scoreTypeId] ?? 0;
            $totalWeight += $weight;
        }

        if ($totalWeight !== 100) {
            return redirect()->back()->withErrors(['weights' => 'Tổng trọng số cho các loại điểm đã chọn phải bằng 100%.'])->withInput();
        }

        $subject = Subject::createSubject($validated);

        toastr()->success('Thêm thành công môn học: ' . $subject->name);
        return redirect()->route('admin.subjects.index');
    }

    public function edit(string $id)
    {
        $subject = Subject::with('prerequisites')->findOrFail($id);
        $majors = Major::all();
        $subjects = Subject::all();
        $scoreTypes = ScoreType::all();
        $subjectCoreType = SubjectScoreType::where('subject_id', $id)->get();

        return view('admin.subjects.edit', [
            'subject' => $subject,
            'majors' => $majors,
            'subjects' => $subjects,
            'scoreTypes' => $scoreTypes,
            'subjectCoreType' => $subjectCoreType
        ]);
    }

    public function update(SubjectRequest $request, string $id)
    {
        $validated = $request->validated();

        $totalWeight = 0;
        foreach ($request->score_types as $scoreTypeId) {
            $weight = floatval($request->weights[$scoreTypeId] ?? 0);
            $totalWeight += $weight;
        }
        if (abs($totalWeight - 100.0) > 0.01) {
            return redirect()->back()->withErrors(['weights' => 'Tổng trọng số cho các loại điểm đã chọn phải bằng 100%.'])->withInput();
        }

        try {
            $subject = Subject::findOrFail($id);
            $subject->updateSubject($validated);

            toastr()->success('Cập nhật thành công môn học: ' . $subject->name);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['weights' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.subjects.index');
    }


    public function destroy(string $id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $name = $subject->name;
            $subject->delete();
            toastr()->success('Xóa thành công môn học: ' . $name);
            return redirect()->route('admin.subjects.index');
        } catch (QueryException $e) {
            if ($e->getCode()) {
                return redirect()->route('admin.subjects.index');
            }
            return redirect()->route('admin.subjects.index');
        }
    }
}
