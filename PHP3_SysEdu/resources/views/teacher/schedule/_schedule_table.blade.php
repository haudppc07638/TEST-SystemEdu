@if($schedules->isEmpty())
    <div class="alert alert-info">
        Lớp này chưa có lịch
    </div>
@else
<table class="table table-striped">
    <thead>
        <tr>
            <th>Stt</th>
            <th>Ngày</th>
            <th>Phòng Học</th>
            <th>Mã Môn</th>
            <th>Môn học</th>
            <th>Lớp</th>
            <th>Giảng viên</th>
            <th>Ca</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($schedules as $index => $schedule)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d/m/Y') }}</td>
                <td>{{ $schedule->classroom->code ?? 'Chưa có' }}</td>
                <td>{{ $schedule->subjectClass->subject->code ?? 'Chưa có' }}</td>
                <td>{{ $schedule->subjectClass->subject->name ?? 'Chưa có' }}</td>
                <td>{{ $schedule->subjectClass->name ?? 'Chưa có' }}</td>
                <td>{{ $schedule->subjectClass->employee->full_name ?? 'Chưa có' }}</td>
                <td>{{ $schedule->timeSlot->slot ?? 'Chưa có' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{ $schedules->appends(request()->query())->links() }}
</div>
@endif
<!-- Pagination -->