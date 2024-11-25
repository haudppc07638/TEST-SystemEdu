@extends('layouts.app')

@section('title', 'Làm phản hồi | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">
            Làm phản hồi cho lớp môn
        </h2>

        <form action="{{ route('student.feedback.store', $studentSubjectClassId) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            @foreach ($feedbackQuestions as $question)
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">
                        {{ $question->content }}
                    </label>
                    <select name="results[]" required class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-300">
                        <option value="">-- Chọn mức đánh giá --</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <input type="hidden" name="feedback_question_id[]" value="{{ $question->id }}">
                </div>
            @endforeach

            <div class="flex justify-end mt-6">
                <button type="submit"
                        class="px-6 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring focus:ring-purple-300">
                    Hoàn thành
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
