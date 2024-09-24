@extends('layouts.master')

@section('title', 'Add Faculties')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quản Lý Khoa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Đào Tạo</li>
                <li class="breadcrumb-item active">Khoa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    @if (session('error'))
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex">
                            <a href="{{ route('admin.faculties.create') }}" type="submit" class="btn btn-primary m-2">Thêm mới</a>

                            <div class="col-lg-4">
                                <form action="{{ route('admin.faculties.index') }}" method="GET">
                                <div class="input-group m-3">
                                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm khoa" value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                                </div>
                            </form>
                            </div>
                            @if($facultiesView)
                            <ul>
                                @if(request('search') > 0 )
                                @foreach($facultiesView as $faculty)
                                   
                                @endforeach
                                @endif
                            </ul>
                        @else
                            <p>Không tìm thấy kết quả nào.</p>
                        @endif
                        </div>

                        <!-- Table with stripped rows -->
                        <table id="tableFaculty" class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên khoa</th>
                                    <th>Mã</th>
                                    <th>Trưởng khoa</th>
                                    <th>Phó khoa</th>
                                    <th>Mô tả</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>  
                                @foreach($facultiesView as $index => $faculty)                              
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $faculty->name }}</td>
                                    <td>{{ $faculty->code }}</td>
                                    <td>{{ $faculty->dean ? $faculty->dean : 'Chưa có' }}</td>
                                    <td>{{ $faculty->assistant_dean ? $faculty->assistant_dean : 'Chưa có'}}</td>
                                    <td class="text-limited">{{ $faculty->description }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.faculties.edit', $faculty->id) }}"><i class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                <form action="{{ route('admin.faculties.delete', $faculty->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa khoa này không?');">
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
                        <div class="d-flex justify-content-center">
                            {{ $facultiesView->links() }}
                        </div>
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
