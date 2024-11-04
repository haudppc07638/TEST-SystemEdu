@extends('layouts.master')

@section('title', 'Tạo Loại Điểm Mới')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tạo Loại Điểm Mới</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.score_types.index') }}">Loại Điểm</a></li>
                    <li class="breadcrumb-item active">Tạo Mới</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body  mt-3">
                            <form action="{{ route('admin.score_types.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên Điểm Quá Trình</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Loại Điểm</label>
                                    <select name="type" id="type"
                                        class="form-select @error('type') is-invalid @enderror">
                                        <option>-- Chọn loại điểm --</option>
                                        <option value="single" {{ old('type') === 'single' ? 'selected' : '' }}>Single
                                        </option>
                                        <option value="multi" {{ old('type') === 'multi' ? 'selected' : '' }}>Multi
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Lưu</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
