@extends('layouts.app')

@section('title', 'Lịch sử thanh toán học phí | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">Lịch Sử Thanh Toán Học Phí</h2>

        {{-- <form method="GET" action="{{ route('history.payment') }}" class="mb-4">
            <label for="payment_status" class="text-sm font-medium text-gray-700">Lọc theo trạng thái:</label>
            <select name="payment_status" id="payment_status" class="ml-2 rounded">
                <option value="">Tất cả</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
            </select>
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lọc</button>
        </form> --}}

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Tên Sinh Viên</th>
                            <th class="px-4 py-3">Tổng Tín Chỉ</th>
                            <th class="px-4 py-3">Tổng Học Phí</th>
                            <th class="px-4 py-3">Kỳ Học</th>
                            <th class="px-4 py-3">Năm Học</th>
                            <th class="px-4 py-3">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($students as $index => $student)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-sm">{{ $students->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm">{{ $student->full_name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $student->totalTuition->total_credit ?? 'Chưa có' }}</td>
                            <td class="px-4 py-3 text-sm">{{ number_format($student->totalTuition->total_amount ?? 0) }} VNĐ</td>
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $semesterBlocks = $student->studentSubjectClasses->pluck('subjectClass.semester.block')->unique();
                                @endphp
                                @forelse ($semesterBlocks as $block)
                                    <span class="block">{{ $block }}</span>
                                @empty
                                    <span>Chưa có</span>
                                @endforelse
                            </td>     
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $years = $student->studentSubjectClasses->pluck('subjectClass.semester.year')->unique();
                                @endphp
                                @forelse ($years as $year)
                                    <span class="block">{{ $year }}</span>
                                @empty
                                    <span>Chưa có</span>
                                @endforelse
                            </td>                       
                            <td class="px-4 py-3 text-sm">
                                @if ($student->totalTuition)
                                    @if ($student->totalTuition->payment_status === 'paid')
                                        <span class="px-2 py-1 font-semibold text-green-700 bg-green-100 rounded-full">Đã thanh toán</span>
                                    @else
                                        <span class="px-2 py-1 font-semibold text-red-700 bg-red-100 rounded-full">Chưa thanh toán</span>
                                    @endif
                                @else
                                    <span class="px-2 py-1 font-semibold text-gray-700 bg-gray-100 rounded-full">Chưa có dữ liệu</span>
                                @endif
                            </td>                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Không có dữ liệu</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 border-t">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</main>
@endsection
