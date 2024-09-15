@extends('layouts.master')

@section('title', 'schedules')

@section('main')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản Lý Nhân Sự</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Đào tạo</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">Nhân sự</a></li>
                    <li class="breadcrumb-item active">Cập nhập thông tin nhân sự</li>
                </ol>
            </nav>
        </div>
    
        <div class="card">
            <div class="card-body">
                <form class="row g-3 mt-3 needs-validation" 
                novalidate 
                method="POST"
                action="{{ route('admin.employees.update',$employee->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <!-- Họ và tên -->
                    <div class="col-md-6">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname"
                            value="{{ $employee->fullname }}">
                        @error('fullname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ $employee->email }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
      
                    <!-- Số điện thoại -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ $employee->phone }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Khoa -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Khoa</label>
                        <select class="form-select @error('faculty_id') is-invalid @enderror" name="faculty_id">
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}"
                                    {{ $employee->faculty_id == $faculty->id ? 'selected' : '' }}>
                                    {{ $faculty->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Chức vụ -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Chức vụ</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="position" id="positionTeacher"
                                value="Giáo viên" {{ $employee->position == 'Giáo viên' ? 'checked' : '' }}>
                            <label class="form-check-label" for="positionTeacher">
                                Giáo viên
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="position" id="positionOfficer"
                                value="Cán bộ đào tạo" {{ $employee->position == 'Cán bộ đào tạo' ? 'checked' : '' }}>
                            <label class="form-check-label" for="positionOfficer">
                                Cán bộ đào tạo
                            </label>
                        </div>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ảnh -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Ảnh</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6" class="align-middle">
                                <img src="{{ asset('storage/avatars/' . $employee->image) }}" alt="avatar" class="rounded-circle" width="100px" height="100px">
                            </div>
                        </div>
                    </div>

                    <!-- Phòng Ban -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Phòng Ban</label>
                        <select class="form-select @error('department_id') is-invalid @enderror" name="department_id">
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
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
