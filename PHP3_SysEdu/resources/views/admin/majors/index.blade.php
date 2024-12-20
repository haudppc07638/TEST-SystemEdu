@extends('layouts.master')

@section('title', 'Majors')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản lý chuyên ngành</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item">Đào tạo</li>
                    <li class="breadcrumb-item active">Chuyên ngành</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex">
                                <a href="{{ route('admin.majors.create') }}" type="submit" class="btn btn-cBlue m-2">Thêm mới</a>
                            </div>
                            <div class="col-lg-12">
                                <form action="{{ route('admin.majors.index') }}" method="GET" class="mb-4">
                                    <div class="row">
                                        <!-- Dropdown chọn khoa -->
                                        <div class="col-lg-4">
                                            <select name="faculty_id" class="form-select">
                                                <option value="">Tất cả các khoa</option>
                                                @foreach ($faculties as $faculty)
                                                    <option value="{{ $faculty->id }}" 
                                                            {{ request('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                                        {{ $faculty->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                            
                                        <!-- Input tìm kiếm -->
                                        <div class="col-lg-4">
                                            <input type="text" name="search" class="form-control" 
                                                   placeholder="Tìm kiếm chuyên ngành" value="{{ request('search') }}">
                                        </div>
                            
                                        <!-- Nút lọc -->
                                        <div class="col-lg-4">
                                            <button type="submit" class="btn btn-primary">Lọc</button>
                                            <a href="{{ route('admin.majors.index') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            

                            <!-- Table -->
                            <table id="tableMajor" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Khoa</th>
                                        <th>Chuyên ngành</th>
                                        <th>Mã</th>
                                        <th>Tín Chỉ <small><i>(Yêu cầu)</i></small></th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($majorsView as $index => $major)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $major->faculty->name ?? 'Chưa sắp' }}</td>
                                            <td>{{ $major->name }}</td>
                                            <td>{{ $major->code }}</td>
                                            <td>{{ $major->total_credits }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.majors.edit', $major->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        <!-- Xóa tin tức với popup xác nhận -->
                                                        <button type="button" class="dropdown-item delete-major"
                                                            data-id="{{ $major->id }}">
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
                                {{ $majorsView->links() }} 
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
    document.querySelectorAll('.delete-major').forEach(function(button) {
        button.addEventListener('click', function() {
            const majorId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa chuyên ngành này?',
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
                    form.action = '{{ route('admin.majors.destroy', ':id') }}'.replace(
                        ':id', majorId); // Sửa URL
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
