@extends('layouts.master')

@section('title', 'Add Faculties')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản lý khoa</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item">Đào tạo</li>
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
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <!-- Nút thêm mới nằm sát trái -->
                                <a href="{{ route('admin.faculties.create') }}" class="btn btn-cBlue">Thêm</a>

                                <!-- Form tìm kiếm nằm sát phải -->
                                <form action="{{ route('admin.faculties.index') }}" method="GET" class="d-flex">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Tìm kiếm khoa" value="{{ request('search') }}">
                                        <button class="btn btn-primary text-white" type="submit">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>
                            @if ($facultiesView)
                                <ul>
                                    @if (request('search') > 0)
                                        @foreach ($facultiesView as $faculty)
                                        @endforeach
                                    @endif
                                </ul>
                            @else
                                <p>Không tìm thấy kết quả nào.</p>
                            @endif


                            <!-- Table with stripped rows -->
                            <table id="tableFaculty" class="table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên khoa</th>
                                        <th>Mã</th>
                                        {{-- <th>Trưởng khoa</th>
                                        <th>Phó khoa</th> --}}
                                        <th>Mô tả</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($facultiesView as $index => $faculty)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $faculty->name }}</td>
                                            <td>{{ $faculty->code }}</td>
                                            {{-- <td>{{ $faculty->dean ? $faculty->dean : 'Chưa có' }}</td>
                                            <td>{{ $faculty->assistant_dean ? $faculty->assistant_dean : 'Chưa có' }}</td> --}}
                                            <td class="text-limited">{{ $faculty->description }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.faculties.edit', $faculty->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        <!-- Xóa tin tức với popup xác nhận -->
                                                        <button type="button" class="dropdown-item delete-faculty"
                                                            data-id="{{ $faculty->id }}">
                                                            <i class="bx bx-trash me-2"></i> Xóa
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Không tìm thấy kết quả nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
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
    <script>
        // Thêm sự kiện xóa tin tức
        document.querySelectorAll('.delete-faculty').forEach(function(button) {
            button.addEventListener('click', function() {
                const facultyId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa khoa này?',
                    text: "Việc này không thể hoàn tác!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tạo form xóa tin tức
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('admin.faculties.destroy', ':id') }}'.replace(
                            ':id', facultyId); // Sửa URL
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
