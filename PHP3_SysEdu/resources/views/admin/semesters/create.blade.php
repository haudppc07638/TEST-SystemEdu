@extends('layouts.master')

@section('title', 'Thêm Học Kỳ')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Thêm học kỳ</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.semesters.index') }}">Học kỳ</a></li>
                    <li class="breadcrumb-item active">Thêm</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body  mt-3">
                            <form class="mt-3" method="POST" action="{{ route('admin.semesters.create.post') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="block" class="col-sm-2 col-form-label">Kỳ</label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('block') is-invalid @enderror" id="block" name="block" value="{{ old('block') }}">
                                    @error('block')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="year" class="col-sm-2 col-form-label">Năm</label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year') }}">
                                        @error('year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="start_date" class="col-sm-2 col-form-label">Ngày bắt đầu</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="end_date" class="col-sm-2 col-form-label">Ngày kết thúc</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                    
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-cBlue">Thêm</button>
                                    </div>
                                </div>
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
