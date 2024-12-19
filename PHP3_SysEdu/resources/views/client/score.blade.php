@extends('layouts.app')

@section('title', 'Bảng điểm | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">Bảng Điểm</h2>

        <h4 class="mb-4 text-sm font-semibold">Chuyên ngành: {{ $major->name }}</h4>
        
        @foreach($studentSubjectClasses->groupBy('subjectClass.subject_id') as $subjectId => $subjectClasses)
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Môn: {{ $subjectClasses->first()->subjectClass->subject->name }}
            </h3>
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left uppercase border-b">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Học kỳ</th>
                            <th class="px-4 py-3">Môn</th>
                            <th class="px-4 py-3">Mã môn</th>
                            @foreach($subjectScoreTypes->where('subject_id', $subjectId) as $subjectScoreType)
                                <th class="px-4 py-3">{{ $subjectScoreType->name ?? 'Không có tên' }}</th>
                            @endforeach
                            <th class="px-4 py-3">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700">
                        @foreach($subjectClasses as $index => $studentSubjectClass)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3">{{ $studentSubjectClasses->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm">{{ $studentSubjectClass->subjectClass->semester->block }}</td>
                            <td class="px-4 py-3 text-sm">{{ $studentSubjectClass->subjectClass->subject->name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $studentSubjectClass->subjectClass->subject->code }}</td>

                            @foreach($subjectScoreTypes->where('subject_id', $subjectId) as $subjectScoreType)
                                <td class="px-4 py-3">
                                    {{ optional($studentSubjectClass->scores->where('subjectScoreType_id', $subjectScoreType->id)->first())->score ?? 'Chưa có điểm' }}
                                </td>
                            @endforeach

                            <td class="px-4 py-3 text-sm">
                                @if($studentSubjectClass->total_score >= 5)
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

            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9">
                <span class="flex items-center col-span-3">
                    Hiển thị {{ $studentSubjectClasses->firstItem() }}-{{ $studentSubjectClasses->lastItem() }} trên {{ $studentSubjectClasses->total() }}
                </span>
                <span class="col-span-2"></span>
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    {{ $studentSubjectClasses->links() }}
                </span>
            </div>            
        </div>
        @endforeach
    </div>
</main>
@endsection
