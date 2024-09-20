@extends('layouts.master')

@section('title', 'students')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản Lý Điểm Sinh Viên</h1>
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

                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5>Danh sách điểm sinh viên</h5>
                                <div class="btn-group">
                                    <a href="{{ route('admin.studentsubjectclass.export', $subjectClassId) }}"
                                        class="btn btn-sm btn-success me-2">
                                        <i class="bi bi-file-earmark-excel me-1"></i> Xuất Excel
                                    </a>
                                    @if (!$isExpired && !$isBeforeStart)
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#importExcelModal">
                                            <i class="bi bi-file-earmark-excel me-1"></i> Nhập điểm từ Excel
                                        </button>
                                    @endif
                                </div>

                            </div>

                            <!-- Table with stripped rows -->
                            <table id="sysTable" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Họ và tên</th>
                                        <th>Mã sinh viên</th>
                                        <th>Email</th>
                                        <th>Điểm Giữa Kỳ</th>
                                        <th>Điểm Cuối Kỳ</th>
                                        <th>Điểm Trung Bình</th>
                                        <th>Xếp Loại</th>
                                        <th>Lớp Môn</th>
                                        <th>Trạng Thái</th>
                                        @if (!$isExpired && !$isBeforeStart)
                                        <th>Tác vụ</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($studentSubjectClasses as $index => $studentSubjectClass)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $studentSubjectClass->student->fullname }}</td>
                                            <td>{{ $studentSubjectClass->student->code }}</td>
                                            <td>{{ $studentSubjectClass->student->email }}</td>
                                            <td>{{ $studentSubjectClass->midterm_score }}</td>
                                            <td>{{ $studentSubjectClass->final_score }}</td>
                                            <td>{{ $studentSubjectClass->total_score }}</td>
                                            <td>{{ $studentSubjectClass->classification }}</td>
                                            <td>{{ $studentSubjectClass->subjectClass->name }}</td>
                                            <td>
                                                @if ($studentSubjectClass->status == 'passed')
                                                    <span class="badge bg-success">Pass</span>
                                                @else
                                                    <span class="badge bg-danger">Fail</span>
                                                @endif
                                            </td>
                                            @if (!$isExpired && !$isBeforeStart)
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.studentsubjectclass.edit', $studentSubjectClass->id) }}">
                                                                <i class="bx bx-edit-alt me-2"></i> Chỉnh sửa
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
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

    <!-- Modal -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importExcelModalLabel">Nhập điểm từ file Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.studentsubjectclass.import', $subjectClassId) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Chọn file Excel</label>
                            <input class="form-control" type="file" id="excel_file" name="file" accept=".xlsx, .xls"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Nhập điểm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
