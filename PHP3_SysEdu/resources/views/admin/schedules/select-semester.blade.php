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
                        <form action="{{ route('admin.schedules.select.semester') }}" method="GET" id="selectSemesterForm">
                            <div class="form-group">

                                <input type="hidden" name="year" value="{{ $year }}">

                                <label for="semesterId">Chọn Kỳ Học:</label>
                                <select name="semesterId" id="semesterId" class="form-select" onchange="this.form.submit()">
                                    <option value="">Chọn kỳ học</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->block }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- Kết thúc #main -->
@endsection
