<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScoreTypeRequest;
use App\Models\ScoreType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScoreTypeController extends Controller
{
    public function index()
    {
        $scoreTypes = ScoreType::all();
        return view('admin.score_types.index', compact('scoreTypes'));
    }

    public function create()
    {
        return view('admin.score_types.create');
    }

    public function store(ScoreTypeRequest $request)
    {
        $validated = $request->validated();
        ScoreType::create($validated);

        toastr()->success('Tạo loại điểm thành công!');
        return redirect()->route('admin.score_types.index');
    }

    public function edit($id)
    {
        $scoreType = ScoreType::findOrFail($id);
        return view('admin.score_types.edit', compact('scoreType'));
    }

    public function update(ScoreTypeRequest $request, $id)
    {
        $scoreType = ScoreType::findOrFail($id);
        $validated = $request->validated();
        $scoreType->update($validated);

        toastr()->success('Cập nhật loại điểm thành công!');
        return redirect()->route('admin.score_types.index');
    }

    public function destroy($id)
    {
        $scoreType = ScoreType::findOrFail($id);
        $scoreType->delete();

        toastr()->success('Xóa loại điểm thành công!');
        return redirect()->route('admin.score_types.index');
    }
}
