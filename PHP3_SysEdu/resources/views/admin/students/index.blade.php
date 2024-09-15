@extends('layouts.master')

@section('title', 'students')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản Lý Sinh Viên</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Sinh Viên</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a href="{{ route('admin.students.create') }}" type="submit"
                                    class="btn btn-primary m-2">Thêm mới</a>
                            </div>
                            <table id="tableStudent" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Hình ảnh</th>
                                        <th>Mã sinh viên</th>
                                        <th>Chuyên ngành</th>
                                        <th>Lớp học</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->fullname }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>{{ $student->phone }}</td>

                                            <td>
                                                <img src="{{ asset('storage/avatars/' . $student->image) }}" alt="avatar"
                                                    class="rounded-circle" width="40px" height="40px">
                                            </td>
                                            <td>{{ $student->code }}</td>
                                            <td>{{ $student->major->name ?? 'Chưa có chuyên ngành' }}</td>
                                            <td>{{ $student->stuClass->name ?? 'Chưa có lớp học' }}</td>


                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.students.edit', ['id' => $student->id]) }}">
                                                            <i class="bx bx-edit-alt me-2"></i> Chỉnh sửa
                                                        </a>
                                                        <form
                                                            action="{{ route('admin.students.destroy', ['id' => $student->id]) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa sinh viên này không?');">
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
                            <!-- End Table with stripped rows -->

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
