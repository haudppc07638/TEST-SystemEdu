@extends('layouts.master')

@section('title', 'Add Major')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản Lý Chuyên Ngành</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Đào Tạo</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.majors.index') }}">Chuyên Ngành</a></li>
                    <li class="breadcrumb-item active">Thêm Chuyên Ngành</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="card">
            <div class="card-body">
                <form class="row g-3 mt-3 needs-validation" novalidate method="POST"
                    action="{{ route('admin.majors.create.post') }}">
                    @csrf
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Khoa</label>
                        <select class="form-select @error('faculty_id') is-invalid @enderror"
                            aria-label="Default select example" name="faculty_id">
                            <option value="" disabled {{ old('faculty_id') ? '' : 'selected' }}>Chọn Khoa</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}"
                                    {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                    {{ $faculty->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Tên chuyên ngành</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                   

                    <div class="col-12">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
