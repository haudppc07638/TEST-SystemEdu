@extends('layouts.master')

@section('title', 'Subjects')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản lý môn</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item">Đào tạo</li>
                    <li class="breadcrumb-item active">Môn</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex">
                                <a href="{{ route('admin.subjects.create') }}" class="btn btn-cBlue  m-2">Thêm</a>
                            </div>
                            <form action="{{ route('admin.subjects.index') }}" method="GET" class="mb-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <select name="major_id" class="form-select">
                                            <option value="">Tất cả chuyên ngành</option>
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}"
                                                    {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                                    {{ $major->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Tìm kiếm môn học" value="{{ request('search') }}">
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
                                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <!-- Bảng danh sách môn học -->
                            <table id="tableSubject" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã môn</th>
                                        <th>Tên môn</th>
                                        <th>Chuyên ngành</th>
                                        <th>Tín Chỉ</th>
                                        <th>Môn tiên quyết</th>
                                        <th>Mô tả</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjectView as $index => $subject)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $subject->code }}</td>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ $subject->major->name ?? 'Môn cơ bản' }}</td>
                                            <td>{{ $subject->credit }}</td>
                                            <td>
                                                @if ($subject->prerequisites->isNotEmpty())
                                                    {{ $subject->prerequisites->pluck('name')->implode(', ') }}
                                                @else
                                                    Không có
                                                @endif
                                            </td>
                                            <td class="text-limited">{{ $subject->description }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.subjects.detail', $subject->id) }}"><i
                                                                class="bx bx-id-card me-2"></i> Xem chi tiết</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.subjects.edit', $subject->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        <button type="button" class="dropdown-item delete-subject"
                                                            data-id="{{ $subject->id }}">
                                                            <i class="bx bx-trash me-2"></i> Xóa
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
        document.querySelectorAll('.delete-subject').forEach(function(button) {
            button.addEventListener('click', function() {
                const subjectId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa môn học này?',
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
                        form.action = '{{ route('admin.subjects.destroy', ':id') }}'.replace(
                            ':id', subjectId);
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
