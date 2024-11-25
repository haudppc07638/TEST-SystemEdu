@extends('layouts.lecturer')

@section('main')
    <main id="main" class="main">
        <div class="container">
            <!-- Phần lớp đang diễn ra -->
            <div class="card mb-4">
                <div class="card-header bg-primary d-flex justify-content-between align-items-center py-2">
                    <h5 class="card-title mb-0 text-white ">
                        <i class="bi bi-calendar-week"></i> Lớp Đang Diễn Ra
                    </h5>
                </div>

                <div class="card-body">
                    @if ($currentClasses->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Không có lớp nào đang diễn ra trong tuần này
                        </div>
                    @else
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">STT</th>
                                        <th width="15%">Lớp</th>
                                        <th width="25%">Tên Môn Học</th>
                                        <th width="10%">Số SV</th>
                                        <th width="20%">Lịch Học Hôm Nay</th>
                                        <th width="25%">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($currentClasses as $index => $class)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $class->name }}</td>
                                            <td>{{ $class->subject->name }}</td>
                                            <td class="text-center">{{ $class->studentSubjectClasses->count() }}</td>
                                            <td>
                                                @php
                                                    $todaySchedule = $class->schedules
                                                        ->where('date', Carbon\Carbon::today()->toDateString())
                                                        ->first();
                                                @endphp
                                                @if ($todaySchedule)
                                                    <span class="text-primary">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ $todaySchedule->timeSlot->slot ?? '' }}
                                                        ({{ substr($todaySchedule->timeSlot->start_time, 0, 5) }} -
                                                        {{ substr($todaySchedule->timeSlot->end_time, 0, 5) }})
                                                    </span>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fas fa-ban me-1"></i>
                                                        Không có lịch hôm nay
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('attendance.class.detail', $class->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Chi tiết
                                                    </a>

                                                    @if ($todaySchedule)
                                                        <a href="{{ route('attendance.take', $class->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-user-check"></i> Điểm danh
                                                        </a>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Phần tất cả các lớp đã diễn ra -->
            <div class="card">
                <div class="card-header bg-secondary d-flex justify-content-between align-items-center py-2">
                    <h5 class="card-title mb-0 text-white ">
                        <i class="bi bi-calendar-week"></i> Lớp Đã Diễn Ra
                    </h5>
                </div>

                <div class="card-body mt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">STT</th>
                                    <th width="10%">Lớp</th>
                                    <th width="20%">Tên Môn Học</th>
                                    <th width="10%">Học Kỳ</th>
                                    <th width="8%">Số SV</th>
                                    <th width="10%">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pastClasses as $index => $class)
                                    <tr>
                                        <td class="text-center">{{ $pastClasses->firstItem() + $index }}</td>
                                        <td>{{ $class->name }}</td>
                                        <td>{{ $class->subject->name }}</td>
                                        <td class="text-center">{{ $class->semester->block }} -
                                            {{ $class->semester->year }}</td>
                                        <td class="text-center">{{ $class->studentSubjectClasses->count() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('attendance.class.detail', $class->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Chi tiết
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-inbox fa-2x mb-3 text-muted d-block"></i>
                                            Không có lớp học nào đã diễn ra
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Phân trang -->
                    @if ($pastClasses->hasPages())
                        <div class="d-flex justify-content-end mt-4">
                            {{ $pastClasses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
