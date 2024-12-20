
@extends('layouts.master')

@section('title', 'Add Faculties')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản lý khoa</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.faculties.index') }}">Khoa</a></li>
                    <li class="breadcrumb-item active">Thêm khoa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="card">
            <div class="card-body">
                <form class="mt-3 needs-validation" novalidate method="post"
                    action="{{ route('admin.faculties.create.post') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Tên khoa</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Mã khoa</label>
                        <div class="col-sm-10">
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code') }}">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="" class="col-sm-2 col-form-label">Trưởng khoa</label>
                        <div class="col-sm-10">
                            <select name="dean" class="form-select" id="dean" >
                                <option value="">Chọn trưởng khoa</option>
                               
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="" class="col-sm-2 col-form-label">Trưởng Khoa</label>
                        <div class="col-sm-10">
                            <select name="assistant_dean" class="form-select" id="assistant_dean" >
                                <option value="">Chọn Trưởng Khoa</option>
                               
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Mô tả</label>
                        <div class="col-sm-10">
                            <div id="editor-container"></div>
                            <textarea name="description" id="description" class="form-control" rows="7"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-cBlue">Thêm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection