@extends('layouts.master')

@section('title', 'Loại Điểm')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản lý loại điểm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Điểm</li>
                <li class="breadcrumb-item active">Loại điểm quá trình</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex">
                            <a href="{{ route('admin.score_types.create') }}" class="btn btn-cBlue">Thêm</a>
                        </div>

                        <!-- Table -->
                        <table id="tableScoreType" class="table datatable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên loại điểm</th>
                                    <th>Thuộc loại</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scoreTypes as $index => $scoreType)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $scoreType->name }}</td>
                                        <td>{{ $scoreType->type === 'multi' ? 'Điểm quá trình' : 'Điểm bảo vệ'}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.score_types.edit', $scoreType->id) }}"><i
                                                            class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                    <!-- Xóa tin tức với popup xác nhận -->
                                                    <button type="button" class="dropdown-item delete-score-type"
                                                        data-id="{{ $scoreType->id }}">
                                                        <i class="bx bx-trash me-2"></i> Xóa
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table -->

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
    document.querySelectorAll('.delete-score-type').forEach(function(button) {
        button.addEventListener('click', function() {
            const scoreTypeId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa loại điểm này?',
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
                    form.action = '{{ route('admin.score_types.destroy', ':id') }}'.replace(
                        ':id', scoreTypeId); // Sửa URL
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
