@extends('layouts.master')

@section('title', 'Classes')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Các Khoa </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Khoa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body p-5">

                            <!-- Table with stripped rows -->
                            <table id="sysTable" class="table datatable table-striped" style="width:100%">

                                <tbody>
                                    @foreach ($faculties as $faculty)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.majors', $faculty->id) }}">
                                                    <i class="bi bi-folder-fill"></i>
                                                    {{ $faculty->name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
                            <!-- End Table with stripped rows -->
                            
                            <div class="d-flex justify-content-end mt-4">
                                {{ $faculties->links() }}
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
