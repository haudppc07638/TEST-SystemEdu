@if($examSchedules->isEmpty())
    <div class="alert alert-info">
        Bạn chưa được phân công gác thi.
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
            <th>Ca</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($examSchedules as $index => $examSchedule)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($examSchedule->schedule->date)->translatedFormat('l, d/m/Y') }}</td>
                <td>{{ $examSchedule->schedule->classroom->code ?? 'Chưa có' }}</td>
                <td>{{ $examSchedule->schedule->subjectClass->subject->code ?? 'Chưa có' }}</td>
                <td>{{ $examSchedule->schedule->subjectClass->subject->name ?? 'Chưa có' }}</td>
                <td>{{ $examSchedule->schedule->subjectClass->name ?? 'Chưa có' }}</td>
                <td>{{ $examSchedule->schedule->timeSlot->slot ?? 'Chưa có' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{ $examSchedules->appends(request()->query())->links() }}
</div>
@endif
