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
        $majors = Major::all();
        return view('admin.subjects.create', ['majors' => $majors]);
    }

    public function store(SubjectRequest $request)
    {
        $data = $request->only(['code', 'name','credit', 'description', 'major_id']);
        
        $data['price'] = 0;
        $subject = Subject::createSubject($data);
        toastr()->success('Thêm thành công môn học: ' . $subject->name);
        return redirect()->route('admin.subjects.index');
    }

    public function show(string $id)
    {
        $subject = Subject::with('major')->findOrFail($id);
        return view('admin.subjects.show', ['subject' => $subject]);
    }

    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        $majors = Major::all();
        return view('admin.subjects.edit', [
            'subject' => $subject,
            'majors' => $majors
        ]);
    }

    public function update(SubjectRequest $request, string $id)
    {
        
        $data = $request->only(['code', 'name','credit', 'description', 'major_id']);
        $data['price'] = 0;
        $subject = Subject::updateSubject($id,$data);
        $subject->update($data);
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
        }
        catch (QueryException $e) {
            if ($e->getCode()) {
                return redirect()->route('admin.subjects.index');
            }
            return redirect()->route('admin.subjects.index');
        }
    }
}
