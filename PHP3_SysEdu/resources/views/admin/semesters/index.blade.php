@extends('layouts.master')

@section('title', 'Danh Sách Học Kỳ')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản Lý Học Kỳ</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Học Kỳ</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a href="{{ route('admin.semesters.create') }}" type="submit"
                                    class="btn btn-primary m-2">Thêm mới</a>
                            </div>
                            <table id="tableSemester" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Kỳ</th>
                                        <th>Năm</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semestersView as $index => $semester)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $semester->block }}</td>
                                            <td>{{ $semester->year }}</td>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.semesters.edit', $semester->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Sửa</a>
                                                        <form action="{{ route('admin.semesters.destroy', $semester->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
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
