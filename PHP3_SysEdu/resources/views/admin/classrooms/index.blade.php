@extends('layouts.master')

@section('title', 'Classrooms')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản lý phòng học</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item">Đào tạo</li>
                    <li class="breadcrumb-item active">Phòng học</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex">
                                <a href="{{ route('admin.classrooms.create') }}" type="submit"
                                    class="btn btn-cBlue">Thêm</a>
                            </div>
                            <!-- Table with stripped rows -->
                            <table id="tableClassroom" class="table datatable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã phòng học</th>
                                        <th>Vị trí</th>
                                        <th>Sức chứa</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classroomsView as $index => $classroom)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $classroom->code }}</td>
                                            <td>{{ $classroom->location ?? 'Chưa cập nhật' }}</td>
                                            <td>{{ $classroom->capacity }}</td>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.classrooms.edit', $classroom->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        <button type="button" class="dropdown-item delete-classroom"
                                                            data-id="{{ $classroom->id }}">
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
                                {{ $classroomsView->links() }} 
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
        document.querySelectorAll('.delete-classroom').forEach(function(button) {
            button.addEventListener('click', function() {
                const classroomId = this.getAttribute('data-id');
    
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa phòng học này?',
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
                        form.action = '{{ route('admin.classrooms.destroy', ':id') }}'.replace(
                            ':id', classroomId);
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
