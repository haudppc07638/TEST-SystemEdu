@extends('layouts.master')

@section('title', 'students')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản lý sinh viên</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item">Sinh viên</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex">
                                <a href="{{ route('admin.students.create') }}" type="submit"
                                    class="btn btn-cBlue mt-2">Thêm</a>
                            </div>
                            <table id="tableStudent" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Họ và tên</th>
                                        <th>MSSV</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Ảnh</th>
                                        <th>Chuyên ngành</th>
                                        <th>Lớp học</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->full_name }}</td>
                                            <td>{{ $student->code }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>{{ $student->phone }}</td>
                                            <td>
                                                <img src="{{ $student->image ? asset('storage/avatars/' . $student->image) : asset('assets/images/default-avatar1.jpg') }}"
                                                    alt="avatar" class="rounded-circle" width="40px" height="40px">
                                            </td>
                                            <td>{{ $student->major->name ?? 'Chưa có chuyên ngành' }}</td>
                                            <td>{{ $student->stuClass->name ?? 'Chưa có lớp học' }}</td>

                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.students.detail', $student->id) }}"><i
                                                                class="bx bx-id-card me-2"></i> Xem chi tiết</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.students.edit', $student->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        <!-- Xóa tin tức với popup xác nhận -->
                                                        <button type="button" class="dropdown-item delete-student"
                                                            data-id="{{ $student->id }}">
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
                                {{ $students->links() }}
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
    // Thêm sự kiện xóa chuyên ngành
    document.querySelectorAll('.delete-student').forEach(function(button) {
        button.addEventListener('click', function() {
            const studentId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa sinh viên này?',
                text: "Việc này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tạo form xóa chuyên ngành
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.students.destroy', ':id') }}'.replace(
                        ':id', studentId); // Sửa URL
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
