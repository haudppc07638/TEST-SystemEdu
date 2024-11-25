@extends('layouts.lecturer')

@section('title', 'Lịch Dạy')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Lịch Dạy</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Lịch Dạy</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="filter-form mb-3">
            <form id="filter-form">
                <div class="row">
                    <div class="col-md-4">
                        <label for="subject_class_id" class="form-label">Lớp Môn</label>
                        <select id="subject_class_id" name="subject_class_id" class="form-select">
                            <option value="">Tất cả</option>
                            @foreach ($teacher->subjectClasses as $class)
                                <option value="{{ $class->id }}"
                                    {{ request('subject_class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="date" class="form-label">Ngày</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ request('date') }}">
                    </div>
                    <div class="col-md-4 align-self-end">
                        <button type="button" id="filter-btn" class="btn btn-primary">Lọc</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="schedule-table">
            <!-- Nội dung bảng lịch -->
            @include('teacher.schedule._schedule_table', ['schedules' => $schedules])
        </div>

    </main>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            function loadSchedules(url, params = '') {
                // Thêm tham số bộ lọc vào URL nếu có
                if (params) {
                    url += (url.includes('?') ? '&' : '?') + params;
                }

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(html => {
                        // Cập nhật nội dung bảng
                        document.getElementById('schedule-table').innerHTML = html;
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    });
            }

            // Xử lý lọc
            $('#filter-btn').click(function() {
                // Lấy tham số từ form bộ lọc
                let params = new URLSearchParams(new FormData($('#filter-form')[0])).toString();

                // Nếu không có bộ lọc, sử dụng tham số mặc định là tất cả
                if (!params) {
                    params = 'subject_class_id=&date='; // Mặc định là "Tất cả"
                }

                loadSchedules("{{ route('teacher.schedules.filter') }}", params);
            });

            // Xử lý phân trang
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                // Lấy URL phân trang
                let url = $(this).attr('href');

                // Lấy tham số từ form bộ lọc, nếu có
                let params = new URLSearchParams(new FormData($('#filter-form')[0])).toString();

                // Nếu không có bộ lọc, sử dụng tham số mặc định là tất cả
                if (!params) {
                    params = 'subject_class_id=&date='; // Mặc định là "Tất cả"
                }

                // Gọi hàm loadSchedules với URL và tham số bộ lọc
                loadSchedules(url, params);
            });
        });
    </script>
@endpush
