@extends('layouts.master')

@section('title', 'Thêm Mới Môn Học')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Thêm Mới Môn Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">Môn</a></li>
                <li class="breadcrumb-item active">Thêm Mới</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.subjects.create.post') }}" method="POST">
                            @csrf
                            <br>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Tên môn học</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" >
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">Mã môn học</label>
                                <div class="col-sm-10">
                                    <input type="text" name="code" class="form-control" id="code" value="{{ old('code') }}" >
                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="major_id" class="col-sm-2 col-form-label">Chuyên ngành</label>
                                <div class="col-sm-10">
                                    <select name="major_id" class="form-select" id="major_id" >
                                        <option value="">Chọn chuyên ngành</option>
                                        @foreach($majors as $major)
                                            <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>
                                                {{ $major->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('major_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Mô tả</label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control quill-editor-full" id="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection

@push('style')
@endpush

@push('script')
@endpush
