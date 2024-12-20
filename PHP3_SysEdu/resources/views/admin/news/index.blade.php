@extends('layouts.master')

@section('title', 'News')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản lý tin tức</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                <li class="breadcrumb-item">Tin tức</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-end">
                            <a href="{{ route('admin.news.create') }}" type="submit" class="btn btn-success">Thêm mới</a>
                        </div>
                        <!-- Table with stripped rows -->
                        <table id="tableDepartment" class="table datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Ảnh</th>
                                    <th>Ngày đăng</th>
                                    <th>Tác vụ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($news as $index => $news)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td class="text-limited">{{ $news->title }}</td>
                                    <td>
                                        @if ($news->image && file_exists(public_path('storage/' . $news->image)))
                                            <img src="{{ asset('storage/' . $news->image) }}" alt="Ảnh tin tức" class="news-image">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $news->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.news.edit', $news->id) }}"><i class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                <!-- Xóa tin tức với popup xác nhận -->
                                                <button type="button" class="dropdown-item delete-news" data-id="{{ $news->id }}">
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
    // Thêm sự kiện xóa tin tức
    document.querySelectorAll('.delete-news').forEach(function(button) {
        button.addEventListener('click', function() {
            const newsId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa tin tức này?',
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
                    form.action = '{{ route("admin.news.destroy", ":id") }}'.replace(':id', newsId);  // Sửa URL
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
