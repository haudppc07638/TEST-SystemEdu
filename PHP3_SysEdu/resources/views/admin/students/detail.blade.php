@extends('layouts.master')

@section('title', 'Thông tin chi tiết sinh viên')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Thông tin chi tiết sinh viên</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Sinh viên</a></li>
                    <li class="breadcrumb-item active">Thông tin chi tiết sinh viên</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="card">
            <div class="card-body mt-4">
                <!-- Thông tin cơ bản -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-subtitle my-3 fw-bold">Thông tin cá nhân</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="35%">Họ và tên:</th>
                                        <td>{{ $student->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày sinh:</th>
                                        <td>{{ $student->date_of_birth->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Giới tính:</th>
                                        <td>{{ $student->gender ? 'Nam' : 'Nữ' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Số điện thoại:</th>
                                        <td>{{ $student->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dân tộc:</th>
                                        <td>{{ $student->nation }}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ:</th>
                                        <td>
                                            {{ $student->house_number }},
                                            {{ $student->commune_level }},
                                            {{ $student->district }},
                                            {{ $student->provice_city }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-subtitle my-3 fw-bold">Thông tin học tập</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="35%">Mã sinh viên:</th>
                                        <td>{{ $student->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $student->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngành:</th>
                                        <td>{{ $student->major->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Thuộc lớp CN:</th>
                                        <td>{{ $student->stuClass->name }}</td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kết quả học tập -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-subtitle my-3 fw-bold">Kết quả học tập</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Môn học</th>
                                        <th>Lớp học phần</th>
                                        <th>Điểm tổng kết</th>
                                        <th>Xếp loại</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($student->getGroupedSubjectResults() as $subjectId => $attempts)
                                        @php
                                            $subject = $attempts->first()->subjectClass->subject;
                                        @endphp

                                        @foreach ($attempts as $index => $result)
                                            <tr @if ($index > 0) class="table-warning" @endif>
                                                @if ($index === 0)
                                                    <td rowspan="{{ $attempts->count() }}">
                                                        {{ $subject->name }}
                                                        @if ($attempts->count() > 1)
                                                            <br>
                                                            <small class="text-muted">(Học {{ $attempts->count() }}
                                                                lần)</small>
                                                        @endif
                                                    </td>
                                                @endif
                                                <td>{{ $result->subjectClass->name }}</td>
                                                <td class="text-center">
                                                    {{ number_format($result->total_score, 1) }}
                                                </td>
                                                <td class="text-center">
                                                        {{ $result->classification }}
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge bg-{{ $result->status === 'passed' ? 'success' : 'danger' }}">
                                                        {{ $result->status === 'passed' ? 'Pass' : 'Fail' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
