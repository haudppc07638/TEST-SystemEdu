@extends('layouts.master')

@section('title', 'Classes')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản Lý Lớp</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Khoa</li>
                    <li class="breadcrumb-item">Chuyên ngành</li>
                    <li class="breadcrumb-item">Lớp chuyên ngành </li>
                    <li class="breadcrumb-item active">Sửa thông tin lớp chuyên ngành</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        {{-- {{dd($class->id)}} --}}

        <div class="card">
            <div class="card-body">
                <form class="row g-3 mt-3 needs-validation" novalidate method="POST"
                    action="{{ route('admin.update', $class->id) }}">
                    @csrf
                    @method('PUT')
                    <!-- Hệ đào tạo -->
                    <div class="col-md-12">
                        <label class="form-label">Hệ đào tạo</label>
                        <input type="text" class="form-control @error('trainingsystem') is-invalid @enderror"
                            name="trainingsystem" value="{{ $class->trainingsystem }}">
                        @error('trainingsystem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tên -->
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Tên</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ $class->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Chuyên ngành -->
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Chuyên ngành</label>
                        <input type="hidden" name="major_id" value="{{ $class->major->id }}">
                        <input type="text" value='{{ $class->major->name }}' class="form-control" readonly>
                    </div>

                    <!-- Chủ nhiệm -->
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Chủ nhiệm</label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id">
                            <option disabled selected>Chọn chủ nhiệm...</option>


                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ $employee->id == old('employee_id', $class->employee_id) ? 'selected' : '' }}>
                                    {{ $employee->fullname }}
                                </option>
                            @endforeach

                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nút Submit -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Lưu</button>
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
