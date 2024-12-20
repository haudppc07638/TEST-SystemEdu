@extends('layouts.app')

@section('title', 'Đăng ký lớp học | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">
            Đăng ký lớp môn
        </h2>

        <!-- Bảng thông tin các lớp môn -->
        <div class="overflow-x-auto bg-white shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Môn</th>
                        <th scope="col" class="px-6 py-3">Lớp Môn</th>
                        <th scope="col" class="px-6 py-3">Giảng viên</th>
                        <th scope="col" class="px-6 py-3">Ngày học</th>
                        <th scope="col" class="px-6 py-3">Học kỳ</th>
                        <th scope="col" class="px-6 py-3">Mã môn</th>
                        <th scope="col" class="px-6 py-3">Hạn chót đăng ký</th>
                        <th scope="col" class="px-6 py-3">Số lượng đã đăng ký</th>
                        <th scope="col" class="px-6 py-3">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subjectClasses as $subjectClass)
                        @if(\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($subjectClass->registration_deadline)))
                            <tr class="bg-gray-50 border-b">
                                <td class="px-6 py-4">{{ $subjectClass->subject->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $subjectClass->name }}</td>
                                <td class="px-6 py-4">{{ $subjectClass->employee->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $subjectClass->start_date }}</td>
                                <td class="px-6 py-4">{{ $subjectClass->semester->block ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $subjectClass->subject->code ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $subjectClass->registration_deadline }}</td>
                                <td class="px-6 py-4">{{ $subjectClass->studentsCountText() }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $isRegistered = $registeredClasses->contains(function ($registeredClass) use ($subjectClass) {
                                            return $registeredClass->subjectClass->id === $subjectClass->id;
                                        });
                                        $isRegisteredSameSubject = $registeredClasses->contains(function ($registeredClass) use ($subjectClass) {
                                    return $registeredClass->subjectClass->subject_id === $subjectClass->subject_id &&
                                        $registeredClass->subjectClass->semester_id === $subjectClass->semester_id &&
                                        $registeredClass->subjectClass->id !== $subjectClass->id;
                                        });
                                    @endphp

                                    @if ($isRegistered)
                                    @if (\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($subjectClass->registration_deadline)))
                                        <form action="{{ route('cancelClass', $subjectClass->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                                                Hủy đăng ký lớp
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-sm text-gray-500">Bạn đã đăng ký lớp này.</p>
                                    @endif
                                    @elseif ($isRegisteredSameSubject)
                                    <p class="text-sm font-medium text-yellow-600">Đã đăng ký lớp khác</p>
                                    @else
                                    <form action="{{ route('joinClass', $subjectClass->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                                            Đăng ký
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có lớp môn nào để đăng ký</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
