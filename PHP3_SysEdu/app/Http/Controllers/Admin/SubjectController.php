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
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
    $majors = Major::select('id', 'name')->get();

    $majorId = $request->get('major_id', null);
    $search = $request->get('search', null);

    $subjects = Subject::getAllSubjects($majorId, $search);

    return view('admin.subjects.index', [
        'subjectView' => $subjects,
        'majors' => $majors,
        'majorId' => $majorId,
        'search' => $search,
    ]);
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
        $this->validateTotalWeight($request);
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
        $this->validateTotalWeight($request);

        $subject = Subject::findOrFail($id);

        // Cập nhật thông tin môn học
        $subject->updateSubject($validated);

        // Xử lý cập nhật score types và weights
        if (isset($validated['score_types'])) {
            $subject->scoreTypes()->detach(); // Xóa tất cả các liên kết cũ

            foreach ($validated['score_types'] as $scoreTypeId) {
                $scoreType = ScoreType::find($scoreTypeId);
                $weight = $validated['weights'][$scoreTypeId] ?? 0;

                if ($scoreType->type === 'multi' && isset($request->sub_scores[$scoreTypeId])) {
                    $quantity = $request->sub_scores[$scoreTypeId];
                    $subWeight = $weight / $quantity;

                    for ($i = 1; $i <= $quantity; $i++) {
                        $subject->scoreTypes()->attach($scoreTypeId, [
                            'weight' => $subWeight,
                            'name' => "{$scoreType->name}{$i}"
                        ]);
                    }
                } else {
                    $subject->scoreTypes()->attach($scoreTypeId, [
                        'weight' => $weight,
                        'name' => $scoreType->name
                    ]);
                }
            }
        }

        toastr()->success('Cập nhật thành công môn học: ' . $subject->name);
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

    private function validateTotalWeight($request)
    {
        $totalWeight = 0;

        foreach ($request->input('score_types', []) as $scoreTypeId) {
            $weight = floatval($request->input("weights.$scoreTypeId", 0));
            $totalWeight += $weight;
        }

        if (round($totalWeight, 2) !== 100.00) {
            return redirect()->back()
                ->withErrors(['weights' => 'Tổng trọng số cho các loại điểm đã chọn phải bằng 100%.'])
                ->withInput();
        }
    }
}
