@extends('layouts.master')

@section('title', 'Chi tiết sinh viên xét tuyển')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản lý đăng ký tuyển sinh</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.enrollments.index') }}">Đăng ký tuyển sinh</a></li>
                <li class="breadcrumb-item active">Chi tiết</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin chi tiết sinh viên</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <label class="fw-bold">Họ và tên:</label>
                                    <p>{{ $enrollment->full_name }}</p>

                                    <label class="fw-bold">Ngày sinh:</label>
                                    <p>{{ $enrollment->date_of_birth }}</p>

                                    <label class="fw-bold">Giới tính:</label>
                                    <p>{{ $enrollment->gender == 1 ? 'Nữ' : 'Nam' }}</p>

                                    <label class="fw-bold">Dân tộc:</label>
                                    <p>{{ $enrollment->nation }}</p>

                                    <label class="fw-bold">Số CMND/CCCD:</label>
                                    <p>{{ $enrollment->identity_card }}</p>

                                    <label class="fw-bold">Ngày cấp:</label>
                                    <p>{{ $enrollment->card_issuance_date }}</p>

                                    <label class="fw-bold">Nơi cấp:</label>
                                    <p>{{ $enrollment->card_location }}</p>

                                    <label class="fw-bold">Tỉnh/Thành phố:</label>
                                    <p>{{ $enrollment->province_city }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <label class="fw-bold">Quận/Huyện:</label>
                                    <p>{{ $enrollment->district }}</p>

                                    <label class="fw-bold">Xã/Phường:</label>
                                    <p>{{ $enrollment->commune_level }}</p>

                                    <label class="fw-bold">Số điện thoại:</label>
                                    <p>{{ $enrollment->phone }}</p>

                                    <label class="fw-bold">Email:</label>
                                    <p>{{ $enrollment->email }}</p>

                                    <label class="fw-bold">Tên người bảo trợ:</label>
                                    <p>{{ $enrollment->sponsor_name }}</p>

                                    <label class="fw-bold">Số điện thoại người bảo trợ:</label>
                                    <p>{{ $enrollment->sponsor_phone }}</p>

                                    <label class="fw-bold">Người nhận:</label>
                                    <p>
                                        @if ($enrollment->recipient === 'student')
                                        Thí sinh
                                        @else
                                        Phụ huynh
                                        @endif
                                    </p>

                                    <label class="fw-bold">Địa chỉ nhận:</label>
                                    <p>
                                        @if ($enrollment->residence_address === 'địa chỉ thường trú')
                                        Địa chỉ thường trú
                                        @else
                                        Tại trường
                                        @endif
                                    </p>

                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="card-title">Thông tin xét tuyển</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <label class="fw-bold">Nguyện vọng 1:</label>
                                    <p>
                                        {{ $enrollment->firstMajor->name }}
                                        ({{ $enrollment->application_method_1 == 'grade_score' ? 'Xét học bạ' : 'Xét điểm thi' }})
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <label class="fw-bold">Nguyện vọng 2:</label>
                                    <p>
                                        @if ($enrollment->second_major_id)
                                        {{ $enrollment->secondMajor->name }}
                                        ({{ $enrollment->application_method_2 == 'grade_score' ? 'Xét học bạ' : 'Xét điểm thi' }})
                                        @else
                                        Không đăng ký
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="card-title">Tốt nghiệp</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <label class="fw-bold">Năm tốt nghiệp:</label>
                                    <p>{{ $enrollment->year_graduation }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <label class="fw-bold">Địa chỉ tốt nghiệp:</label>
                                    <p>
                                        {{ $enrollment->province_city_graduate }},
                                        {{ $enrollment->district_graduate }},
                                        {{ $enrollment->commune_level_graduate }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection

@push('style')
<style>
    .info-box {
        border: 1px solid #ddd;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 5px;
    }
</style>
@endpush