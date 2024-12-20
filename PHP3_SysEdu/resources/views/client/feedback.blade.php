@extends('layouts.app')

@section('title', 'Phản hồi từ giáo viên | SysEdu')

@section('main')

<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">

        <h2 class="my-6 text-2xl font-semibold text-gray-700">
            Danh sách phản hồi
        </h2>

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left uppercase border-b">
                            <th class="px-4 py-3">Lớp môn</th>
                            <th class="px-4 py-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700">
                        @foreach ($feedbackResults as $studentSubjectClassId => $feedbackGroup)
                            <tr class="text-gray-700">
                                <td class="align-middle">
                                    {{ $feedbackGroup->first()->studentSubjectClass->subjectClass->subject->name }} - 
                                    {{ $feedbackGroup->first()->studentSubjectClass->subjectClass->name }}
                                </td>
                                <td>
                                    <a href="{{ route('feedback.form', $studentSubjectClassId) }}" class="btn btn-primary btn-sm">Phản hồi</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

@endsection
