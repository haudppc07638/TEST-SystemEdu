@extends('layouts.master')

@section('title', 'Đăng Ký Giảng Viên Cho Môn Học')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Đăng ký giảng viên cho môn học</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body mt-3">
                            <form action="{{ route('admin.subject_lecturers.storeOrUpdate') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="subject_id" class="form-label">Môn học</label>
                                    <select class="form-select" id="subject_id" name="subject_id" required>
                                        <option value="" disabled selected>Chọn môn</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->major->name ?? 'Cơ bản' }} - {{ $subject->code }} -
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="employee_ids" class="form-label">Giảng viên</label>
                                    <select class="form-select" id="employee_ids" name="employee_ids[]" multiple required>
                                        <!-- Options sẽ được thêm qua JavaScript -->
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-cBlue">Đăng ký</button>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- Bảng hiển thị môn học và giáo viên -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Danh sách môn học và giảng viên</h5>

                            <form id="filterForm" method="GET" action="{{ route('admin.subject_lecturers.create') }}">
                                <div class="row mb-4">
                                    <label for="major_id" class="form-label">Chuyên ngành</label>

                                    <div class="col-md-4">
                                        <select name="major_id" id="major_id" class="form-select">
                                            <option value="">Tất cả</option>
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}"
                                                    {{ $majorId == $major->id ? 'selected' : '' }}>
                                                    {{ $major->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" id="filterButton" class="btn btn-cBlue">Lọc</button>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Môn học</th>
                                        <th>Giảng viên</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjects as $subject)
                                        <tr>
                                            <td>{{$subject->major ? $subject->major->name : 'Cơ bản'}} | {{ $subject->name }}</td>
                                            <td>
                                                @foreach ($subject->lecturers as $lecturer)
                                                    {{ $lecturer->employee->full_name }}@if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
                                {{ $subjects->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#subject_id').on('change', function() {
                const subjectId = $(this).val();

                // Gọi API để lấy danh sách giảng viên đang dạy môn học
                $.ajax({
                    url: '{{ route('admin.subject_lecturers.getSubjectLecturers') }}',
                    method: 'GET',
                    data: {
                        subject_id: subjectId
                    },
                    success: function(lecturers) {
                        const employeeSelect = $('#employee_ids');
                        employeeSelect.empty(); // Xóa dữ liệu cũ

                        if (lecturers.length > 0) {
                            lecturers.forEach(lecturer => {
                                employeeSelect.append(
                                    `<option value="${lecturer.id}" selected>${lecturer.code} - ${lecturer.full_name}</option>`
                                );
                            });
                        }

                        // Hiển thị toàn bộ danh sách giảng viên khác để người dùng chọn thêm
                        $.ajax({
                            url: '{{ route('admin.employees.all') }}', // API trả về danh sách toàn bộ giảng viên
                            method: 'GET',
                            success: function(allEmployees) {
                                allEmployees.forEach(employee => {
                                    if (!employeeSelect.find(
                                            `option[value="${employee.id}"]`
                                            ).length) {
                                        employeeSelect.append(
                                            `<option value="${employee.id}">${employee.code} - ${employee.full_name}</option>`
                                        );
                                    }
                                });
                                employeeSelect.trigger(
                                'change'); // Cập nhật Select2
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });

            // Khởi tạo Select2
            $('#employee_ids').select2({
                placeholder: "Chọn giảng viên",
                allowClear: true
            });

            $('#subject_id').select2({
                placeholder: "Chọn môn học",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#filterButton').on('click', function() {
                const majorId = $('#major_id').val();

                $.ajax({
                    url: '{{ route('admin.subject_lecturers.filter') }}',
                    method: 'GET',
                    data: {
                        major_id: majorId
                    },
                    success: function(data) {
                        let rows = '';
                        if (data.length > 0) {
                            data.forEach(function(subject) {
                                rows += `<tr>
                                        <td>${subject.code} - ${subject.name}</td>
                                        <td>`;
                                if (subject.lecturers.length > 0) {
                                    subject.lecturers.forEach(function(lecturer,
                                        index) {
                                        rows +=
                                            `${lecturer.employee.full_name}${index < subject.lecturers.length - 1 ? ', ' : ''}`;
                                    });
                                } else {
                                    rows += 'Không có giảng viên';
                                }
                                rows += `   </td>
                                    </tr>`;
                            });
                        } else {
                            rows += `<tr>
                                    <td colspan="2" class="text-center">Không có môn học trong chuyên ngành này</td>
                                  </tr>`;
                        }
                        $('tbody').html(rows);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });
        });
    </script>
@endpush
