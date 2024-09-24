@extends('layouts.master')

@section('title', 'Chọn Môn Học')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Chọn Môn Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                <li class="breadcrumb-item active">Chọn Môn Học</li>
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
                                @foreach ($subjects as $subject)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.schedules.select.teacher', ['facultyId' => $facultyId, 'majorId' => $majorId, 'subjectId' => $subject->id]) }}">
                                                <i class="bi bi-folder-fill"></i>
                                                {{ $subject->name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-4">
                            {{ $subjects->links() }}
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
@endpush
