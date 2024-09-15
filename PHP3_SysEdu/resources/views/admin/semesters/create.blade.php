@extends('layouts.master')

@section('title', 'Thêm Học Kỳ')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Thêm Học Kỳ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.semesters.index') }}">Học Kỳ</a></li>
                <li class="breadcrumb-item active">Thêm</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    
                <div class="card">
                    <div class="card-body">
                        <form class="mt-3" method="POST" action="{{ route('admin.semesters.create.post') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="block" class="col-sm-2 col-form-label">Kỳ</label>
                                <input type="text" class="form-control @error('block') is-invalid @enderror" id="block" name="block" value="{{ old('block') }}" >
                                @error('block')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="year" class="col-sm-2 col-form-label">Năm</label>
                                <input type="date" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year') }}" >
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                            <a href="{{ route('admin.semesters.index') }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
      

</main><!-- End #main -->
@endsection

@push('style')
@endpush

@push('script')
@endpush
