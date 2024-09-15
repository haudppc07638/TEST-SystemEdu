@extends('layouts.master')

@section('title', 'Departments')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản Lý Lớp Chuyên Ngành<h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Trang Chủ</a></li>
                            <li class="breadcrumb-item">Khoa</li>
                            <li class="breadcrumb-item">Chuyên ngành</li>
                            <li class="breadcrumb-item active">Lớp chuyên ngành </li>
                        </ol>
                    </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a href="{{ route('admin.create', $major->id) }}" type="submit"
                                    class="btn btn-primary m-2">Thêm mới</a>
                            </div>
                            <!-- Table with stripped rows -->
                            <table id="tableClass" class="table datatable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hê đào tạo</th>
                                        <th>Tên</th>
                                        <th>Số lượng</th>
                                        <th>Chuyên ngành</th>
                                        <th>Chủ nhiệm</th>
                                        <th>Tình trạng</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classes as $index => $class)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $class->trainingsystem }}</td>
                                            <td>{{ $class->name }}</td>
                                            <td>{{ $class->quantity }}</td>
                                            <td>{{ $class->major->name }}</td>
                                            <td>{{ $class->employee->fullname }}</td>
                                            <td>
                                                @if ($class->status == 0)
                                                    <form action="{{ route('admin.updateStatus', $class->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn đánh dấu lớp này là đã kết thúc?')">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="badge bg-warning text-dark"
                                                            style="border: none; background: none; cursor: pointer;">
                                                            Đang học
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-success">Đã kết thúc</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.edit', $class->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        <form action="{{ route('admin.destroy', $class->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa lớp chuyên ngành này không?');">
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
