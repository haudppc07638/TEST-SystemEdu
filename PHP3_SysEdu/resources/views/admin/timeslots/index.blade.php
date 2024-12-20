@extends('layouts.master')

@section('timeslots', 'Thời Gian')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản lý thời gian ca học</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Thời gian ca học</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex">
                                <a href="{{ route('admin.timeslots.create') }}" type="submit"
                                    class="btn btn-cBlue m-2">Thêm</a>
                            </div>
                            <table id="tableTimeSlot" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ca </th>
                                        <th>Thời gian bắt đầu</th>
                                        <th>Thời gian kết thúc</th>
                                        <th>Tác vụ</th>
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
                                                                class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        <button type="button" class="dropdown-item delete-timeslot"
                                                            data-id="{{ $timeSlot->id }}">
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
        document.querySelectorAll('.delete-timeslot').forEach(function(button) {
            button.addEventListener('click', function() {
                const timeslotId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa ca học này?',
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
                        form.action = '{{ route('admin.timeslots.destroy', ':id') }}'.replace(
                            ':id', timeslotId);
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
