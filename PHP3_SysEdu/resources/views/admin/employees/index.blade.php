@extends('layouts.master')

@section('title', 'employees')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản Lý Nhân Sự </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Nhân Sự </li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a href="{{ route('admin.employees.create') }}" type="submit" class="btn btn-primary m-2">Thêm mới</a>
                            </div>
                        <table id="tableEmployee" class="table datatable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ và tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Hình ảnh</th>
                                    <th>Chức vụ</th>
                                    <th>khoa</th>
                                    <th>Phòng ban</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $index => $employee)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $employee->fullname }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->phone }}</td>

                                        <td>
                                            <img src="{{ asset('storage/avatars/' . $employee->image) }}" alt="avatar"
                                                class="rounded-circle" width="40px" height="40px">
                                        </td>

                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->faculty->name }}</td>
                                        <td>{{ $employee->department->name }}</td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>

                                                <div class="dropdown-menu">
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
@endpush
