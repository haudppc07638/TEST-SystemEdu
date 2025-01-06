@extends('layouts.master')

@section('title', 'Chỉnh Sửa Lớp Học Phần')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Chỉnh sửa lớp học phần</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjectclasses.index') }}">Lớp học phần</a></li>
                    <li class="breadcrumb-item active">Chỉnh Sửa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('admin.subjectclasses.update', $subjectClass->id) }}">
                                @csrf
                                @method('PUT')

                                <!-- Môn họchọc -->
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Môn học</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"
                                            value="{{ $subjectClass->subject->name }}"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <!-- Tên lớp -->
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Tên lớp</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name', $subjectClass->name) }}"
                                            {{ $subjectClass->isStarted() ? 'readonly' : '' }}>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Số lượng -->
                                <div class="row mb-3">
                                    <label for="quantity" class="col-sm-2 col-form-label">Số lượng</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="quantity" id="quantity" class="form-control"
                                            value="{{ old('quantity', $subjectClass->quantity) }}"
                                            {{ $subjectClass->isStarted() ? 'readonly' : '' }}>
                                        @error('quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Ngày hết hạn đăng ký -->
                                <div class="row mb-3">
                                    <label for="registration_deadline" class="col-sm-2 col-form-label">Ngày hết hạn đăng
                                        ký</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="registration_deadline" id="registration_deadline"
                                            class="form-control"
                                            value="{{ old('registration_deadline', $subjectClass->registration_deadline) }}"
                                            {{ $subjectClass->isStarted() ? 'readonly' : '' }}>
                                        @error('registration_deadline')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Ngày bắt đầu -->
                                <div class="row mb-3">
                                    <label for="start_date" class="col-sm-2 col-form-label">Ngày bắt đầu</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                            value="{{ old('start_date', $subjectClass->start_date) }}"
                                            {{ $subjectClass->isStarted() ? 'readonly' : '' }}>
                                        @error('start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Ngày kết thúc -->
                                <div class="row mb-3">
                                    <label for="end_date" class="col-sm-2 col-form-label">Ngày kết thúc</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                            value="{{ old('end_date', $subjectClass->end_date) }}"
                                            {{ $subjectClass->isStarted() ? 'readonly' : '' }}>
                                        @error('end_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Giảng viên -->
                                <div class="row mb-3">
                                    <label for="employee_id" class="col-sm-2 col-form-label">Giảng viên</label>
                                    <div class="col-sm-10">
                                        <select name="employee_id" id="employee_id" class="form-control"
                                            {{ $subjectClass->isStarted() ? 'disabled' : '' }}>
                                            <option value="">Chọn Giảng Viên</option>
                                            @foreach ($lecturers as $lecturer)
                                                <option value="{{ $lecturer->id }}"
                                                    {{ old('employee_id', $subjectClass->employee_id) == $lecturer->id ? 'selected' : '' }}>
                                                    {{ $lecturer->code }} - {{ $lecturer->full_name }} 
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-cBlue">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
