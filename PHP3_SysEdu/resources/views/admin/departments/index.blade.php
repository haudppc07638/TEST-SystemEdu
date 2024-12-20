@extends('layouts.master')

@section('title', 'Departments')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản lý phòng ban</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Phòng ban</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex">
                            <a href="{{ route('admin.departments.create') }}" type="submit" class="btn btn-cBlue">Thêm</a>
                        </div>
                        <!-- Table with stripped rows -->
                        <table id="tableDepartment" class="table datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>STT</th>
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
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.departments.edit', $department->id) }}"><i
                                                        class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                <button type="button" class="dropdown-item delete-department"
                                                    data-id="{{ $department->id }}">
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
                            {{ $departmentsView->links() }} 
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
    document.querySelectorAll('.delete-department').forEach(function(button) {
        button.addEventListener('click', function() {
            const departmentId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa phòng ban này?',
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
                    form.action = '{{ route('admin.departments.destroy', ':id') }}'.replace(
                        ':id', departmentId);
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
