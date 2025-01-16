@extends('layouts.master')

@section('title', 'employees')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản lý nhân sự </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item">Nhân sự </li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex">
                                <a href="{{ route('admin.employees.create') }}" type="submit" class="btn btn-cBlue">Thêm</a>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <select id="majorFilter" class="form-select" name="major_id" onchange="filterEmployees()">
                                        <option value="">Chọn chuyên ngành</option>
                                        @foreach ($majors as $major)
                                            <option value="{{ $major->id }}" {{ $filters['major_id'] == $major->id ? 'selected' : '' }}>
                                                {{ $major->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select id="departmentFilter" class="form-select" name="department_id" onchange="filterEmployees()">
                                        <option value="">Chọn Phòng Ban</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" {{ $filters['department_id'] == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <table id="tableEmployee" class="table datatable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ và tên</th>
                                    <th>MSNV</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Hình ảnh</th>
                                    <th>Chức vụ</th>
                                    <th>Chuyên nghành</th>
                                    <th>Phòng ban</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $index => $employee)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $employee->full_name }}</td>
                                        <td>{{ $employee->code }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->phone }}</td>

                                        <td>
                                            <img src="{{ $employee->image ? asset('storage/avatars/' . $employee->image) : asset('assets/images/default-avatar1.jpg') }}" alt="avatar"
                                                class="rounded-circle" width="40px" height="40px">
                                        </td>

                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->major->name }}</td>
                                        <td>{{ $employee->department->name }}</td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.employees.detail', ['id' => $employee->id]) }}">
                                                        <i class="bx bx-id-card me-2"></i>
                                                        Xem chi tiết
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('admin.teacher_free_slots.createOrUpdate', ['id' => $employee->id]) }}"><i class="bi bi-calendar-plus"></i> Cập nhật ca rảnh</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.employees.edit', ['id' => $employee->id]) }}">
                                                        <i class="bx bx-edit-alt me-2"></i>
                                                        Chỉnh sửa
                                                    </a>
                                                    <form
                                                        action="{{ route('admin.employees.destroy', ['id' => $employee->id]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng ban này không?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item"><i
                                                                class="bx bx-trash me-2"></i> Xóa</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{ $employees->links() }}
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
    function filterEmployees() {
        const majorId = document.getElementById('majorFilter').value;
        const departmentId = document.getElementById('departmentFilter').value;

        const url = new URL(window.location.href);
        url.searchParams.set('major_id', majorId);
        url.searchParams.set('department_id', departmentId);

        window.location.href = url.toString();
    }
</script>
@endpush
