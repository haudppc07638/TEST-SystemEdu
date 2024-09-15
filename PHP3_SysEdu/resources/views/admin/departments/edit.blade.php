@extends('layouts.master')

@section('title', 'Edit Departments')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản Lý Phòng Ban</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Đào Tạo</li>
                <li class="breadcrumb-item"><a href="{{route('admin.departments.index')}}">Phòng ban</a></li>
                <li class="breadcrumb-item active">Sửa Phòng Ban</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <form class="row g-3 mt-3 needs-validation" 
                novalidate 
                method="POST" 
                action="{{ route('admin.departments.update', $department->id)}}"
            >
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <label class="form-label">Tên phòng ban</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror"
                           name="name" 
                           value="{{ $department->name }}">
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mb-2">
                    <label class="form-label">Vị trí</label>
                    <input type="text" 
                           class="form-control @error('location') is-invalid @enderror" 
                           name="location" 
                           value="{{ $department->location }}">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
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
