@extends('layouts.master')

@section('title', 'Chọn Giáo Viên')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Chọn Giáo Viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                <li class="breadcrumb-item active">Chọn Giáo Viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body p-5">

                        <table id="sysTable" class="table datatable table-striped" style="width:100%">
                            <tbody>
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.schedules.index', [
                                                'facultyId' => request('facultyId'),
                                                'majorId' => request('majorId'),
                                                'subjectId' => request('subjectId'),
                                                'semesterId' => request('semesterId'),
                                                'teacherId' => $teacher->id // Thêm ID giáo viên vào URL
                                            ]) }}">
                                                <i class="bi bi-person-fill"></i>
                                                {{ $teacher->fullname }} <!-- Hiển thị tên giáo viên -->
                                            </a>                                            
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-4">
                            {{ $teachers->links() }} <!-- Phân trang -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection
