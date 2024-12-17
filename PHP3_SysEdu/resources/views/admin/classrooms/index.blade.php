@extends('layouts.master')

@section('title', 'Classrooms')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quản lý phòng học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                <li class="breadcrumb-item">Đào tạo</li>
                <li class="breadcrumb-item active">Phòng học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-end">
                        <a href="{{ route('admin.classrooms.create') }}" type="submit" class="btn btn-success mt-4">Thêm
                            mới</a>
                    </div>
                    <!-- Table with stripped rows -->
                    <table id="tableClassroom" class="table datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mã phòng học</th>
                                <th>Sức chứa</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classroomsView as $index => $classroom)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $classroom->code }}</td>
                                <td>{{ $classroom->capacity }}</td>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.classrooms.edit', $classroom->id) }}"><i
                                                    class="bx bx-edit-alt me-2"></i> Sửa</a>
                                            <form
                                                action="{{ route('admin.classrooms.destroy', $classroom->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
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
<script>
    $(document).ready(function() {
        initializeDataTable('#tableClassroom', 'Danh sách các phòng học System Education', 'danh_sach_phong_hoc_sysem_education_');
    });
</script>
@endpush