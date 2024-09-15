@extends('layouts.master')

@section('title', 'Departments')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản Lý Phòng Ban</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Trang Chủ</a></li>
                <li class="breadcrumb-item">Đào Tạo</li>
                <li class="breadcrumb-item active">Phòng Ban</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <a href="{{ route('admin.departments.create') }}" type="submit" class="btn btn-primary m-2">Thêm mới</a>
                        </div>
                        <!-- Table with stripped rows -->
                        <table id="tableDepartment" class="table datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên phòng</th>
                                    <th>Vị trí</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentsView as $index => $department)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->location }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.departments.edit', $department->id) }}"><i class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng ban này không?');">
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
