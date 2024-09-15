@extends('layouts.master')

@section('timeslots', 'Sửa Thời Gian')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quản Lý Thời Gian</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Thời Gian</li>
                <li class="breadcrumb-item active">Sửa Thời Gian</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <form class="mt-3" method="POST" action="{{ route('admin.timeslots.update', $timeSlot->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="slot" class="col-sm-2 col-form-label">Ca</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('slot') is-invalid @enderror" id="slot" name="slot" value="{{ old('slot', $timeSlot->slot) }}">
                        @error('slot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="start_time" class="col-sm-2 col-form-label">Thời Gian Bắt Đầu</label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', $timeSlot->start_time) }}">
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="end_time" class="col-sm-2 col-form-label">Thời Gian Kết Thúc</label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', $timeSlot->end_time) }}">
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
@push('style')
@endpush

@push('script')
@endpush
