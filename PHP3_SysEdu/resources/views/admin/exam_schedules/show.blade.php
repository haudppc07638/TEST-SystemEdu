@extends('layouts.master')

@section('title', 'Chi Tiết Lịch Thi')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chi Tiết Lịch Thi Của Lớp: {{ $examSchedule->schedule->subjectClass->name }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.subjectclasses.index') }}">Lớp môn</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.examschedules.index', ['subject_class_id' => $examSchedule->schedule->subject_class_id]) }}">Danh sách lịch thi</a></li>
                <li class="breadcrumb-item active">Chi Tiết Lịch Thi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card mt-4">
        <div class="card-body">
            <h5>Lịch thi: {{ ucwords(\Carbon\Carbon::parse($examSchedule->schedule->date)->translatedFormat('l, d/m/Y')) }}</h5>
            <p><strong>Ca thi:</strong> {{ $examSchedule->schedule->timeSlot->slot ?? 'Chưa có' }}</p>
            <p><strong>Phòng thi:</strong> {{ $examSchedule->schedule->classroom->code ?? 'Chưa có' }}</p>
            <p><strong>Giám Thị 1:</strong>
                @if ($examSchedule->teacher1)
                    {{ $examSchedule->teacher1->full_name }} ({{ $examSchedule->teacher1->code }})
                @else
                    Chưa có
                @endif  
            </p>
            <p><strong>Giám Thị 2:</strong>
                @if ($examSchedule->teacher2)
                    {{ $examSchedule->teacher2->full_name }} ({{ $examSchedule->teacher2->code }})
                @else
                    Chưa có
                @endif
            </p>
            <p><strong>Số lượng thí sinh:</strong> {{ $examSchedule->students->count() }}</p>
        </div>
    </div>

    <h3 class="mt-4">Danh sách thí sinh</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên thí sinh</th>
                <th>Email</th>
                <th>Mã số sinh viên</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($examSchedule->students as $index => $examStudent)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $examStudent->student->full_name }}</td>
                    <td>{{ $examStudent->student->email }}</td>
                    <td>{{ $examStudent->student->code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="{{ route('admin.examschedules.index', ['subject_class_id' => $examSchedule->schedule->subject_class_id]) }}" class="btn btn-secondary">Quay lại danh sách lịch thi</a>
    </div>
</main>
@endsection
