@extends('layouts.master')

@section('title', 'Chi tiết sinh viên')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Chi tiết sinh viên: {{ $student->full_name }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a>Sinh viên</a></li>
                <li class="breadcrumb-item active">Chi tiết sinh viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card mb-4 shadow-sm">
        <div class="row g-0">
            <div class="col-md-4 text-center bg-light d-flex align-items-center justify-content-center">
                <img src="{{ $student->image ? asset('storage/avatars/' . $student->image) : asset('assets/images/default-avatar1.jpg') }}"
                    alt="Avatar" class="img-fluid rounded-circle" style="width: 200px; height: 200px;">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="title text-center m-2">Thông tin cá nhân</h3>
                    <h5 class="card-title">{{ $student->full_name }}</h5>
                    <p class="card-text"><strong>Email:</strong> {{ $student->email }}</p>
                    <p class="card-text"><strong>Mã số sinh viên:</strong> {{ $student->code }}</p>
                    <p class="card-text"><strong>Số điện thoại:</strong> {{ $student->phone }}</p>
                    <p class="card-text"><strong>Giới tính:</strong> {{ $student->gender == 1 ? 'Nam' : 'Nữ' }}</p>
                    <p class="card-text"><strong>Chuyên ngành:</strong> {{ $student->major->name }}</p>
                    <p class="card-text"><strong>Lớp:</strong> {{ $student->stuClass->name ?? 'Chưa có lớp học' }}</p>
                    <p class="card-text"><strong>Ngày sinh:</strong> {{ $student->date_of_birth }}</p>
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
                    <p><strong>Quốc tịch:</strong> {{ $student->nation }}</p>
                    <p><strong>Số CMND/CCCD:</strong> {{ $student->identity_card }}</p>
                    <p><strong>Ngày cấp:</strong> {{ $student->card_issuance_date }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nơi cấp:</strong> {{ $student->card_location }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $student->house_number }}, {{ $student->commune_level }},
                        {{ $student->district }}, {{ $student->provice_city }}</p>
                    <p><strong>Người bảo trợ:</strong> {{ $student->sponsor_name }} - {{ $student->sponsor_phone }}</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
    // $(document).ready(function() {
    //     $('#subjects').select2({
    //         placeholder: "Chọn môn học",
    //         allowClear: true,
    //         minimumResultsForSearch: Infinity
    //     });

    //     $('#subjects').on('change', function() {
    //         let subjects = $(this).val();
    //         $('#selected-subjects').text(subjects ? subjects.join(', ') : '');
    //     });

    //     $('#edit-button').click(function() {
    //         $('#subject-selection').toggle();
    //         let subjects = $('#subjects').val();
    //         $('#selected-subjects').text(subjects ? subjects.join(', ') : '');
    //     });
    // });
</script>
@endpush
