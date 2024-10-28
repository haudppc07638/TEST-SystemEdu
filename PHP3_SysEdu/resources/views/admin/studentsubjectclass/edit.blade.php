@extends('layouts.master')

@section('title', 'Edit Student Subject Class')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Thêm, Sửa Điểm Sinh Viên</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Sinh viên</li>
                    <li class="breadcrumb-item active">Thêm, Sửa Điểm Sinh Viên</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <form class="row g-3 mt-3 needs-validation" novalidate method="POST"
                    action="{{ route('admin.studentsubjectclass.update', $editstudentsubjectclass->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-12">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" name="fullname" readonly
                            value="{{ old('fullname', $editstudentsubjectclass->student->full_name) }}">
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-label">Mã sinh viên</label>
                        <input type="text" class="form-control" name="code" readonly
                            value="{{ old('code', $editstudentsubjectclass->student->code) }}">
                    </div>

                    @foreach ($subjectScoreTypes as $subjectScoreType)
                        <div class="col-md-12 mb-2">
                            <label class="form-label">{{ $subjectScoreType->scoreType->name }}
                                ({{ $subjectScoreType->weight }}%)</label>

                            @php
                                $oldScore = $editstudentsubjectclass->scores
                                    ->where('subject_score_type_id', $subjectScoreType->id)
                                    ->first();
                            @endphp

                            <input type="number" step="0.25"
                                class="form-control @error('scores.' . $subjectScoreType->id) is-invalid @enderror"
                                name="scores[{{ $subjectScoreType->id }}]"
                                value="{{ old('scores.' . $subjectScoreType->id, $oldScore ? $oldScore->score : '') }}">

                            @error('scores.' . $subjectScoreType->id)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach


                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>

    </main><!-- End #main -->
@endsection
