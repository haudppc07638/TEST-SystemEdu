@extends('layouts.lecturer')

@section('main')
    <main id="main" class="main">

        <div class="container">
            <!-- Thông tin lớp -->
            <div class="card mb-4">
                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0 text-white">
                        {{ $subjectClass->name }} - {{ $subjectClass->subject->name }}
                    </h3>
                    <div>
                        <a href="{{ route('classes') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>Học kỳ:</strong> {{ $subjectClass->semester->block }} -
                                {{ $subjectClass->semester->year }}</p>
                            <p><strong>Số tín chỉ:</strong> {{ $subjectClass->subject->credit }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Lịch học</strong></p>
                            <div>
                                Bắt đầu: {{ $subjectClass->start_date }}
                            </div>
                            <div>
                                Kết thúc: {{ $subjectClass->end_date }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thống kê tổng quan -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title text-white">Tổng số buổi học</h5>
                            <h2>{{ $attendanceStats['total_sessions'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title text-white">Số buổi đã học</h5>
                            <h2>{{ $attendanceStats['total_sessions_held'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Tỷ lệ vắng TB</h5>
                            <h2>{{ number_format($attendanceStats['average_absence_rate'], 1) }}%</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">SV trượt điểm danh</h5>
                            <h2>{{ $attendanceStats['warning_count'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab điều hướng -->
            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="students-tab" data-bs-toggle="tab" href="#students" role="tab">
                        Học sinh trong lớp
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="attendance-tab" data-bs-toggle="tab" href="#attendance" role="tab">
                        Điểm danh
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="grades-tab" data-bs-toggle="tab" href="#grades" role="tab">
                        Bảng điểm
                    </a>
                </li>
            </ul>

            <!-- Nội dung tab -->
            <div class="tab-content">
                <!-- Tab học sinh trong lớp -->
                <div class="tab-pane fade show active" id="students" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mt-4">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Mã SV</th>
                                            <th>Họ và tên</th>
                                            <th>Email</th>
                                            <th>SĐT</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $index => $student)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-primary">{{ $student->student->code }}</td>
                                                <td>{{ $student->student->full_name }}</td>
                                                <td>{{ $student->student->email }}</td>
                                                <td>{{ $student->student->phone }}</td>
                                                <td>
                                                    @if ($student->student->status == 'active')
                                                        <span class="text-success">HĐ</span>
                                                    @else
                                                        <span class="text-danger">NHĐ</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab điểm danh -->
                <div class="tab-pane fade" id="attendance" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
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
                </div>

                <!-- Tab bảng điểm -->
                <div class="tab-pane fade" id="grades" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-end align-items-center pr-4">
                                <div class="btn-group">
                                    @if ($subjectClass->end_date >= now())
                                        <a href="{{ route('export.examList', $subjectClass->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="bi bi-file-earmark-excel me-1"></i> Xuất danh sách thi
                                        </a>
                                    @endif
                                    <a href="{{ route('attendance.export', $subjectClass->id) }}"
                                        class="btn btn-sm btn-success me-2">
                                        <i class="bi bi-file-earmark-excel me-1"></i> Xuất bảng điểm
                                    </a>
                                    @if ($subjectClass->end_date >= now())
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#importExcelModal">
                                            <i class="bi bi-file-earmark-excel me-1"></i> Nhập điểm từ Excel
                                        </button>
                                    @endif

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Mã SV</th>
                                            <th>Họ và tên</th>
                                            @php
                                                $groupedScoreTypes = [];
                                                foreach ($subjectClass->subject->subjectScoreTypes as $scoreType) {
                                                    $scoreTypeId = $scoreType->scoreType->id;
                                                    if (!isset($groupedScoreTypes[$scoreTypeId])) {
                                                        $groupedScoreTypes[$scoreTypeId] = [
                                                            'name' => $scoreType->scoreType->name,
                                                            'type' => $scoreType->scoreType->type,
                                                            'details' => [$scoreType],
                                                            'percentage' => $scoreType->percentage,
                                                            'weight' => $scoreType->weight,
                                                        ];
                                                    } else {
                                                        $groupedScoreTypes[$scoreTypeId]['details'][] = $scoreType;
                                                    }
                                                }
                                            @endphp

                                            @foreach ($groupedScoreTypes as $type)
                                                @if ($type['type'] === 'multi')
                                                    @foreach ($type['details'] as $index => $detail)
                                                        <th>{{ $type['name'] }}{{ $index + 1 }} <br><small
                                                                class="text-secondary fs-7 fw-normal">{{ $type['weight'] }}%</small>
                                                        </th>
                                                    @endforeach
                                                @else
                                                    <th>{{ $type['name'] }}<br><small
                                                            class="text-secondary fs-7 fw-normal">{{ $type['weight'] }}%</small>
                                                    </th>
                                                @endif
                                            @endforeach
                                            <th>Tổng Điểm</th>
                                            <th>Trạng Thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $studentSubjectClass)
                                            <tr>
                                                <td>{{ $studentSubjectClass->student->code }}</td>
                                                <td>{{ $studentSubjectClass->student->full_name }}</td>

                                                @foreach ($groupedScoreTypes as $type)
                                                    @if ($type['type'] === 'multi')
                                                        @foreach ($type['details'] as $detail)
                                                            <td>
                                                                @php
                                                                    $score = $studentSubjectClass->scores
                                                                        ->where('subject_score_type_id', $detail->id)
                                                                        ->first();
                                                                @endphp
                                                                {{ $score ? $score->score : '' }}
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        <td>
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

                                                <td>{{ $studentSubjectClass->total_score }}</td>
                                                <td>
                                                    @if ($studentSubjectClass->status == 'passed')
                                                        <span class=" text-success">Pass</span>
                                                    @else
                                                        <span class="text-danger">Fail</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Nhập Điểm -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importExcelModalLabel">Nhập điểm từ file Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('attendance.import', $subjectClass->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Chọn file Excel</label>
                            <input class="form-control" type="file" id="excel_file" name="file"
                                accept=".xlsx, .xls" required>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            // Xử lý lọc
            $('#date-filter, #status-filter').change(function() {
                // Thêm logic lọc ở đây
            });
        });
    </script>
@endpush
