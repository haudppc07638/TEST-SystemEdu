@extends('layouts.master')

@section('title', 'Subjects')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản Lý Môn</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Đào Tạo</li>
                <li class="breadcrumb-item active">Môn</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <a href="{{ route('admin.subjects.create') }}" type="submit" class="btn btn-primary m-2">Thêm mới</a>
                        </div>      
                        <table id="tableSubject" class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mã môn học</th>
                                    <th>Tên môn học </th>
                                    <th>Chuyên ngành </th>
                                    <th>Mô tả</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjectView as $index => $subject)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $subject->code }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->major->name ?? 'N/A' }}</td>
                                    <td class="text-limited">{{ $subject->description }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.subjects.edit', $subject->id) }}"><i class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa môn học này không?');">
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
