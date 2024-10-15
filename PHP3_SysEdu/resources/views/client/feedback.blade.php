@extends('layouts.app')

@section('title', 'Phản hồi từ giáo viên | SysEdu')

@section('main')

    <main class="h-full pb-16 overflow-y-auto">

        <h2 class="text-2xl font-bold mb-4">Feedback của học sinh</h2>

        <!-- Hiển thị danh sách phản hồi từ giáo viên mà học sinh chưa phản hồi -->
        @foreach ($feedbacks as $feedback)
            <!-- Chỉ hiển thị các feedback chưa có phản hồi của học sinh -->
            @if (!$feedback->student_feedback)
                <div class="feedback-item mb-6 p-4 border border-gray-300 rounded-lg">
                    <!-- Phản hồi của giáo viên -->
                    <p class="admin-feedback text-lg">{{ $feedback->admin_feedback }}</p>

                    <!-- Form phản hồi của học sinh -->
                    <form action="{{ route('submitStudentFeedback', $feedback->id) }}" method="POST" class="mt-4">
                        @csrf

                        <!-- Thêm trường ẩn cho subject_class_id -->
                        <input type="hidden" name="subject_class_id" value="{{ $feedback->subject_class_id }}">

                        <!-- Mục chọn mức độ đánh giá -->
                        <div class="mb-4">
                            <label for="rating-{{ $feedback->id }}" class="block font-medium text-gray-700">Mức độ đánh giá:</label>
                            <select name="rating" id="rating-{{ $feedback->id }}" class="w-full border border-gray-300 rounded-lg p-2">
                                <option value="">Chọn mức độ</option>
                                <option value="Xuất sắc">Xuất sắc</option>
                                <option value="Tốt">Tốt</option>
                                <option value="Khá">Khá</option>
                                <option value="Trung bình">Trung bình</option>
                                <option value="Yếu">Yếu</option>
                            </select>
                            <!-- Hiển thị lỗi cho trường rating -->
                            @error('rating')
                                <div class="text-red-500 text-sm mt-2" style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phản hồi của học sinh -->
                        <div class="mb-4">
                            <label for="student_feedback-{{ $feedback->id }}" class="block font-medium text-gray-700">Phản hồi của bạn:</label>
                            <textarea name="student_feedback" id="student_feedback-{{ $feedback->id }}" rows="4" class="w-full border border-gray-300 rounded-lg p-2">{{ old('student_feedback') }}</textarea>
                            <!-- Hiển thị lỗi cho trường student_feedback -->
                            @error('student_feedback')
                                <div class="text-red-500 text-sm mt-2" style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Gửi phản hồi
                        </button>
                    </form>
                </div>
            @endif
        @endforeach

    </main>

@endsection
