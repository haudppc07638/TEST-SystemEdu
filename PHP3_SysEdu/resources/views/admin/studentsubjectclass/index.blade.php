@extends('layouts.master')

@section('title', 'students')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quản Lý Điểm Sinh Viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Sinh Viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            @if (session('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        
                        <div class="card-title">
                           
                        </div>

                        <!-- Table with stripped rows -->
                        <table id="sysTable" class="table datatable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ và tên</th>
                                    <th>Mã sinh viên</th>
                                    <th>Email</th>
                                    <th>Điểm Giữa Kỳ</th>
                                    <th>Điểm Cuối Kỳ</th>
                                    <th>Điểm Trung Bình</th>
                                    <th>Xếp Loại</th>
                                    <th>Lớp Môn</th>
                                    <th>Trạng Thái</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentSubjectClassView as $index => $studentSubjectClass)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $studentSubjectClass->student->fullname }}</td>
                                    <td>{{ $studentSubjectClass->student->code }}</td>
                                    <td>{{ $studentSubjectClass->student->email }}</td>
                                    <td>{{ $studentSubjectClass->midterm_score }}</td>
                                    <td>{{ $studentSubjectClass->final_score }}</td>
                                    <td>{{ $studentSubjectClass->total_score }}</td>
                                    <td>{{ $studentSubjectClass->classification }}</td>
                                    <td>{{ $studentSubjectClass->subjectClass->id }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.studentsubjectclass.edit', $studentSubjectClass->id) }}">
                                                    <i class="bx bx-edit-alt me-2"></i> Chỉnh sửa
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{-- <form action="{{ route('admin.', $studentSubjectClass->id) }}" method="POST"> --}}
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="status">Trạng thái</label>
                                                <select name="status" id="status" class="form-select">
                                                    <option value="passed" {{ $studentSubjectClass->status == 'passed' ? 'selected' : '' }}>Passed</option>
                                                    <option value="failed" {{ $studentSubjectClass->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                </select>
                                            </div>
                                        </form>
                                    </td>                                    

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
