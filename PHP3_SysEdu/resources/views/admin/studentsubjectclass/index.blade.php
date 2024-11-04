@extends('layouts.master')

@section('title', 'students')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản Lý Điểm - Lớp Môn: {{ $subjectClass->name }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Sinh Viên</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">

                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5>Danh sách điểm sinh viên</h5>
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
                                </div>

                            </div>

                            <!-- Table with stripped rows -->
                            <table id="sysTable" class="table datatable">
                                <thead>
                                    <tr>
                                        <th class="fs-6">#</th>
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
                                        <th class="fs-6">Tổng Điểm</th>
                                        <th class="fs-6">Xếp Loại</th>
                                        <th class="fs-6">Trạng Thái</th>
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
                                            @if (!$isBeforeStart)
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
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
                            <!-- End Table with stripped rows -->

                        </div>
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
