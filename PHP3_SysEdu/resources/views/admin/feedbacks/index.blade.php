@extends('layouts.master')

@section('title', 'Feedback - List')

@section('main')
    <main id="main" class="main">
        <h1>Danh sách Feedback</h1>
        
        <div class="mb-3">
            <a href="{{ route('admin.feedbacks.create') }}" class="btn btn-primary">Tạo Feedback Mới</a>
        </div>

        <form method="GET" action="{{ route('admin.feedbacks.index') }}" class="mb-3">
            <label for="subject_class_id">Chọn lớp môn:</label>
            <select name="subject_class_id" id="subject_class_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Chọn lớp môn --</option>
                @foreach ($subjectClasses as $subjectClass)
                    <option value="{{ $subjectClass->id }}" {{ request('subject_class_id') == $subjectClass->id ? 'selected' : '' }}>
                        {{ $subjectClass->name }}
                    </option>
                @endforeach
            </select>
        </form>

        @if ($feedbacks->isEmpty())
            <p>Không có phản hồi nào.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên học sinh</th> <!-- Thêm cột cho tên học sinh -->
                        <th>Phản hồi của admin</th>
                        <th>Phản hồi của học sinh</th>
                        <th>Mức đánh giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedbacks as $feedback)
                        <tr>
                            <td>{{ $feedback->id }}</td>
                            <td>{{ $feedback->student->fullname ?? 'Không xác định' }}</td> <!-- Hiển thị tên học sinh -->
                            <td>{{ $feedback->admin_feedback }}</td>
                            <td>{{ $feedback->student_feedback ?? 'Chưa có phản hồi' }}</td>
                            <td>{{ $feedback->rating ?? 'Chưa đánh giá' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </main>
@endsection
