@extends('layouts.app')

@section('title', 'Phản hồi lớp môn | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">
            Danh sách lớp môn cần phản hồi
        </h2>

        @if ($studentSubjectClasses->isEmpty())
            <div class="flex items-center justify-center p-4 mb-4 text-sm font-semibold text-purple-700 bg-purple-100 rounded-lg">
                Bạn không có lớp môn nào cần phản hồi.
            </div>
        @else
            <!-- Card for the list -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">Tên lớp môn</th>
                                    <th class="px-4 py-3">Giáo viên</th>
                                    <th class="px-4 py-3 text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @foreach ($studentSubjectClasses as $class)
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 text-sm">
                                            {{ $class->subjectClass->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{ $class->subjectClass->employee->full_name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('student.feedback.form', $class->id) }}"
                                               class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                Làm phản hồi
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection
