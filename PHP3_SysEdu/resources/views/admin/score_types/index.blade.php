@extends('layouts.master')

@section('title', 'Loại Điểm')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản Lý Loại Điểm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Điểm</li>
                <li class="breadcrumb-item active">Loại Điểm</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <a href="{{ route('admin.score_types.create') }}" class="btn btn-primary m-2">Thêm Mới</a>
                        </div>

                        <!-- Table -->
                        <table id="tableScoreType" class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên Loại Điểm</th>
                                    <th>Tác Vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scoreTypes as $index => $scoreType)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $scoreType->name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" 
                                                        data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" 
                                                       href="{{ route('admin.score_types.edit', $scoreType->id) }}">
                                                        <i class="bx bx-edit-alt me-2"></i> Chỉnh Sửa
                                                    </a>
                                                    <form action="{{ route('admin.score_types.delete', $scoreType->id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa loại điểm này không?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="bx bx-trash me-2"></i> Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table -->

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
