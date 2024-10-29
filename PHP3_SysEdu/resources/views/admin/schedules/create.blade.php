@extends('layouts.master')

@section('title', 'Tạo Lịch Học')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tạo Lịch Tự Động</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Quản Lý</li>
                <li class="breadcrumb-item active">Tạo Lịch Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <form class="row g-3 mt-3 needs-validation" novalidate method="POST" action="{{ route('admin.schedules.create.post') }}">
                @csrf

                <div class="col-md-6">
                    <label for="subject_class_id" class="form-label">Lớp Môn Học: <span class="text-danger">*</span></label>
                    <select name="subject_class_id" id="subject_class_id" class="form-select @error('subject_class_id') is-invalid @enderror" onchange="updateDates(this)">
                        <option disabled selected>Chọn lớp môn học</option>
                        @foreach ($subjectClasses as $subjectClass)
                            <option value="{{ $subjectClass->id }}" 
                                    data-start="{{ $subjectClass->start_date }}" 
                                    data-end="{{ $subjectClass->end_date }}"
                                    @if(old('subject_class_id') == $subjectClass->id) selected @endif>
                                {{ $subjectClass->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="time_slot_id" class="form-label">Khung Giờ: <span class="text-danger">*</span></label>
                    <select name="time_slot_id" id="time_slot_id" class="form-select @error('time_slot_id') is-invalid @enderror">
                        <option disabled selected>Chọn khung giờ</option>
                        @foreach ($timeSlots as $timeSlot)
                            <option value="{{ $timeSlot->id }}"
                                    @if(old('time_slot_id') == $timeSlot->id) selected @endif>
                                {{ $timeSlot->start_time }} - {{ $timeSlot->end_time }}
                            </option>
                        @endforeach
                    </select>
                    @error('time_slot_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="classroom_id" class="form-label">Phòng Học: <span class="text-danger">*</span></label>
                    <select name="classroom_id" id="classroom_id" class="form-select @error('classroom_id') is-invalid @enderror">
                        <option disabled selected>Chọn phòng học</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}"
                                    @if(old('classroom_id') == $classroom->id) selected @endif>
                                {{ $classroom->code }}
                            </option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="schedule_type" class="form-label">Kiểu Lịch: <span class="text-danger">*</span></label>
                    <select name="schedule_type" id="schedule_type" class="form-select @error('schedule_type') is-invalid @enderror" required>
                        <option value="odd" @if(old('schedule_type') == 'odd') selected @endif>Ngày Lẻ (Thứ Hai, Thứ Tư, Thứ Sáu)</option>
                        <option value="even" @if(old('schedule_type') == 'even') selected @endif>Ngày Chẵn (Thứ Ba, Thứ Năm, Thứ Bảy)</option>
                    </select>
                    @error('schedule_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="start_date" class="form-label">Ngày Bắt Đầu: <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="end_date" class="form-label">Ngày Kết Thúc: <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Tạo Lịch</button>
                </div>

            </form>
        </div>
    </div>

</main><!-- End #main -->

@endsection

@push('style')
@endpush

@push('script')
    <script>
        function updateDates(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const startDate = selectedOption.getAttribute('data-start');
            const endDate = selectedOption.getAttribute('data-end');

            document.getElementById('start_date').value = startDate;
            document.getElementById('end_date').value = endDate;
        }
        
        // Cập nhật giá trị khi tải trang lại
        document.addEventListener('DOMContentLoaded', function() {
            const subjectClassSelect = document.getElementById('subject_class_id');
            const selectedOption = subjectClassSelect.options[subjectClassSelect.selectedIndex];
            if (selectedOption) {
                updateDates(subjectClassSelect);
            }
        });
    </script>
@endpush
