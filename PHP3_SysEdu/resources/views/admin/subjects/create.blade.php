@extends('layouts.master')

@section('title', 'Thêm Mới Môn Học')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Thêm mới môn học</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">Môn</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.subjects.create.post') }}" method="POST">
                                @csrf
                                <br>
                                <div class="row mb-3">
                                    <label for="major_id" class="col-sm-2 col-form-label">Chuyên ngành</label>
                                    <div class="col-sm-10">
                                        <select name="major_id" class="form-select" id="major_id">
                                            <option value="">...Chọn chuyên ngành...</option>
                                            <option value="">Môn cơ bản</option>
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}"
                                                    {{ old('major_id') == $major->id ? 'selected' : '' }}>
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
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="code" class="col-sm-2 col-form-label">Mã môn học</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="code" class="form-control" id="code"
                                            value="{{ old('code') }}">
                                        @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="credit" class="col-sm-2 col-form-label">Tín chỉ</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="credit" class="form-control" id="credit"
                                            value="{{ old('credit') }}" min="1" step="1">
                                        @error('credit')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3" id="score_weights">
                                    <label for="score_types" class="form-label">Chọn loại điểm và trọng số</label>
                                    <div class="row">
                                        @foreach ($scoreTypes as $scoreType)
                                            <div class="col-md-3 mt-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input score-type-checkbox"
                                                        id="score_type_{{ $scoreType->id }}" name="score_types[]"
                                                        value="{{ $scoreType->id }}"
                                                        {{ in_array($scoreType->id, old('score_types', [])) ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="score_type_{{ $scoreType->id }}">
                                                        {{ $scoreType->name }}
                                                    </label>

                                                    <input type="number" name="weights[{{ $scoreType->id }}]"
                                                        class="form-control mt-2 weight-input" placeholder="Trọng số (%)"
                                                        min="0" max="100"
                                                        value="{{ old('weights.' . $scoreType->id) }}"
                                                        {{ in_array($scoreType->id, old('score_types', [])) ? '' : 'disabled' }}>

                                                    @if ($scoreType->type === 'multi')
                                                        <input type="number" name="sub_scores[{{ $scoreType->id }}]"
                                                            class="form-control mt-2 sub-score-input"
                                                            placeholder="Số lượng {{ $scoreType->name }}" min="1"
                                                            value="{{ old('sub_scores.' . $scoreType->id) }}"
                                                            {{ in_array($scoreType->id, old('score_types', [])) ? '' : 'disabled' }}>
                                                    @endif

                                                    @error('weights.' . $scoreType->id)
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                    @if ($scoreType->type === 'multi')
                                                        @error('sub_scores.' . $scoreType->id)
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach

                                        @error('score_types')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                        @error('weights')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="prerequisites" class="col-sm-2 col-form-label">Môn tiên quyết</label>
                                    <div class="col-sm-10">
                                        <select name="prerequisites[]" class="form-select" id="prerequisites" multiple>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ in_array($subject->id, old('prerequisites', [])) ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="description" class="col-sm-2 col-form-label">Mô tả</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" rows='5' class="form-control id="description"
                                            placeholder="Nhập mô tả về môn học">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">Thêm mới</button>
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

            $('#score_types').select2({
                placeholder: "Chọn loại điểm",
                allowClear: true
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.score-type-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const weightInput = this.closest('.form-check').querySelector('.weight-input');
                    const subScoreInput = this.closest('.form-check').querySelector(
                        '.sub-score-input');

                    if (this.checked) {
                        weightInput.removeAttribute('disabled');
                        if (subScoreInput) subScoreInput.removeAttribute('disabled');
                    } else {
                        weightInput.setAttribute('disabled', 'disabled');
                        if (subScoreInput) subScoreInput.setAttribute('disabled', 'disabled');
                    }
                });
            });
        });
    </script>
@endpush
