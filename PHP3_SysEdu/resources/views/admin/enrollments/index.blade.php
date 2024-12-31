@extends('layouts.master')

@section('title', 'Departments')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hồ sơ tuyển sinh Online</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Hồ sơ tuyển sinh Online</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Table with stripped rows -->
                        <table id="tableDepartment" class="table datatable mt-4" style="width:100%">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Ngày sinh</th>
                                    <th>Giới tính</th>
                                    <th>Quốc tịch</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Thời gian đăng ký</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrollments as $index => $enrollment)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $enrollment->full_name }}</td>
                                    <td>{{ $enrollment->date_of_birth }}</td>
                                    <td>{{ $enrollment->gender == 0 ? 'Nam' : 'Nữ' }}</td>
                                    <td>{{ $enrollment->nation }}</td>
                                    <td>{{ $enrollment->phone }}</td>
                                    <td>{{ $enrollment->email }}</td>
                                    <td>{{ $enrollment->created_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.enrollments.detail', $enrollment->id) }}"><i
                                                        class="bx bx-edit-alt me-2"></i> Chi tiết</a>  
                                                <button type="button" class="dropdown-item delete-enrollment"
                                                    data-id="{{ $enrollment->id }}">
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
                            {{ $enrollments->links() }} 
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
    document.querySelectorAll('.delete-enrollment').forEach(function(button) {
        button.addEventListener('click', function() {
            const enrollmentId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa đăng ký này?',
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
                    form.action = '{{ route('admin.enrollments.destroy', ':id') }}'.replace(
                        ':id', enrollmentId);
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
