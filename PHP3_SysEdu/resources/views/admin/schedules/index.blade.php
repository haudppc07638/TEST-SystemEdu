@extends('layouts.master')

@section('title', 'Chỉnh sửa Lịch Học')

@section('main')
    <main id="main" class="main">
        <h1>Danh Sách Lịch Học</h1>

        <a href="{{ route('admin.schedules.create') }}" class="btn btn-success">Tạo Lịch Mới</a>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Khung Giờ</th>
                    <th>Phòng Học</th>
                    <th>Lớp Môn Học</th>
                    <th>Ngày Học</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->timeSlot->start_time }} - {{ $schedule->timeSlot->end_time }}</td>
                        <td>{{ $schedule->classroom->code }}</td>
                        <td>{{ $schedule->subjectClass->name }}</td>
                        <td>{{ $schedule->date }}</td>
                        <td>
                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $schedules->links() }} <!-- Phân trang -->
    </main>
@endsection
