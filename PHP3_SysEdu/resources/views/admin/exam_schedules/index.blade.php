@extends('layouts.master')

@section('title', 'Danh Sách Lịch Thi')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Danh Sách Lịch Thi Của Lớp: {{ $subjectClass->name }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Lớp Môn</li>
                    <li class="breadcrumb-item active">Danh sách lịch thi</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        @if ($examSchedules->isEmpty())
            <h4 class="text-center">Lớp môn này chưa có lịch thi.</h4>
            <div class="text-center mt-3">
                <a href="{{ route('admin.subjectclasses.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        @else
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ngày</th>
                        <th>Ca</th>
                        <th>Phòng Thi</th>
                        <th>Giám Thị 1</th>
                        <th>Giám Thị 2</th>
                        <th>Số Lượng Thí Sinh</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($examSchedules as $index => $examSchedule)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst(\Carbon\Carbon::parse($examSchedule->schedule->date)->translatedFormat('l, d/m/Y')) }}</td>
                            <td>{{ $examSchedule->schedule->timeSlot->slot ?? 'Chưa có' }}</td>
                            <td>{{ $examSchedule->schedule->classroom->code ?? 'Chưa có' }}</td>
                            <td>
                                @if ($examSchedule->teacher1)
                                    {{ $examSchedule->teacher1->full_name }} 
                                    ({{ $examSchedule->teacher1->code }})
                                @else
                                    Chưa có
                                @endif
                            </td>
                            <td>
                                @if ($examSchedule->teacher2)
                                    {{ $examSchedule->teacher2->full_name }} 
                                    ({{ $examSchedule->teacher2->code }})
                                @else
                                    Chưa có
                                @endif
                            </td>
                            <td>{{ $examSchedule->students->count() }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="{{ route('admin.examschedules.show', $examSchedule->id) }}">
                                            <i class="bx bx-id-card me-2"></i> xem chi tiết
                                        </a> 
                                        <a class="dropdown-item"
                                            href="{{ route('admin.examschedules.edit', $examSchedule->id) }}">
                                            <i class="bx bx-edit-alt me-2"></i> Sửa
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Không có lịch thi trong các ngày này.</td>
                        </tr>
                    @endforelse
                </tbody>                
            </table>
            <div class="d-flex justify-content-center">
                {{ $examSchedules->links() }}
            </div>
        @endif
    </main>
@endsection
