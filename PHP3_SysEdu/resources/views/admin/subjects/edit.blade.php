@extends('layouts.master')

@section('title', 'Chỉnh Sửa Môn Học')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Chỉnh sửa môn học</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">Môn học</a></li>
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
                                            <option value="">Cơ bản</option>
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
                                    <label for="credit" class="col-sm-2 col-form-label">Tín chỉ</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="credit" class="form-control" id="credit"
                                            value="{{ old('credit', $subject->credit) }}" min="1" step="1">
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
                                                        {{ in_array($scoreType->id, old('score_types', [])) || $subject->scoreTypes->contains($scoreType->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="score_type_{{ $scoreType->id }}">
                                                        {{ $scoreType->name }}
                                                    </label>

                                                    @php
                                                        if ($scoreType->type === 'multi') {
                                                            // Tính tổng weight cho loại điểm đa thành phần
                                                            $totalWeight = $subject
                                                                ->scoreTypes()
                                                                ->where('score_type_id', $scoreType->id)
                                                                ->sum('subject_score_types.weight');
                                                        } else {
                                                            $totalWeight =
                                                                $subject->scoreTypes->find($scoreType->id)->pivot
                                                                    ->weight ?? '';
                                                        }
                                                    @endphp

                                                    <input type="number" name="weights[{{ $scoreType->id }}]"
                                                        class="form-control mt-2 weight-input" placeholder="Trọng số (%)"
                                                        min="0" max="100"
                                                        value="{{ old('weights.' . $scoreType->id, $totalWeight) }}"
                                                        {{ in_array($scoreType->id, old('score_types', [])) || $subject->scoreTypes->contains($scoreType->id) ? '' : 'disabled' }}>

                                                    @if ($scoreType->type === 'multi')
                                                        @php
                                                            $subCount = $subject
                                                                ->scoreTypes()
                                                                ->where('score_type_id', $scoreType->id)
                                                                ->count();
                                                        @endphp
                                                        <input type="number" name="sub_scores[{{ $scoreType->id }}]"
                                                            class="form-control mt-2 sub-score-input"
                                                            placeholder="Số lượng {{ $scoreType->name }}" min="1"
                                                            value="{{ old('sub_scores.' . $scoreType->id, $subCount) }}"
                                                            {{ in_array($scoreType->id, old('score_types', [])) || $subject->scoreTypes->contains($scoreType->id) ? '' : 'disabled' }}>
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

                                <button type="submit" class="btn btn-cBlue">Cập nhật</button>
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
            $('.score-type-checkbox').on('change', function() {
                let scoreTypeId = $(this).val();
                let weightInput = $(`input[name='weights[${scoreTypeId}]']`);
                let subScoreInput = $(`input[name='sub_scores[${scoreTypeId}]']`);

                if ($(this).is(':checked')) {
                    weightInput.prop('disabled', false);
                    subScoreInput.prop('disabled', false);
                } else {
                    weightInput.prop('disabled', true).val('');
                    subScoreInput.prop('disabled', true).val(1);
                }
            });

            $('#prerequisites').select2({
                placeholder: "Chọn môn tiên quyết",
                allowClear: true
            });

            $('#score_types').select2({
                placeholder: "Chọn loại điểm",
                allowClear: true
            });
        });
    </script>
@endpush
