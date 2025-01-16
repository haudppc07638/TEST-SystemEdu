@extends('layouts.master')

@section('title', 'Credits')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tín chỉ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                <li class="breadcrumb-item">Đào tạo</li>
                <li class="breadcrumb-item active">Tín chỉ</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="card-title d-lg-flex">
                            <a href="{{ route('admin.credits.create') }}" type="submit" class="btn btn-cBlue">Thêm</a>
                        </div> --}}
                        <!-- Table with stripped rows -->
                        <table id="tableDepartment" class="table datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Giá Tiền (1TC)</th>
                                    <th>Tỷ lệ tăng <i class="fw-normal">(%/năm)</i></th>
                                    <th>Thành tiền</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($creditView as $index => $credit)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ number_format($credit->price) }} VND</td>
                                    <td>{{ $credit->vat }}</td>
                                    <td>{{ number_format($credit->total_price) }} VND</td>
                                    <td>{{ \Carbon\Carbon::parse($credit->updated_at)->translatedFormat('d/m/Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.credits.edit', $credit->id) }}"><i class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                {{-- <form action="{{ route('admin.credits.destroy', $credit->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng ban này không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item"><i class="bx bx-trash me-2"></i> Xóa</button>
                                                </form> --}}
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


@push('script')
    <script>
        // Thêm sự kiện xóa tin tức
        document.querySelectorAll('.delete-credit').forEach(function(button) {
            button.addEventListener('click', function() {
                const creditId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa tín chỉ này?',
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
                        form.action = '{{ route('admin.credits.destroy', ':id') }}'.replace(
                            ':id', creditId); // Sửa URL
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
