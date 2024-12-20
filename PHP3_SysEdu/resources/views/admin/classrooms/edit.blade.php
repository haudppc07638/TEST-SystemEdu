@extends('layouts.master')

@section('title', 'Sửa Phòng Học')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quản lý phòng học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.classrooms.index') }}">Phòng học</a></li>
                <li class="breadcrumb-item active">Sửa phòng học</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <form class="mt-3" method="POST" action="{{ route('admin.classrooms.update', $classroom->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="code" class="col-sm-2 col-form-label">Mã phòng học</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $classroom->code) }}">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="capacity" class="col-sm-2 col-form-label">Sức chứa</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity', $classroom->capacity) }}">
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-cBlue">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection