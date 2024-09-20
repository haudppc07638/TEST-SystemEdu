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
                    <div class="card-body">
                        <a href="{{ route('admin.subjectclasses.create') }}" class="btn btn-primary m-2">Thêm mới</a>
                        <table id="tableSubjectClass" class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên Lớp </th>
                                    <th>Số lượng</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Hạn đăng ký</th>
                                    <th>Giảng viên</th>
                                    <th>Môn học</th>
                                    <th>Học kỳ</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjectClasses as $index => $subjectClass)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $subjectClass->name }}</td>
                                    <td>{{ $subjectClass->quantity }}</td>
                                    <td>{{ $subjectClass->start_date }}</td>
                                    <td>{{ $subjectClass->end_date }}</td>
                                    <td>{{ $subjectClass->registration_deadline }}</td>
                                    <td>{{ $subjectClass->employee->fullname ?? 'Chưa có' }}</td>
                                    <td>{{ $subjectClass->subject->name ?? 'Chưa có' }}</td>
                                    <td>{{ $subjectClass->semester->block ?? 'Chưa có' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.studentsubjectclass.index', $subjectClass->id) }}"><i class="bi bi-pen"></i> Nhập điểm</a>
                                                <a class="dropdown-item" href="{{ route('admin.subjectclasses.edit', $subjectClass->id) }}"><i class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                <form action="{{ route('admin.subjectclasses.destroy', $subjectClass->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa môn học này không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item"><i class="bx bx-trash me-2"></i> Xóa</button>
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
