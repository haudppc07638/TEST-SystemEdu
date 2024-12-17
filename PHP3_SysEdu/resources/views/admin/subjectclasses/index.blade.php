@extends('layouts.master')

@section('title', 'Subject Classes')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản lý lớp môn</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                <li class="breadcrumb-item">Đào tạo</li>
                <li class="breadcrumb-item active">Lớp môn</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3 d-flex flex-column">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('admin.subjectclasses.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Thêm mới
                            </a>
                        </div>
                        <table id="tableSubjectClass" class="table table-striped table-bordered datatable">
                            <thead class="table datatable">
                                <tr>
                                    <th>#</th>
                                    <th>Tên Lớp</th>
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
                                @foreach($subjectClasses as $index => $subjectClass)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $subjectClass->name }}</td>
                                    <td>{{ $subjectClass->quantity }}</td>
                                    <td>{{ $subjectClass->start_date }}</td>
                                    <td>{{ $subjectClass->end_date }}</td>
                                    <td>{{ $subjectClass->registration_deadline }}</td>
                                    <td>{{ $subjectClass->employee->full_name ?? 'Chưa có' }}</td>
                                    <td>{{ $subjectClass->subject->name ?? 'Chưa có' }}</td>
                                    <td>{{ $subjectClass->semester->block ?? 'Chưa có' }}</td>
                                    <td>{{ $subjectClass->price }}</td>
                                    <td>{{ $subjectClass->majorClass->name ?? 'Chưa có' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('admin.schedules.view-schedule', ['subject_class_id' => $subjectClass->id]) }}" class="dropdown-item">
                                                    <i class="bi bi-calendar"></i> Xem Lịch Học
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.schedules.create', ['subject_class_id' => $subjectClass->id]) }}">
                                                    <i class="bi bi-calendar-plus"></i> Tạo lịch
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.studentsubjectclass.index', $subjectClass->id) }}">
                                                    <i class="bi bi-pen"></i> Nhập điểm
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.subjectclasses.edit', $subjectClass->id) }}">
                                                    <i class="bi bi-pencil-square"></i> Chỉnh sửa
                                                </a>
                                                <form action="{{ route('admin.subjectclasses.destroy', $subjectClass->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa môn học này không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash"></i> Xóa
                                                    </button>
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