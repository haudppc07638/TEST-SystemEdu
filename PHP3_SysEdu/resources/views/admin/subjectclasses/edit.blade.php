@extends('layouts.master')

@section('title', 'Chỉnh Sửa Lớp Học')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Chỉnh Sửa Lớp Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.subjectclasses.index') }}">Lớp Học</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            @if (session('success'))
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.subjectclasses.update', $subjectClass->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="quantity" class="col-sm-2 col-form-label">Số lượng</label>
                                <div class="col-sm-10">
                                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $subjectClass->quantity) }}" >
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Tên Lớp </label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $subjectClass->name) }}" >
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="registration_deadline" class="col-sm-2 col-form-label">Ngày hết hạn đăng ký</label>
                                <div class="col-sm-10">
                                    <input type="date" name="registration_deadline" id="registration_deadline" class="form-control" value="{{ old('registration_deadline', $subjectClass->registration_deadline) }}" >
                                    @error('registration_deadline')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="start_date" class="col-sm-2 col-form-label">Ngày bắt đầu</label>
                                <div class="col-sm-10">
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $subjectClass->start_date) }}" >
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                           

                            <div class="row mb-3">
                                <label for="end_date" class="col-sm-2 col-form-label">Ngày kết thúc</label>
                                <div class="col-sm-10">
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $subjectClass->end_date) }}" >
                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="employee_id" class="col-sm-2 col-form-label">Giảng viên</label>
                                <div class="col-sm-10">
                                    <select name="employee_id" id="employee_id" class="form-control">
                                        <option value="">Chọn Giảng Viên</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ old('employee_id', $subjectClass->employee_id) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->fullname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="subject_id" class="col-sm-2 col-form-label">Môn học</label>
                                <div class="col-sm-10">
                                    <select name="subject_id" id="subject_id" class="form-control">
                                        <option value="">Chọn Môn Học</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject_id', $subjectClass->subject_id) == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="semester_id" class="col-sm-2 col-form-label">Học kỳ</label>
                                <div class="col-sm-10">
                                    <select name="semester_id" id="semester_id" class="form-control">
                                        <option value="">Chọn Học Kỳ</option>
                                        @foreach($semesters as $semester)
                                            <option value="{{ $semester->id }}" {{ old('semester_id', $subjectClass->semester_id) == $semester->id ? 'selected' : '' }}>
                                                {{ $semester->block }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('semester_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                <a href="{{ route('admin.subjectclasses.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection
