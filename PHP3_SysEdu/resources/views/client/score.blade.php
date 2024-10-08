@extends('layouts.app')

@section('title', 'Bảng điểm | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">Bảng Điểm</h2>

        <h4 class="mb-4 text-sm font-semibold">Chuyên ngành: {{ $major->name }}</h4>
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left uppercase border-b">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Học kỳ</th>
                            <th class="px-4 py-3">Môn</th>
                            <th class="px-4 py-3">Mã môn</th>
                            <th class="px-4 py-3">Điểm giữa kỳ</th>
                            <th class="px-4 py-3">Điểm cuối kỳ</th>
                            <th class="px-4 py-3">Điểm trung bình</th>
                            <th class="px-4 py-3">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700">
                        @foreach($scores as $index => $score)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm">{{ $score->subjectClass->semester->block }}</td>
                            <td class="px-4 py-3 text-sm">{{ $score->subjectClass->subject->name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $score->subjectClass->subject->code }}</td>
                            <td class="px-4 py-3 text-sm">{{ $score->midterm_score }}</td>
                            <td class="px-4 py-3 text-sm">{{ $score->final_score }}</td>
                            <td class="px-4 py-3 text-sm">{{ $score->total_score }}</td> <!-- Lấy từ database -->
                            <td class="px-4 py-3 text-sm">
                                @if($score->status == 0)
                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Pass</span>
                                @else
                                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Fail</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9">
                <span class="flex items-center col-span-3">
                    Hiển thị {{ $scores->firstItem() }}-{{ $scores->lastItem() }} trên {{ $scores->total() }}
                </span>
                <span class="col-span-2"></span>
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    {{ $scores->links() }} <!-- Hiển thị phân trang -->
                </span>
            </div>
        </div>
    </div>
</main>
@endsection
