@extends('layouts.master')

@section('timeslots', 'Thời Gian')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản Lý Thời Gian</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Thời Gian</li>
                    <li class="breadcrumb-item active">Danh Sách Thời Gian</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                @if (session('success'))
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-x-circle me-1"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a href="{{ route('admin.timeslots.create') }}" type="submit" class="btn btn-primary m-2">Thêm mới</a>
                            </div>
                            <table id="tableTimeSlot" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ca </th>
                                        <th>Thời Gian Bắt Đầu</th>
                                        <th>Thời Gian Kết Thúc</th>
                                        <th>Tác Vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timeSlotsView as $index => $timeSlot)
                                        <tr>
                                            <td> {{ $index + 1 }} </td>
                                            <td>{{ $timeSlot->slot }}</td>
                                            <td>{{ $timeSlot->start_time }}</td>
                                            <td>{{ $timeSlot->end_time }}</td>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.timeslots.edit', $timeSlot->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Sửa</a>
                                                        <form action="{{ route('admin.timeslots.destroy', $timeSlot->id) }}"
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
@endpush
