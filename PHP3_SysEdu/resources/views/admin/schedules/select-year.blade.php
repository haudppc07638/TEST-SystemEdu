@extends('layouts.master')

@section('title', 'Chọn Năm Học')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chọn Năm Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Chọn Năm Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.schedules.select.semester') }}" method="GET">
                            <select name="year" onchange="this.form.submit()">
                                <option value="">Chọn năm học</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </form>                                                
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- Kết thúc #main -->
@endsection
