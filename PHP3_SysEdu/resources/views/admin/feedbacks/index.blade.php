@extends('layouts.master')

@section('title', 'Danh sách câu hỏi phản hồi')

@section('main')
<main id="main" class="main">
    <div class="container">
        <h1>Danh sách câu hỏi phản hồi</h1>

        {{-- Nút tạo feedback --}}
        <div class="mb-3">
            <a href="{{ route('admin.feedbacks.create') }}" class="btn btn-primary">Tạo câu hỏi phản hồi</a>
        </div>

        {{-- Bộ lọc theo lớp môn --}}
        <form method="GET" action="{{ route('admin.feedbacks.index') }}">
            <div class="form-group">
                <label for="subject_class_id">Lớp môn</label>
                <select name="subject_class_id" id="subject_class_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Chọn lớp môn</option>
                    @foreach ($subjectClasses as $subjectClass)
                        <option value="{{ $subjectClass->id }}" 
                                {{ request('subject_class_id') == $subjectClass->id ? 'selected' : '' }}>
                                {{ $subjectClass->subject->name }} - {{ $subjectClass->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- Danh sách feedbacks của sinh viên --}}
        <h3>Phản hồi của sinh viên</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tên sinh viên</th>
                    <th>MSSV</th>
                    <th>Câu trả lời</th>
                    <th>Điểm trung bình</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedbackResultsForStudents as $feedbackResult)
                    <tr>
                        <td>{{ $feedbackResult->studentSubjectClass->student->full_name }}</td>
                        <td>{{ $feedbackResult->studentSubjectClass->student->code }}</td>
                        <td>{{ $feedbackResult->results }}</td>
                        <td>{{ $feedbackResult->average_score ?? 'Chưa có điểm' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Phân trang cho feedbacks của sinh viên --}}
        {{ $feedbackResultsForStudents->links() }}

        {{-- Danh sách feedbacks của giáo viên --}}
        <h3>Phản hồi của giáo viên</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tên giáo viên</th>
                    <th>MSGV</th>
                    <th>Câu trả lời</th>
                    <th>Điểm trung bình</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedbackResultsForTeachers as $feedbackResult)
                    <tr>
                        <td>{{ $feedbackResult->employee->full_name }}</td>
                        <td>{{ $feedbackResult->employee->code }}</td>
                        <td>{{ $feedbackResult->results }}</td>
                        <td>{{ $feedbackResult->average_score ?? 'Chưa có điểm' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Phân trang cho feedbacks của giáo viên --}}
        {{ $feedbackResultsForTeachers->links() }}
    </div>
</main>
@endsection

@section('scripts')
<script>
    // Khởi tạo Select2 cho dropdown lớp môn
    $(document).ready(function() {
        $('#subject_class_id').select2({
            placeholder: "Chọn lớp môn",
            allowClear: true
        });
    });
</script>
@endsection
