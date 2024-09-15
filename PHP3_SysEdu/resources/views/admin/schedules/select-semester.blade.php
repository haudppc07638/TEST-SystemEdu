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
                        <form id="selectSemesterForm">
                            <div class="form-group">
                                <label for="semesterId">Chọn Kỳ Học:</label>
                                <select name="semesterId" id="semesterId" class="form-select" required>
                                    <option value="">Chọn kỳ học</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->block }} - {{ $semester->year }}</option>
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

@push('script')
<script>
    document.getElementById('semesterId').addEventListener('change', function() {
        var semesterId = this.value;
        if (semesterId) {
            // Chuyển hướng đến route 'create' với tham số semesterId
            window.location.href = "{{ route('admin.schedules.create', ['semesterId' => ':semesterId']) }}".replace(':semesterId', semesterId);
        }
    });
</script>
@endpush
@endsection
