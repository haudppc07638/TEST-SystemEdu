@extends('layouts.master')

@section('title', 'Subject Classes')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản Lý Lớp Môn</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Đào Tạo</li>
                    <li class="breadcrumb-item active">Lớp Môn</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body mt-3">
                            <a href="{{ route('admin.subjectclasses.create') }}" class="btn btn-cBlue m-2">Thêm</a>
                            <div class="row mb-3 mt-4">
                                <div class="col-md-6">
                                    <select id="subjectFilter" class="form-select" name="subject_id"
                                        onchange="filterSubjectClasses()">
                                        <option value=""> -- Chọn môn học --</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ $filters['subject_id'] == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->major->name ?? 'Cơ bản' }} - {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select id="employeeFilter" class="form-select" name="employee_id"
                                        onchange="filterSubjectClasses()">
                                        <option value=""> -- Chọn giảng viên --</option>
                                        @foreach ($employees as $employee)
                                            <option value="">Tất cả</option>
                                            <option value="{{ $employee->id }}"
                                                {{ $filters['employee_id'] == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->full_name }} - {{ $employee->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <table id="tableSubjectClass" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên Lớp </th>
                                        <th>Số lượng</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Hạn đăng ký</th>
                                        <th>Giảng viên</th>
                                        <th>Môn học</th>
                                        <th>Học kỳ</th>
                                        <th>Học Phí</th>
                                        <th>Lớp chuyên ngành</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjectClasses as $index => $subjectClass)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $subjectClass->name }}</td>
                                            <td>{{ $subjectClass->quantity }}</td>
                                            <td>{{ \Carbon\Carbon::parse($subjectClass->start_date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($subjectClass->end_date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($subjectClass->registration_deadline)->format('d-m-Y') }}</td>                                            
                                            <td>{{ $subjectClass->employee->full_name ?? 'Chưa có' }}</td>
                                            <td>{{ $subjectClass->subject->name ?? 'Chưa có' }}</td>
                                            <td>{{ $subjectClass->semester->block ?? 'Chưa có' }}</td>
                                            <td>{{ number_format($subjectClass->price) }} VND</td>
                                            <td>{{ $subjectClass->majorClass->name ?? 'Chưa có' }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.schedules.view-schedule', ['subject_class_id' => $subjectClass->id]) }}"><i
                                                                class="bi bi-calendar"></i> Xem Lịch Học</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.schedules.create', ['subject_class_id' => $subjectClass->id]) }}"><i
                                                                class="bi bi-calendar-plus"></i> Tạo lịch học</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.examschedules.index', ['subject_class_id' => $subjectClass->id]) }}"><i
                                                                class="bi bi-calendar-plus"></i> Xem lịch thi</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.examschedules.create', ['subject_class_id' => $subjectClass->id]) }}"><i
                                                                class="bi bi-calendar-plus"></i> Tạo lịch thi</a>
                                                        @if (!$subjectClass->isStarted())
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.subjectclasses.edit', $subjectClass->id) }}"><i
                                                                    class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        @endif
                                                        @if ($subjectClass->isStarted())
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.studentsubjectclass.index', $subjectClass->id) }}"><i
                                                                    class="bx bx-edit-alt me-2"></i> Quản lý</a>
                                                        @endif
                                                        <button type="button" class="dropdown-item delete-subject-class"
                                                            data-id="{{ $subjectClass->id }}">
                                                            <i class="bx bx-trash me-2"></i> Xóa
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $subjectClasses->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection

@push('style')
@endpush

@push('script')
    <script>
        function filterSubjectClasses() {
            const subjectId = document.getElementById('subjectFilter').value;
            const employeeId = document.getElementById('employeeFilter').value;

            const url = new URL(window.location.href);
            url.searchParams.set('subject_id', subjectId);
            url.searchParams.set('employee_id', employeeId);

            window.location.href = url.toString();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#subjectFilter').select2({
                placeholder: "-- Chọn môn học --",
                allowClear: true,
                width: '100%'
            });
            $('#employeeFilter').select2({
                placeholder: "-- Chọn cố vấn --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    <script>
        document.querySelectorAll('.delete-subject-class').forEach(function(button) {
            button.addEventListener('click', function() {
                const subjectClassId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa lớp môn này?',
                    text: "Việc này không thể hoàn tác!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('admin.subjectclasses.destroy', ':id') }}'.replace(
                            ':id', subjectClassId);
                        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
