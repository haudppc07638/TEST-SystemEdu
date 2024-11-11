@extends('layouts.lecturer')

@section('title', 'Tra cứu thông tin sinh viên')

@section('main')
    <main id="main" class="main">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tra cứu thông tin sinh viên</h5>

                <div class="search-box mb-4">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Nhập tên, mã sinh viên hoặc email..." autocomplete="off">
                        <button class="btn btn-primary" type="button" id="searchButton">
                            <i class="bi bi-search"></i> Tìm kiếm
                        </button>
                    </div>
                    <small class="text-muted">
                        Ví dụ: Thai Van A, SV001, example@gmail.com
                    </small>
                </div>

                <!-- Kết quả tìm kiếm -->
                <div id="searchResults" class="mt-4">
                    <!-- Kết quả sẽ được load động ở đây -->
                </div>
            </div>
        </div>
    </main>
@endsection

@push('style')
    <style>
        .search-box {
            max-width: 600px;
            margin: 0 auto;
        }

        .loading {
            text-align: center;
            padding: 20px;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            let searchTimeout;

            function performSearch() {
                const searchTerm = $('#searchInput').val().trim();

                if (searchTerm.length < 1) {
                    $('#searchResults').html('<div class="alert alert-info">Vui lòng nhập ít nhất 1 ký tự</div>');
                    return;
                }

                $('#searchResults').html(
                    '<div class="loading"><i class="bi bi-hourglass-split"></i> Đang tìm kiếm...</div>');

                $.ajax({
                    url: '{{ route('student.search') }}',
                    type: 'GET',
                    data: {
                        search_term: searchTerm
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#searchResults').html(response.data);
                        } else {
                            $('#searchResults').html(
                                `<div class="alert alert-warning">${response.message}</div>`);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#searchResults').html('<div class="alert alert-danger">Có lỗi xảy ra: ' +
                            error + '</div>');
                    }
                });
            }

            // Tìm kiếm

            $('#searchButton').click(performSearch);

            $('#searchInput').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 500);
            });

            $('#searchInput').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    performSearch();
                }
            });
        });
    </script>
@endpush
