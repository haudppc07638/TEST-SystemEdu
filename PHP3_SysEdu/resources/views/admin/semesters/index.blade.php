@extends('layouts.master')

@section('title', 'Danh Sách Học Kỳ')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản lý học kỳ</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item">Học kỳ</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex">
                                <a href="{{ route('admin.semesters.create') }}" type="submit"
                                    class="btn btn-cBlue m-2">Thêm</a>
                            </div>
                            <table id="tableSemester" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Kỳ</th>
                                        <th>Năm</th>
                                        <th>Bắt đầu</th>
                                        <th>Kết thúc</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semestersView as $index => $semester)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $semester->block }}</td>
                                            <td>{{ $semester->year }}</td>
                                            <td>{{ $semester->start_date }}</td>
                                            <td>{{ $semester->end_date }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.semesters.edit', $semester->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        <button type="button" class="dropdown-item delete-semester"
                                                            data-id="{{ $semester->id }}">
                                                            <i class="bx bx-trash me-2"></i> Xóa
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                            <div class="d-flex justify-content-end">
                                {{ $semestersView->links() }} 
                            </div>

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
        document.querySelectorAll('.delete-semester').forEach(function(button) {
            button.addEventListener('click', function() {
                const semesterId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa học kỳ này?',
                    text: "Việc này không thể hoàn tác!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('admin.semesters.destroy', ':id') }}'.replace(
                            ':id', semesterId);
                        form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
