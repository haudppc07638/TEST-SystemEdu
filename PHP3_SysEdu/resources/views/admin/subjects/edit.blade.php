@extends('layouts.master')

@section('title', 'Chỉnh Sửa Môn Học')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Chỉnh Sửa Môn Học</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">Môn</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Sử dụng PUT cho việc cập nhật -->

                                <br>
                                <div class="row mb-3">
                                    <label for="major_id" class="col-sm-2 col-form-label">Chuyên ngành</label>
                                    <div class="col-sm-10">
                                        <select name="major_id" class="form-select" id="major_id">
                                            <option value="">Môn cơ bản</option>
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}"
                                                    {{ old('major_id', $subject->major_id) == $major->id ? 'selected' : '' }}>
                                                    {{ $major->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('major_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Tên môn học</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name', $subject->name) }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="code" class="col-sm-2 col-form-label">Mã môn học</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="code" class="form-control" id="code"
                                            value="{{ old('code', $subject->code) }}">
                                        @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="credit" class="col-sm-2 col-form-label">Tín Chỉ</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="credit" class="form-control" id="credit"
                                            value="{{ old('credit', $subject->credit) }}" min="1" step="1">
                                        @error('credit')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="prerequisites" class="col-sm-2 col-form-label">Môn tiên quyết</label>
                                    <div class="col-sm-10">
                                        <select name="prerequisites[]" class="form-select" id="prerequisites" multiple>
                                            @foreach ($subjects as $subjectOption)
                                                <option value="{{ $subjectOption->id }}"
                                                    {{ in_array($subjectOption->id, $subject->prerequisites->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $subjectOption->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('prerequisites')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="description" class="col-sm-2 col-form-label">Mô tả</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" class="form-control" rows="5" id="description">{{ old('description', $subject->description) }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Cập nhật</button>
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
    <script>
        $(document).ready(function() {
            $('#prerequisites').select2({
                placeholder: "Chọn môn tiên quyết",
                allowClear: true
            });
        });
    </script>
@endpush
