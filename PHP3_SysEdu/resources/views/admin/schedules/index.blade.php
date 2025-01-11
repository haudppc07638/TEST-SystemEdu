@extends('layouts.master')

@section('title', 'Danh Sách Lịch Học')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Danh sách lịch học của lớp: {{ $subjectClass->name }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjectclasses.index') }}">Lớp môn</a></li>
                    <li class="breadcrumb-item active">Danh sách lịch học</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        @if ($schedules->isEmpty())
            <h4 class="text-center">Lớp môn này chưa có lịch học.</h4>
            <div class="text-center mt-3">
                <a href="{{ route('admin.subjectclasses.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        @else
        <div>
            <p><strong>Số lần thay đổi lịch:</strong> {{ $editedCount }}</p>
        </div>
        
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ngày</th>
                        <th>Phòng học</th>
                        <th>Mã môn</th>
                        <th>Môn học</th>
                        <th>Lớp</th>
                        <th>Giảng viên</th>
                        <th>Giảng viên dạy thế</th>
                        <th>Ca</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $index => $schedule)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst(\Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d/m/Y')) }}</td>
                            <td>{{ $schedule->classroom->code ?? 'Chưa có' }}</td>
                            <td>{{ $schedule->subjectClass->subject->code ?? 'Chưa có' }}</td>
                            <td>{{ $schedule->subjectClass->subject->name ?? 'Chưa có' }}</td>
                            <td>{{ $schedule->subjectClass->name ?? 'Chưa có' }}</td>
                            <td>
                                @if($schedule->subjectClass->employee)
                                    {{ $schedule->subjectClass->employee->full_name }}
                                    @if($schedule->subjectClass->employee->code)
                                        - {{ $schedule->subjectClass->employee->code }}
                                    @endif
                                @else
                                    Chưa có
                                @endif
                            </td>
                            <td>
                                @if($schedule->substituteEmployee)
                                    {{ $schedule->substituteEmployee->full_name }}
                                    @if($schedule->substituteEmployee->code)
                                        - {{ $schedule->substituteEmployee->code }}
                                    @endif
                                @else
                                    Chưa có
                                @endif
                            </td>                            
                            <td>{{ $schedule->timeSlot->slot ?? 'Chưa có' }}</td>
                            <td>
                                @if ($schedule->isEdited())
                                    <span class="badge bg-success">Chuyển lịch</span>
                                @else
                                    <span class="badge bg-secondary">Bình thường</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.schedules.edit', $schedule->id) }}">
                                            <i class="bx bx-edit-alt me-2"></i> Sửa
                                        </a>
                                        {{-- <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-trash me-2"></i> Xóa
                                            </button>
                                        </form> --}}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $schedules->links() }} 
            </div>
        @endif
    </main>
@endsection
