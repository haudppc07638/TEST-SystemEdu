@extends('layouts.master')

@section('title', 'Quản lý lớp học phần')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản lý điểm - Lớp học phần: {{ $subjectClass->name }} | Môn học: {{ $subjectClass->subject->name }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjectclasses.index') }}">Lớp học phần</a></li>
                    <li class="breadcrumb-item active">Quản lý lớp học phần</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5>Bảng điểm sinh viên trong lớp học phần</h5>
                                <div class="btn-group">
                                    <a href="{{ route('admin.studentsubjectclass.export', $subjectClass->id) }}"
                                        class="btn btn-sm btn-success me-2">
                                        <i class="bi bi-file-earmark-excel me-1"></i> Xuất Excel
                                    </a>
                                    @if (!$isBeforeStart)
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#importExcelModal">
                                            <i class="bi bi-file-earmark-excel me-1"></i> Nhập điểm từ Excel
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.studentsubjectclass.exportEligible', $subjectClass->id) }}" 
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Xuất SV đủ điều kiện thi
                                    </a>
                                </div>

                            </div>

                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table id="sysTable" class="table datatable">
                                    <thead>
                                        <tr>
                                            <th class="fs-6">STT</th>
                                            <th class="fs-6">MSV</th>
                                            <th class="fs-6">Họ tên</th>
                                            @php
                                                $groupedScoreTypes = [];
                                                foreach ($scoreTypes as $scoreType) {
                                                    $scoreTypeId = $scoreType->scoreType->id;
                                                    if (!isset($groupedScoreTypes[$scoreTypeId])) {
                                                        $groupedScoreTypes[$scoreTypeId] = [
                                                            'name' => $scoreType->scoreType->name,
                                                            'type' => $scoreType->scoreType->type,
                                                            'details' =>
                                                                $scoreType->scoreType->type === 'multi'
                                                                    ? [$scoreType]
                                                                    : [$scoreType],
                                                        ];
                                                    } else {
                                                        if ($scoreType->scoreType->type === 'multi') {
                                                            $groupedScoreTypes[$scoreTypeId]['details'][] = $scoreType;
                                                        }
                                                    }
                                                }
                                            @endphp

                                            @foreach ($groupedScoreTypes as $type)
                                                @if ($type['type'] === 'multi')
                                                    @foreach ($type['details'] as $index => $detail)
                                                        <th class="fs-6">{{ $type['name'] }}{{ $index + 1 }}</th>
                                                    @endforeach
                                                @else
                                                    <th class="fs-6">{{ $type['name'] }}</th>
                                                @endif
                                            @endforeach
                                            <th class="fs-6">Tổng điểm</th>
                                            <th class="fs-6">Xếp loại</th>
                                            <th class="fs-6">Trạng thái</th>
                                            <th class="fs-6">Trạng thái thanh toán</th>
                                            @if (!$isBeforeStart)
                                                <th>Tác vụ</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentSubjectClasses as $index => $studentSubjectClass)
                                            <tr>
                                                <td class="fs-6">{{ $index + 1 }}</td>
                                                <td class="fs-6">{{ $studentSubjectClass->student->code }}</td>
                                                <td class="fs-6">{{ $studentSubjectClass->student->full_name }}</td>

                                                @foreach ($groupedScoreTypes as $type)
                                                    @if ($type['type'] === 'multi')
                                                        @foreach ($type['details'] as $detail)
                                                            <td class="fs-6">
                                                                @php
                                                                    $score = $studentSubjectClass->scores
                                                                        ->where('subject_score_type_id', $detail->id)
                                                                        ->first();
                                                                @endphp
                                                                {{ $score ? $score->score : '' }}
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        <td class="fs-6">
                                                            @php
                                                                $score = $studentSubjectClass->scores
                                                                    ->where(
                                                                        'subject_score_type_id',
                                                                        $type['details'][0]->id,
                                                                    )
                                                                    ->first();
                                                            @endphp
                                                            {{ $score ? $score->score : '' }}
                                                        </td>
                                                    @endif
                                                @endforeach

                                                <td class="fs-6">
                                                    {{ $studentSubjectClass->total_score ? $studentSubjectClass->total_score : '' }}
                                                </td>
                                                <td class="fs-6">{{ $studentSubjectClass->classification }}</td>
                                                <td class="fs-6">
                                                    @if ($studentSubjectClass->status == 'passed')
                                                        <span class="badge bg-success">Pass</span>
                                                    @else
                                                        <span class="badge bg-danger">Fail</span>
                                                    @endif
                                                </td>
                                                <td class="fs-6">
                                                    @php
                                                        $totalTuition = $studentSubjectClass->student->totalTuition;
                                                    @endphp
                                                    @if ($totalTuition)
                                                        @if ($totalTuition->payment_status === 'paid')
                                                            <span class="badge bg-success">Đã thanh toán</span>
                                                        @else
                                                            <span class="badge bg-danger">Chưa thanh toán</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-secondary">Chưa có dữ liệu</span>
                                                    @endif
                                                </td>
                                                @if (!$isBeforeStart)
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.studentsubjectclass.edit', $studentSubjectClass->id) }}">
                                                                    <i class="bx bx-edit-alt me-2"></i> Chỉnh sửa
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif                                    
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h5>Lịch sử điểm danh</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mt-4">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fs-6">#</th>
                                            <th class="fs-6">Mã SV</th>
                                            <th class="fs-6">Họ và tên</th>
                                            @foreach ($subjectClass->schedules as $schedule)
                                                <th class="fs-6">
                                                    {{ \Carbon\Carbon::parse($schedule->date)->format('d/m') }} Buổi
                                                    {{ $loop->iteration }}</th>
                                            @endforeach
                                            <th class="fs-6">Tổng</th>
                                            <th class="fs-6">Vắng (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $index => $student)
                                            <tr>
                                                <td class="fs-6">{{ $index + 1 }}</td>
                                                <td class="fs-6">{{ $student->student->code }}</td>
                                                <td class="fs-6"
                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $student->student->full_name }}</td>

                                                @php
                                                    $absentCount = 0;
                                                    $totalSessions = count($subjectClass->schedules); // Tổng số buổi học
                                                @endphp

                                                @foreach ($subjectClass->schedules as $schedule)
                                                    @php
                                                        // Lấy trạng thái điểm danh cho sinh viên trong buổi học
                                                        $status = $student
                                                            ->attendances()
                                                            ->where('date', $schedule->date) // Kiểm tra ngày của buổi học
                                                            ->first();

                                                        if ($status && $status->status == 0) {
                                                            $absentCount++;
                                                        }
                                                    @endphp

                                                    <td class="fs-6">
                                                        @if ($status)
                                                            @switch($status->status)
                                                                @case(1)
                                                                    <span class="fw-bold text-success">P</span>
                                                                @break

                                                                @case(0)
                                                                    <span class="fw-bold text-danger">A</span>
                                                                @break
                                                            @endswitch
                                                        @endif
                                                    </td>
                                                @endforeach

                                                <td class="fs-6">{{ $absentCount }} / {{ $totalSessions }}</td>
                                                <td class="fs-6">
                                                    {{ $totalSessions > 0 ? number_format(($absentCount / $totalSessions) * 100, 2) : 0 }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
        </section>
    </main><!-- End #main -->

    <!-- Modal -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importExcelModalLabel">Nhập điểm từ file Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.studentsubjectclass.import', $subjectClass->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Chọn file Excel</label>
                            <input class="form-control" type="file" id="excel_file" name="file" accept=".xlsx, .xls"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Nhập điểm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
