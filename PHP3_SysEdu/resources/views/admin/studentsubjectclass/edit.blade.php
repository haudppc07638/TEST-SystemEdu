@extends('layouts.master')

@section('title', 'Edit Student Subject Class')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Thêm, Sửa Điểm Sinh Viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">>Sinh viên</li>
                <li class="breadcrumb-item active">Thêm, Sửa Điểm Sinh Viên</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <form class="row g-3 mt-3 needs-validation" novalidate method="POST" action="{{ route('admin.studentsubjectclass.update', $editstudentsubjectclass->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                
                <div class="col-md-12">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" class="form-control " name="fullname" readonly value="{{ old('fullname', $editstudentsubjectclass->student->fullname) }}">
                </div>

               
                <div class="col-md-12 mb-2">
                    <label class="form-label">Mã sinh viên</label>
                    <input type="text" class="form-control" name="code" readonly value="{{ old('code', $editstudentsubjectclass->student->code) }}">
                </div>

               
                <div class="col-md-12 mb-2">
                    <label class="form-label">Điểm Giữa Kỳ</label>
                    <input type="number" step="0.25" class="form-control @error('midterm_score') is-invalid @enderror" name="midterm_score" value="{{ old('midterm_score', $editstudentsubjectclass->midterm_score) }}">
                    @error('midterm_score')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

              
                <div class="col-md-12 mb-2">
                    <label class="form-label">Điểm Cuối Kỳ</label>
                    <input type="number" step="0.25" class="form-control @error('final_score') is-invalid @enderror" name="final_score" value="{{ old('final_score', $editstudentsubjectclass->final_score) }}">
                    @error('final_score')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

</main><!-- End #main -->
@endsection
