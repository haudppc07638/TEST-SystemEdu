@extends('layouts.master')

@section('title', 'Classes')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản lý lớp</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.classes.index') }}">Lớp Chuyên ngành</a></li>
                <li class="breadcrumb-item active">Thêm lớp chuyên ngành</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <form class="row g-3 mt-3 needs-validation" novalidate method="POST" action="{{ route('admin.classes.create.post') }}">
                @csrf

                <!-- Chuyên ngành -->
                <div class="col-md-12 mb-2">
                    <label class="form-label">Chuyên ngành</label>
                    <select class="form-select @error('major_id') is-invalid @enderror" name="major_id">
                        <option disabled selected>...Chọn chuyên ngành...</option>
                        @foreach ($major as $major)
                            <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tên lớp -->
                <div class="col-md-12 mb-2">
                    <label class="form-label">Tên lớp</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Cố vấn -->
                <div class="col-md-12 mb-2">
                    <label class="form-label">Cố vấn</label>
                    <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id">
                        <option disabled selected>...Chọn cố vấn...</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số lượng tối đa -->
                <div class="col-md-12 mb-2">
                    <label class="form-label">Số lượng tối đa</label>
                    <input type="number" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                           name="quantity" value="{{ old('quantity') }}" max="60">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ngày bắt đầu -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                           name="start_date" value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ngày kết thúc -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                           name="end_date" value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nút Submit -->
                <div class="col-12 d-flex">
                    <button type="submit" class="btn btn-cBlue">Thêm</button>
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
