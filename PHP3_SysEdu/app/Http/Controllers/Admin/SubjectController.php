<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubjectRequest;
use App\Models\Subject;
use App\Models\Major;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::getAllSubjects();
        return view('admin.subjects.index', ['subjectView' => $subjects]);
    }

    public function create()
    {
        $majors = Major::getAllMajor();
        $subjects = Subject::getAllSubjects();
        return view('admin.subjects.create', ['majors' => $majors, 'subjects' => $subjects]);
    }

    public function store(SubjectRequest $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['code', 'name', 'credit', 'description', 'major_id']);
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subject = Subject::createSubject($data);

        if ($request->has('prerequisites')) {
            $subject->prerequisites()->sync($request->prerequisites);
        }

        toastr()->success('Thêm thành công môn học: ' . $subject->name);
        return redirect()->route('admin.subjects.index');
    }

    public function edit(string $id)
    {
        $subject = Subject::with('prerequisites')->findOrFail($id);
        $majors = Major::all();
        $subjects = Subject::all();
        return view('admin.subjects.edit', [
            'subject' => $subject,
            'majors' => $majors,
            'subjects' => $subjects
        ]);
    }

    public function update(SubjectRequest $request, string $id)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        $data = $request->only(['code', 'name', 'credit', 'description', 'major_id']);
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subject = Subject::updateSubject($id, $data);
        if ($request->has('prerequisites')) {
            $subject->prerequisites()->sync($request->prerequisites);
        } else {
            $subject->prerequisites()->sync([]);
        }
        toastr('Cập nhật thông tin môn học thành công: ' . $subject->name);
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
