@extends('layouts.master')

@section('title', 'Gửi Feedback Đến Học Sinh')

@section('main')
    <main id="main" class="main">
        <h1>Gửi Feedback Đến Tất Cả Học Sinh Trong Lớp Môn</h1>

        <form action="{{ route('admin.feedbacks.store') }}" method="POST" id="feedbackForm">
            @csrf
            <div class="mb-3">
                <label for="subject_class_id" class="form-label">Chọn Lớp Môn</label>
                <select class="form-select @error('subject_class_id') is-invalid @enderror" id="subject_class_id" name="subject_class_id">
                    <option value="">Chọn lớp môn...</option>
                    @foreach ($subjectClasses as $subjectClass)
                        <option value="{{ $subjectClass->id }}" {{ old('subject_class_id') == $subjectClass->id ? 'selected' : '' }}>
                            {{ $subjectClass->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_class_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="admin_feedback" class="form-label">Nội dung Feedback</label>
                <textarea class="form-control @error('admin_feedback') is-invalid @enderror" id="admin_feedback" name="admin_feedback" rows="4">{{ old('admin_feedback') }}</textarea>
                @error('admin_feedback')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Gửi Feedback</button>
        </form>
    </main>
@endsection
