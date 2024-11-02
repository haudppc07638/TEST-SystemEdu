@extends('layouts.master')

@section('title', 'Thêm Lớp Học')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Thêm Lớp Học</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjectclasses.index') }}">Lớp Học</a></li>
                    <li class="breadcrumb-item active">Thêm Mới</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.subjectclasses.create.post') }}" class="mt-3">
                                @csrf

                                <div class="mb-3">
                                    <label for="subject_id" class="form-label">Môn Học</label>
                                    <select id="subject_id" name="subject_id" class="form-select select2">
                                        <option value="" disabled selected>Chọn Môn</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">
                                                {{ $subject->major ? $subject->major->name : 'Bộ môn cơ bản' }} |
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="employee_id" class="form-label">Giảng Viên</label>
                                    <select id="employee_id" name="employee_id" class="form-select select2">
                                        <option value="" disabled selected>Chọn Giảng Viên</option>
                                    </select>
                                    @error('employee_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="major_class_id" class="form-label">Lớp Chuyên Nghành</label>
                                    <select id="major_class_id" name="major_class_id" class="form-select select2">
                                        <option value="" disabled selected>Chọn Lớp CN</option>
                                    </select>
                                    @error('major_class_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Tên Lớp</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="quantity" class="col-sm-2 col-form-label">Số lượng</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="quantity" id="quantity" class="form-control"
                                            value="{{ old('quantity') }}">
                                        @error('quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="credit_id" class="col-sm-2 col-form-label">Giá (1TC)</label>
                                    <div class="col-sm-10">
                                        <select name="credit_id" id="credit_id" class="form-control @error('credit_id') is-invalid @enderror">
                                            <option value="">Chọn Giá TC</option>
                                            @foreach ($credits as $credit)
                                                <option value="{{ $credit->id }}" data-total-price="{{ $credit->total_price }}"
                                                    {{ old('credit_id') == $credit->id ? 'selected' : '' }}>
                                                    {{ $credit->total_price }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('credit_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="credit_price" class="col-sm-2 col-form-label">Giá Tín Chỉ (Hiện tại)</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="credit_price" id="credit_price" class="form-control"
                                            value="{{ old('credit_price') }}" readonly>
                                        @error('credit_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="semester_id" class="col-sm-2 col-form-label">Học kỳ</label>
                                    <div class="col-sm-10">
                                        <select name="semester_id" id="semester_id" class="form-control">
                                            <option value="">Chọn Học Kỳ</option>
                                            @foreach ($semesters as $semester)
                                                <option value="{{ $semester->id }}"
                                                    {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                                    {{ $semester->block }} - {{ $semester->year }}
                                                </option>
                                            @endforeach
                                        </select>   
                                        @error('semester_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="registration_deadline" class="col-sm-2 col-form-label">Ngày hết hạn đăng
                                        ký</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="registration_deadline" id="registration_deadline"
                                            class="form-control" value="{{ old('registration_deadline') }}">
                                        @error('registration_deadline')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="start_date" class="col-sm-2 col-form-label">Ngày bắt đầu</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                            value="{{ old('start_date') }}">
                                        @error('start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="end_date" class="col-sm-2 col-form-label">Ngày kết thúc</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                            value="{{ old('end_date') }}">
                                        @error('end_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    <a href="{{ route('admin.subjectclasses.index') }}" class="btn btn-secondary">Hủy</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: "Chọn",
                allowClear: true
            });

            $('#subject_id').on('change', function() {
                const subjectId = $(this).val();
                $('#employee_id').val(null).trigger('change');
                $('#major_class_id').val(null).trigger('change');
                loadLecturers(subjectId);
                loadMajorClasses(subjectId);
            })

            function loadLecturers(subjectId) {
                $.ajax({
                    url: '{{ route('admin.lecturers.by.subject') }}',
                    type: 'GET',
                    data: {
                        subject_id: subjectId
                    },
                    success: function(lecturers) {
                        let options = '<option value="" disabled selected>Chọn Giảng Viên</option>';
                        lecturers.forEach(lecturer => {
                            options +=
                                `<option value="${lecturer.id}">${lecturer.full_name}</option>`;
                        });
                        $('#employee_id').html(options).trigger('change');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Không thể tải giảng viên. Vui lòng thử lại.');
                    }
                });
            }

            function loadMajorClasses(subjectId) {
                $.ajax({
                    url: '{{ route('admin.majorclasses.by.subject') }}',
                    type: 'GET',
                    data: {
                        subject_id: subjectId
                    },
                    success: function(classes) {
                        let options = '<option value="" disabled selected>Chọn Lớp CN</option>';
                        classes.forEach(majorClass => {
                            options +=
                                `<option value="${majorClass.id}">${majorClass.name}</option>`;
                        });
                        $('#major_class_id').html(options).trigger('change');
                    }
                });
            }
        });
    document.addEventListener('DOMContentLoaded', function () {
        const creditSelect = document.getElementById('credit_id');
        const creditPriceInput = document.getElementById('credit_price');

        creditSelect.addEventListener('change', function () {
            const selectedOption = creditSelect.options[creditSelect.selectedIndex];
            const totalPrice = selectedOption.getAttribute('data-total-price');

            creditPriceInput.value = totalPrice || '';
        });
    });
    </script>
@endpush
