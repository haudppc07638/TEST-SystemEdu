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

        <div class="card">
            <div class="card-body">
                <form class="row g-3 mt-3 needs-validation" novalidate method="POST"
                    action="{{ route('admin.update', $class->id) }}">
                    @csrf
                    @method('PUT')
                    <!-- Chuyên ngành -->
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Chuyên ngành</label>
                        <input type="hidden" name="major_id" value="{{ $class->major_id }}">
                        <input type="text" value="{{ $class->major->name }}" class="form-control" readonly>
                    </div>

                    <!-- Hệ đào tạo -->
                    <div class="col-md-12">
                        <label class="form-label">Hệ đào tạo</label>
                        <select class="form-select @error('training_system') is-invalid @enderror" name="training_system">
                            <option disabled selected>...Chọn hệ đào tạo...</option>
                            <option value="Chính quy" {{ $class->training_system == 'Chính quy' ? 'selected' : '' }}>Chính
                                quy</option>
                            <option value="Vừa làm vừa học"
                                {{ $class->training_system == 'Vừa làm vừa học' ? 'selected' : '' }}>Vừa làm vừa học
                            </option>
                            <option value="Đào tạo từ xa"
                                {{ $class->training_system == 'Đào tạo từ xa' ? 'selected' : '' }}>Đào tạo từ xa</option>
                            <option value="Liên thông" {{ $class->training_system == 'Liên thông' ? 'selected' : '' }}>Liên
                                thông</option>
                        </select>
                        @error('training_system')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tên lớp -->
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Tên lớp</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $class->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Cố vấn -->
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Cố vấn</label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id">
                            <option selected value="{{$class->employee_id}}">{{$class->employee->full_name}}</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ $class->employee_id == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Số lượng tối đa -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Số lượng tối đa</label>
                        <input type="number" id="quantity" class="form-control @error('quantity') is-invalid @enderror"
                            name="quantity" value="{{ old('quantity', $class->quantity) }}" max="60">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ngày bắt đầu -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Ngày bắt đầu</label>
                        <input type="date" id="start_date" class="form-control @error('start_date') is-invalid @enderror"
                            name="start_date" value="{{ old('start_date', $class->start_date) }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nút Submit -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Cập nhật</button>
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
