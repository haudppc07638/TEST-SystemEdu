@extends('layouts.master')

@section('title', 'students')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản Lý Sinh Viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Đào tạo</li>
                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Sinh viên</a></li>
                <li class="breadcrumb-item active">Thêm sinh viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <form class="row g-3 mt-3 needs-validation" novalidate method="POST" action="{{ route('admin.students.create.post') }}" enctype="multipart/form-data">
                @csrf

                <!-- Họ và tên -->
                <div class="col-md-6">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname') }}">
                    @error('fullname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mã sinh viên -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Mã sinh viên</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mật khẩu -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số điện thoại -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ảnh -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Ảnh</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Chuyên ngành -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Chuyên ngành</label>
                    <select class="form-select @error('major_id') is-invalid @enderror" name="major_id">
                        <option disabled selected>Chọn chuyên ngành...</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('major_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lớp học -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Lớp học</label>
                    <select class="form-select @error('class_id') is-invalid @enderror" name="class_id">
                        <option disabled selected>Chọn lớp học...</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nút Submit -->
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>

</main><!-- End #main -->

@endsection

@push('style')
@endpush

@push('script')
@endpush
