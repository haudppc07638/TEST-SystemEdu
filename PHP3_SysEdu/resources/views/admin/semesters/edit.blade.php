@extends('layouts.master')

@section('title', 'Sửa Học Kỳ')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Sửa Học Kỳ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.semesters.index') }}">Học Kỳ</a></li>
                <li class="breadcrumb-item active">Sửa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form class="mt-3" method="POST" action="{{ route('admin.semesters.update', $semester->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="block" class="form-label">Kỳ</label>
                                <input type="text" class="form-control @error('block') is-invalid @enderror" id="block" name="block" value="{{ old('block', $semester->block) }}">
                                @error('block')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Năm</label>
                                <input type="date" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', $semester->year) }}">
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                            <a href="{{ route('admin.semesters.index') }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection

@push('style')
@endpush

@push('script')
@endpush
