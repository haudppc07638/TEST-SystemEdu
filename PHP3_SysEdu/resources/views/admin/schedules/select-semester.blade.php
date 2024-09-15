@extends('layouts.master')

@section('title', 'Chọn Kỳ Học')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chọn Kỳ Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Chọn Kỳ Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Form chọn kỳ học -->
                        <form action="{{ route('admin.schedules.select.semester') }}" method="GET">
                            <!-- Input hidden để giữ năm học đã chọn -->
                            <input type="hidden" name="year" value="{{ $year }}">

                            <!-- Dropdown chọn kỳ học -->
                            <select name="semesterId" onchange="this.form.submit()">
                                <option value="">Chọn kỳ học</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id }}">{{ $semester->block }}</option>
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
