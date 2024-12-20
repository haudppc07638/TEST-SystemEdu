<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScoreTypeRequest;
use App\Models\ScoreType;
use Illuminate\Database\QueryException;
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
        try {
            
            $isDeleted = ScoreType::findOrFail($id);
            $isDeleted->delete();
            
            if ($isDeleted) {
                toastr()->success('Xóa thành công');
            } else {
                toastr()->warning('Hiện tại loại điểm đang có dữ liệu phụ thuộc!');
            }
    
            return redirect()->route('admin.score_types.index');
        } catch (QueryException $e) {
            toastr()->warning('Đã xảy ra lỗi khi xóa loại điểm. Vui lòng thử lại!');
            return redirect()->route('admin.score_types.index');
        }
    }
}
