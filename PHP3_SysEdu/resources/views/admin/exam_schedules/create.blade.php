@extends('layouts.master')

@section('title', 'Tạo Lịch Thi')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tạo Lịch Thi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Quản Lý</li>
                <li class="breadcrumb-item active">Tạo Lịch Thi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <form class="row g-3 mt-3 needs-validation" novalidate method="POST" action="{{ route('admin.examschedules.store') }}">
                @csrf

                <!-- Lớp Môn Học - Chỉ Đọc -->
                <div class="col-md-6">
                    <label for="subject_class_id" class="form-label">Lớp Môn Học: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('subject_class_id') is-invalid @enderror" value="{{ $subjectClass->name }}" readonly>
                    <input type="hidden" name="subject_class_id" value="{{ $subjectClassId }}">
                    @error('subject_class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Thời Gian Thi -->
                <div class="col-md-6">
                    <label for="schedule_id" class="form-label">Ngày Thi: <span class="text-danger">*</span></label>
                    <select name="schedule_id" id="schedule_id" class="form-select @error('schedule_id') is-invalid @enderror" required>
                        <option disabled selected>Chọn Ngày Thi</option>
                        @foreach ($lastSchedules as $schedule)
                            <option value="{{ $schedule->id }}" @if(old('schedule_id') == $schedule->id) selected @endif>
                                {{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }} ({{ $schedule->timeSlot->start_time }} - {{ $schedule->timeSlot->end_time }})
                            </option>
                        @endforeach
                    </select>
                    @error('schedule_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Giáo Viên -->
                <div class="col-md-6">
                    <label for="teacher_1" class="form-label">Giáo Viên 1: <span class="text-danger">*</span></label>
                    <select name="teacher_1" id="teacher_1" class="form-select @error('teacher_1') is-invalid @enderror" required style="width: 100%; min-height: 150px;">
                        <option disabled selected>Chọn Giáo Viên 1</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @if(old('teacher_1') == $teacher->id) selected @endif>
                                {{ $teacher->full_name }} - {{ $teacher->code }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="teacher_2" class="form-label">Giáo Viên 2:</label>
                    <select name="teacher_2" id="teacher_2" class="form-select @error('teacher_2') is-invalid @enderror" style="width: 100%; min-height: 150px;">
                        <option disabled selected>Chọn Giáo Viên 2 (Nếu có)</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @if(old('teacher_2') == $teacher->id) selected @endif>
                                {{ $teacher->full_name }} - {{ $teacher->code }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sinh Viên -->
                <div class="col-md-12">
                    <label for="student_ids" class="form-label">Chọn Sinh Viên: <span class="text-danger">*</span></label>
                    <select name="student_ids[]" id="student_ids" class="form-select @error('student_ids') is-invalid @enderror" multiple required style="width: 100%; min-height: 150px;">
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @if(in_array($student->id, old('student_ids', []))) selected @endif>
                                {{ $student->full_name }} - {{ $student->code }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_ids')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>                

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Tạo Lịch Thi</button>
                </div>
            </form>
        </div>
    </div>

</main><!-- End #main -->
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Apply Select2 to teacher selects
        $('#teacher_1, #teacher_2').select2({
            placeholder: 'Chọn giáo viên',
            allowClear: true
        });

        // Apply Select2 to student select
        $('#student_ids').select2({
            placeholder: 'Chọn sinh viên',
            allowClear: true
        });
    });
</script>
@endpush
