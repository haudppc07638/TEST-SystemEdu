@extends('layouts.app')

@section('title', 'Làm phản hồi | SysEdu')
@push('style')
<style>
    .form-radio {
        accent-color: #38a169;
        border-radius: 50%;
        width: 20px;
        height: 20px;
    }
    textarea {
        font-size: 1rem;
        line-height: 1.5;
        resize: vertical;
        border-color: #e2e8f0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">

        <h2 class="my-6 text-2xl font-semibold text-gray-700">
            Phản hồi
        </h2>

        <!-- Card container -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <form action="{{ route('feedback.store', $studentSubjectClassId) }}" method="POST">
                @csrf
                @foreach ($feedbackQuestions as $index => $question)
                    <div class="mb-3">
                        <label class="block text-lg font-medium text-gray-700 mb-3">{{ $question->name }}</label>
                        <input type="hidden" name="feedback_question_id[]" value="{{ $question->id }}">

                        <select name="results[]" class="form-select w-full p-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            <option value="">Chọn đánh giá</option>
                            <option value="10">Tốt</option>
                            <option value="8">Khá</option>
                            <option value="6">Trung bình</option>
                            <option value="4">Kém</option>
                        </select>
                    </div>  
                @endforeach     

                <div class="mb-6">
                    <label for="expertise" class="block text-lg font-medium text-gray-700 mb-3">Ý kiến của bạn</label>
                    <textarea name="expertise" id="expertise" cols="30" rows="5" class="w-full p-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Nhập ý kiến của bạn..."></textarea>

                    <!-- Hiển thị lỗi cho trường expertise -->
                    @error('expertise')
                        <p class="text-red-500 text-xs mt-1" style="color: red">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="mt-4 inline-block px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Gửi phản hồi
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
