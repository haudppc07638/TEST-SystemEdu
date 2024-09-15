@extends('layouts.master')

@section('title', 'Lịch Học')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản Lý Lịch Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Quản Lý Lịch Học</li>
                <li class="breadcrumb-item">Lịch Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            @if (session('success'))
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('admin.schedules.create', ['semesterId' => request('semesterId')]) }}" class="btn btn-primary">Thêm mới</a>
                            </div>

                            <!-- Dropdown để chọn kỳ học -->
                            <form action="{{ route('admin.schedules.index') }}" method="GET" class="d-flex align-items-center">
                                <select name="semesterId" class="form-select me-2" onchange="this.form.submit()">
                                    <option value="">Tất cả các kỳ học</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id }}" {{ request('semesterId') == $semester->id ? 'selected' : '' }}>
                                            {{ $semester->block }} - {{ $semester->year }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>  

                        </div>

                        {{-- <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="{{ route('admin.schedules.create', ['semesterId' => request('semesterId')]) }}" class="btn btn-primary">Thêm mới</a>

                            <!-- Dropdown để chọn kỳ học -->
                            <form action="{{ route('admin.schedules.index') }}" method="GET" class="d-flex align-items-center">
                                <select name="semesterId" class="form-select me-2" onchange="this.form.submit()">
                                    <option value="">Tất cả các kỳ học</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id }}" {{ request('semesterId') == $semester->id ? 'selected' : '' }}>
                                            {{ $semester->block }} - {{ $semester->year }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>                            
                        </div> --}}

                        <!-- Bảng với các hàng bị tẩy -->
                        <table id="tableSchedule" class="table datatable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Phòng Học</th>
                                    <th>Ca Học</th>
                                    <th>Môn Học</th>
                                    <th>Lớp</th>
                                    <th>Giảng Viên</th>
                                    <th>Ngày Học</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $index => $schedule)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $schedule->classroom->code ?? 'Chưa có' }}</td>
                                        <td>{{ $schedule->timeSlot->slot ?? 'Chưa có' }}</td>
                                        <td>{{ $schedule->subjectClass->subject->name ?? 'Chưa có' }}</td>
                                        <td>{{ $schedule->subjectClass->name ?? 'Chưa có' }}</td>
                                        <td>{{ $schedule->subjectClass->employee->fullname ?? 'Chưa có' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->schedule_day)->translatedFormat('l, d/m/Y') ?? 'Chưa có' }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('admin.schedules.edit', ['id' => $schedule->id]) }}">
                                                        <i class="bx bx-edit-alt me-2"></i> Sửa
                                                    </a>
                                                    <form action="{{ route('admin.schedules.destroy', ['id' => $schedule->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lịch học này không?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item"><i class="bx bx-trash me-2"></i> Xóa</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Kết thúc bảng với các hàng bị tẩy -->

                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- Kết thúc #main -->
@endsection

@push('style')
@endpush

@push('script')
@endpush
