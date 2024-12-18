@extends('layouts.app')

@section('title', 'Đăng ký môn học | SysEdu')

@section('main')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700">
                Các môn học đang mở đăng ký
            </h2>

            <div class="w-full mb-8 bg-white rounded-lg shadow-lg p-6">
                <div class="w-full overflow-x-auto">
                    <table class="min-w-full bg-white shadow-md rounded-lg">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-100 border-b">
                                <th class="px-4 py-3 text-center">Tên Môn</th>
                                <th class="px-4 py-3 text-center">Mô Tả</th>
                                <th class="px-4 py-3 text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($subjects as $subject)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 text-sm font-medium border-b text-center">{{ $subject->name }}</td>
                                    <td class="px-4 py-3 text-sm border-b">
                                        <span class="block truncate" style="max-width: 500px;">
                                            {{ $subject->description }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm border-b text-center">
                                        <a href="{{ route('client.subject.classes.show', $subject->id) }}">
                                            <button
                                                class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                Xem
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-gray-700">
                                    <td colspan="3" class="px-4 py-3 text-sm font-medium text-center">
                                        Hiện tại chưa có môn học để đăng ký
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </main>
@endsection
