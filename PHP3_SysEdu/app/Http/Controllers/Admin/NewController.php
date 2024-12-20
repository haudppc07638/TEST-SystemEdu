<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(NewsRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/news', 'public');
            $validated['image'] = $imagePath;
        }
        $news = News::create($validated);
        toastr()->success('Thêm thành công tin tức: ' . $news->title);
        return redirect()->route('admin.news.index');
    }

    public function edit($id)
    {
        $news = News::find($id);
        return view('admin.news.edit', ['news' => $news]);
    }
    public function update(NewsRequest $request, $id)
    {
        $validated = $request->validated();
        $news = News::find($id);
    
        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::delete('public/' . $news->image);
            }
    
            $imagePath = $request->file('image')->store('uploads/news', 'public');
            $validated['image'] = $imagePath;
        }
    
        $news->update($validated);
        toastr()->success('Cập nhật thành công tin tức: ' . $news->title);
        return redirect()->route('admin.news.index');
    }

    public function destroy($id)
    {
        $news = News::find($id);
        if ($news->image) {
            Storage::delete('public/' . $news->image);
        }
        $news->delete();
        toastr()->success('Xóa thành công tin tức: ' . $news->title);
        return redirect()->route('admin.news.index');
    }
}
