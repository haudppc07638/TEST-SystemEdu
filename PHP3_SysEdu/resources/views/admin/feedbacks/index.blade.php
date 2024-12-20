@extends('layouts.master')

@section('title', 'Danh sách câu hỏi phản hồi')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Danh sách phản hồi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item active">Feedback</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <a href="{{ route('admin.feedbacks.create') }}" class="btn btn-cBlue m-2">Tạo câu hỏi phản hồi</a>
                        </div>

                        <h3>Phản hồi của sinh viên</h3>
                        <form method="GET" action="{{ route('admin.feedbacks.index') }}">
                            <div class="row mb-3">
                                <!-- Lọc theo lớp môn -->
                                <div class="col-md-6">
                                    <label for="subject_class_id">Lớp môn</label>
                                    <select name="subject_class_id" id="subject_class_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">Chọn lớp môn</option>
                                        @foreach ($subjectClasses as $subjectClass)
                                            <option value="{{ $subjectClass->id }}" 
                                                    {{ request('subject_class_id') == $subjectClass->id ? 'selected' : '' }} >
                                                    {{ $subjectClass->subject->name }} - {{ $subjectClass->name }}
                                            </option>
                                        @endforeach 
                                    </select>
                                </div>
                        
                                <!-- Lọc theo khoảng thời gian -->
                                <div class="col-md-6">
                                    <label for="created_at_range">Chọn khoảng thời gian</label>
                                    <select name="created_at_range" id="created_at_range" class="form-control" onchange="this.form.submit()">
                                        <option value="">Chọn khoảng thời gian</option>
                                        <option value="today" {{ request('created_at_range') == 'today' ? 'selected' : '' }}>Hôm nay</option>
                                        <option value="this_week" {{ request('created_at_range') == 'this_week' ? 'selected' : '' }}>Tuần này</option>
                                        <option value="this_month" {{ request('created_at_range') == 'this_month' ? 'selected' : '' }}>Tháng này</option>
                                        <option value="last_month" {{ request('created_at_range') == 'last_month' ? 'selected' : '' }}>Tháng trước</option>
                                        <option value="last_7_days" {{ request('created_at_range') == 'last_7_days' ? 'selected' : '' }}>7 ngày qua</option>
                                    </select>
                                </div>
                            </div>
                        
                            <!-- Tìm kiếm -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="search" id="search" class="form-control" 
                                           value="{{ request('search') }}" placeholder="Nhập MSSV hoặc tên sinh viên">
                                    <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                                </div>
                            </div>
                        </form>                        
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sinh viên</th>
                                        <th>MSSV</th>
                                        <th>Câu hỏi</th>
                                        <th>Đánh giá</th>
                                        <th>Ghi chú thêm</th>
                                    </tr>
                                </thead>    
                                @php
                                $resultMap = [
                                    10 => 'Tốt',
                                    8 => 'Khá',
                                    6 => 'Trung bình',
                                    4 => 'Kém',
                                ];
                            @endphp

                            <tbody>
                                @forelse ($feedbackResultsForStudents as $index => $feedbackResult)
                                    <tr>
                                        <td>{{ $index + 1 }}</td> <!-- Thêm số thứ tự -->
                                        <td>{{ $feedbackResult->studentSubjectClass->student->full_name }}</td>
                                        <td>{{ $feedbackResult->studentSubjectClass->student->code }}</td>
                                        <td>{{ $feedbackResult->feedbackQuestion->name ?? 'Không có câu hỏi' }}</td>
                                        <td>
                                            @if(isset($resultMap[$feedbackResult->results]))
                                                {{ $resultMap[$feedbackResult->results] }}
                                            @else
                                                {{ 'Chưa đánh giá' }}
                                            @endif
                                        </td>
                                        <td class="text-break" style="max-width: 300px;">
                                            {{ $feedbackResult->expertise ?? 'Sinh viên chưa đánh giá' }}
                                        </td>                                                   
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            </table>
                        </div>        
                        {{-- Phân trang cho feedbacks của sinh viên --}}
                        <div class="d-flex justify-content-end">  
                            {{ $feedbackResultsForStudents->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->
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
