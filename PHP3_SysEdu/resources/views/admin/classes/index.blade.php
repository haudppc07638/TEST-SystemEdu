@extends('layouts.master')

@section('title', 'Major Classes')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Quản Lý Lớp Chuyên Ngành</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Lớp Chuyên Ngành</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a href="{{ route('admin.classes.create') }}" type="submit" class="btn btn-cBlue m-2">Thêm</a>
                            </div>

                            <form method="GET" action="{{ route('admin.classes.index') }}">
                                <div class="row mb-3">
                                    <div class="col-md-5">                       
                                        <select id="facultySelect" name="faculty_id" class="form-select">
                                            <option value=""> -- Chọn Khoa -- </option>
                                            @foreach ($faculties as $faculty)
                                                <option value="{{ $faculty->id }}" {{ request('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                                    {{ $faculty->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-5">
                                        <select id="majorSelect" name="major_id" class="form-select">
                                            <option value=""> -- Chọn Chuyên Ngành -- </option>
                                            @foreach ($faculties as $faculty)
                                                @foreach ($faculty->majors as $major)
                                                    <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                                        {{ $major->name }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-start align-items-center">
                                        <button type="submit" class="btn btn-cBlue">Lọc</button>
                                    </div>
                                </div>

                            </form>

                            <!-- Table with stripped rows -->
                            <table id="tableDepartment" class="table datatable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên lớp</th>
                                        <th>Số lượng</th>
                                        <th>Chuyên ngành</th>
                                        <th>Cố vấn</th>
                                        <th>Tình trạng</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($majorClasses as $index => $class)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $class->name }}</td>
                                            <td>{{ $class->quantity }}</td>
                                            <td>{{ $class->major->name }}</td>
                                            <td>{{ $class->employee->full_name }}</td>
                                            <td>
                                                @if ($class->status == 0)
                                                    <form action="{{ route('admin.classes.updateStatus', $class->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn đánh dấu lớp này là đã kết thúc?')">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="badge bg-warning text-dark"
                                                            style="border: none; background: none; cursor: pointer;">
                                                            Đang học
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-success">Đã kết thúc</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($class->start_date)->translatedFormat('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($class->end_date)->translatedFormat('d/m/Y') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('admin.classes.detail', $class->id) }}"><i class="bx bx-info-circle me-2"></i> Chi tiết</a>
                                                        <a class="dropdown-item" href="{{ route('admin.classes.edit', $class->id) }}"><i class="bx bx-edit-alt me-2"></i> Chỉnh sửa</a>
                                                        <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lớp chuyên ngành này không?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item"><i class="bx bx-trash me-2"></i> Xóa</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                            <div class="d-flex justify-content-end">
                                {{ $majorClasses->links() }} 
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
        document.addEventListener('DOMContentLoaded', function() {
            $('#facultySelect').change(function() {
                let faculty_id = $(this).val();
                if (faculty_id) {
                    $.ajax({
                        url: '{{ route('majors.by.faculty') }}',
                        type: 'GET',
                        data: {
                            faculty_id: faculty_id
                        },
                        success: function(data) {
                            let majorSelect = $('#majorSelect');
                            majorSelect.empty();
                            majorSelect.append('<option value=""> -- Chọn Chuyên Ngành -- </option>');
                            $.each(data, function(index, major) {
                                majorSelect.append('<option value="' + major.id + '">' + major.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#majorSelect').empty().append('<option value=""> -- Chọn Chuyên Ngành -- </option>');
                }
            });
        });
    </script>
@endpush
