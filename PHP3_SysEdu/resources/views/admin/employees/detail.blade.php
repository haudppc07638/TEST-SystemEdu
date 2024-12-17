@extends('layouts.master')

@section('title', 'Chi tiết nhân sự')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Chi tiết nhân sự: {{ $employee->full_name }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a>Nhân sự</a></li>
                <li class="breadcrumb-item active">Chi tiết nhân sự</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card mb-4 shadow-sm">
        <div class="row g-0">
            <div class="col-md-4 text-center bg-light d-flex align-items-center justify-content-center">
                <img src="{{ $employee->image ? asset('storage/avatars/' . $employee->image) : asset('assets/images/default-avatar1.jpg') }}"
                    alt="Avatar" class="img-fluid rounded-circle" style="width: 200px; height: 200px;">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="title text-center m-2">Thông tin cá nhân</h3>
                    <h5 class="card-title">{{ $employee->full_name }}</h5>
                    <p class="card-text"><strong>Email:</strong> {{ $employee->email }}</p>
                    <p class="card-text"><strong>Mã số nhân sự:</strong> {{ $employee->code }}</p>
                    <p class="card-text"><strong>Số điện thoại:</strong> {{ $employee->phone }}</p>
                    <p class="card-text"><strong>Chức vụ:</strong> {{ $employee->position }}</p>
                    <p class="card-text"><strong>Giới tính:</strong> {{ $employee->gender == 1 ? 'Nam' : 'Nữ' }}</p>
                    <p class="card-text"><strong>Khoa:</strong> {{ $employee->department->name }}</p>
                    <p class="card-text"><strong>Chuyên ngành:</strong> {{ $employee->major->name }}</p>
                    <p class="card-text"><strong>Ngày sinh: {{ $employee->date_of_birth }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h6 class="mb-0">Thông tin chi tiết</h6>
        </div>
        <div class="card-body">
            <div class="row m-3">
                <div class="col-md-6">
                    <p><strong>Trình độ học vấn:</strong> {{ $employee->educational_level }}</p>
                    <p><strong>Quốc tịch:</strong> {{ $employee->nation }}</p>
                    <p><strong>Số CMND/CCCD:</strong> {{ $employee->identity_card }}</p>
                    <p><strong>Ngày cấp:</strong> {{ $employee->card_issuance_date }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nơi cấp:</strong> {{ $employee->card_location }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $employee->house_number }}, {{ $employee->commune_level }},
                        {{ $employee->district }}, {{ $employee->provice_city }}</p>
                    <p><strong>Ngày sinh:</strong> {{ $employee->date_of_birth }}</p>
                    <div class="d-flex">
                        <p class="card-text mb-0">
                            <strong>Môn dạy:</strong>
                            <span id="selected-subjects"> 
                                {{ implode(' | ', $nameSubject) }}
                            </span>
                        </p>
                        <p class="card-text px-2">
                            <i class="bx bx-edit fs-4" id="edit-button" style="cursor: pointer;"></i>
                        </p>
                    </div>
                    <form id="subject-form" action="{{ route('admin.employees.updateSubjects', $employee->id) }}" method="POST">
                        @csrf
                        <div class="row mb-3" id="subject-selection" style="display: none;">
                            <label for="prerequisites" class="col-sm-2 col-form-label">Môn học</label>
                            <div class="col-sm-10">
                                <select name="subjects[]" class="form-select" id="prerequisites" multiple style="width: 100%; min-height: 100px;">
                                    @foreach ($subjects as $subjectOption)
                                        <option value="{{ $subjectOption->id }}"
                                            {{ in_array($subjectOption->id, $employeeSubjects) ? 'selected' : '' }}>
                                            {{ $subjectOption->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subjects')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <button type="submit" class="btn btn-primary mt-2">Lưu</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
    $(document).ready(function() {
    // Khởi tạo Select2
    $('#prerequisites').select2({
        placeholder: "Chọn môn học",
        allowClear: true,
        minimumResultsForSearch: Infinity
    });

    // Cập nhật danh sách môn đã chọn khi có sự thay đổi
    $('#prerequisites').on('change', function() {
        let subjects = $(this).val();
        $('#selected-subjects').text(subjects ? subjects.join(', ') : '');
    });

    // Cập nhật giá trị đã chọn khi mở phần chỉnh sửa
    $('#edit-button').click(function() {
        $('#subject-selection').toggle();
        let subjects = $('#prerequisites').val();
        $('#selected-subjects').text(subjects ? subjects.join(', ') : '');
    });
});

</script>
@endpush
