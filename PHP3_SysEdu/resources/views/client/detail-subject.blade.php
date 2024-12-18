@extends('layouts.app')

@section('title', 'Đăng ký lớp học phần | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">
            Đăng ký lớp học phần
        </h2>

        <div class="w-full mb-8 bg-white rounded-lg shadow-lg p-6">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-100 border-b">
                            <th class="px-4 py-3">Môn</th>
                            <th class="px-4 py-3">Lớp Môn</th>
                            <th class="px-4 py-3">Giảng viên</th>
                            <th class="px-4 py-3">Ngày học</th>
                            <th class="px-4 py-3">Học kỳ</th>
                            <th class="px-4 py-3">Mã môn</th>
                            <th class="px-4 py-3">Hạn chót đăng ký</th>
                            <th class="px-4 py-3">Số lượng đã đăng ký</th>
                            <th class="px-4 py-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($subjectClasses as $subjectClass)
                            @if(\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($subjectClass->registration_deadline)))
                                <tr class="text-sm text-gray-700">
                                    <td class="px-4 py-3">{{ $subjectClass->subject->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $subjectClass->name }}</td>
                                    <td class="px-4 py-3">{{ $subjectClass->employee->full_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $subjectClass->start_date }}</td>
                                    <td class="px-4 py-3">{{ $subjectClass->semester->block ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $subjectClass->subject->code ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $subjectClass->registration_deadline }}</td>
                                    <td class="px-4 py-3">{{ $subjectClass->studentsCountText() }}</td>
                                    <td class="px-4 py-3">
                                        @if($registeredClass)
                                            @if($registeredClass->subjectClass->subject_id == $subjectClass->subject_id && $registeredClass->subjectClass->semester_id == $subjectClass->semester_id)  
                                                <form action="{{ route('cancelClass', $subjectClass->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                                        Hủy đăng ký
                                                    </button>
                                                </form>
                                            @else
                                                <button class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg cursor-not-allowed" disabled>
                                                    Đã đăng ký lớp khác
                                                </button>
                                            @endif
                                        @else
                                            @if(!$subjectClass->semester->isCurrentSemester()) 
                                                <form action="{{ route('joinClass', $subjectClass->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                                                        Đăng ký (Cải thiện điểm)
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('joinClass', $subjectClass->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition-colors">
                                                    Đăng ký
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
