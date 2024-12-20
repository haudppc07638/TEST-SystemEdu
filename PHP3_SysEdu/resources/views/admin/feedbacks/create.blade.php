@extends('layouts.master')

@section('title', 'Tạo câu hỏi phản hồi')

@section('main')
    <main id="main" class="main">
        <div class="container">
            <div class="pagetitle">
                <h1>Tạo câu hỏi phản hồi</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.feedbacks.index') }}">Phản hồi</a></li>
                        <li class="breadcrumb-item active">Tạo câu hỏi phản hồi</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('admin.feedbacks.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="subject_class_id">Lớp môn</label>
                            <select name="subject_class_id" id="subject_class_id"
                                class="form-control @error('subject_class_id') is-invalid @enderror">
                                <option value="">Chọn lớp môn</option>
                                @foreach ($subjectClasses as $subjectClass)
                                    <option value="{{ $subjectClass->id }}"
                                        {{ old('subject_class_id') == $subjectClass->id ? 'selected' : '' }}>
                                        {{ $subjectClass->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_class_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="question_name">Câu hỏi phản hồi</label>
                            <input type="text" name="question_name[]"
                                class="form-control @error('question_name.*') is-invalid @enderror"
                                placeholder="Nhập câu hỏi" value="{{ old('question_name.0') }}">
                            @error('question_name.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="questions-container"></div>

                        <button type="button" class="btn btn-outline-secondary" id="add-question">Thêm câu hỏi</button>

                        <div class="form-group">
                            <label for="target">Đối tượng nhận phản hồi</label>
                            <select name="target" id="target"
                                class="form-control @error('target') is-invalid @enderror">
                                <option value="student" {{ old('target') == 'student' ? 'selected' : '' }}>Sinh viên
                                </option>
                            </select>
                            @error('target')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-cBlue">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script>
        document.getElementById('add-question').addEventListener('click', function() {
            const container = document.getElementById('questions-container');
            const newQuestion = document.createElement('div');
            newQuestion.classList.add('form-group', 'question-item');
            newQuestion.innerHTML = `
            <input type="text" name="question_name[]" class="form-control" placeholder="Nhập câu hỏi">
            <button type="button" class="btn btn-danger remove-question" style="margin-top: 5px;">Xóa</button>
        `;
            container.appendChild(newQuestion);

            // Xóa câu hỏi
            newQuestion.querySelector('.remove-question').addEventListener('click', function() {
                container.removeChild(newQuestion);
            });
        });
    </script>
@endpush

@push('style')
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            font-weight: bold;
        }

        .alert {
            margin-bottom: 1.5rem;
        }

        .question-item {
            margin-bottom: 1rem;
        }

        .btn-outline-secondary {
            margin-top: 1rem;
        }
    </style>
@endpush
