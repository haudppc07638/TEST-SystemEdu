@extends('layouts.master')

@section('title', 'Chi tiết lớp')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Chi tiết lớp: {{ $class->name }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a>Lớp chuyên ngành</a></li>
                    <li class="breadcrumb-item active">Chi tiết lớp</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thông tin lớp</h5>
                <p><strong>Chuyên ngành:</strong> {{ $class->major->name }}</p>
                <p><strong>Hệ đào tạo:</strong> {{ $class->training_system }}</p>
                <p><strong>Số lượng tối đa:</strong> {{ $class->quantity }}</p>
                <p><strong>Ngày bắt đầu:</strong> {{ $class->start_date }}</p>
                <p><strong>Ngày kết thúc:</strong> {{ $class->end_date }}</p>
                <p>
                    <strong>Trạng thái:</strong>
                    @if ($class->status == 0)
                        Đang học
                    @elseif ($class->status == 1)
                        Kết thúc
                    @endif
                </p>
                <p><strong>Cố vấn:</strong> {{ $class->employee->full_name }}</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Danh sách sinh viên</h5>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>MSV</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $student->code }}</td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($students->isEmpty())
                    <p class="text-center">Không có sinh viên nào trong lớp này.</p>
                @endif
            </div>
        </div>

    </main><!-- End #main -->
@endsection

@push('style')
@endpush

@push('script')
@endpush
