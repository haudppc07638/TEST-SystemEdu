@extends('layouts.app')

@section('title', 'Lịch học | SysEdu')

@section('main')

    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">

            <h2 class="my-6 text-2xl font-semibold text-gray-700">
                Lịch học
            </h2>

            <!-- Thay đổi thời gian hiển thị nếu cần -->
            <form method="GET" action="{{ route('schedules') }}">
                <label class="block mt-4 mb-5 text-sm">
                    <span class="text-gray-700">Thời gian</span>
                    <select name="time_range" class="block w-full mt-3 text-sm form-select focus:border-purple-400 focus:shadow-outline-purple" onchange="this.form.submit()">
                        <option value="7 days ahead" {{ request('time_range') == '7 days ahead' ? 'selected' : '' }}>7 ngày tới</option>
                        <option value="14 days ahead" {{ request('time_range') == '14 days ahead' ? 'selected' : '' }}>14 ngày tới</option>
                        <option value="30 days ahead" {{ request('time_range') == '30 days ahead' ? 'selected' : '' }}>30 ngày tới</option>
                        <option value="60 days ahead" {{ request('time_range') == '60 days ahead' ? 'selected' : '' }}>60 ngày tới</option>
                        <option value="90 days ahead" {{ request('time_range') == '90 days ahead' ? 'selected' : '' }}>90 ngày tới</option>
                        <option value="7 days before" {{ request('time_range') == '7 days before' ? 'selected' : '' }}>7 ngày trước</option>
                        <option value="14 days before" {{ request('time_range') == '14 days before' ? 'selected' : '' }}>14 ngày trước</option>
                        <option value="30 days before" {{ request('time_range') == '30 days before' ? 'selected' : '' }}>30 ngày trước</option>
                        <option value="60 days before" {{ request('time_range') == '60 days before' ? 'selected' : '' }}>60 ngày trước</option>
                        <option value="90 days before" {{ request('time_range') == '90 days before' ? 'selected' : '' }}>90 ngày trước</option>
                    </select>
                </label>
            </form>            
            {{-- <div class="flex justify-end mb-4">
                <a href="{{ route('schedules.export-pdf', ['time_range' => request('time_range')]) }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">PDF</a>
            </div> --}}
                       
            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left uppercase border-b">
                                <th class="px-4 py-3">Stt</th>
                                <th class="px-4 py-3">Ngày</th>
                                <th class="px-4 py-3">Phòng</th>
                                <th class="px-4 py-3">Môn học</th>
                                <th class="px-4 py-3">Lớp</th>
                                <th class="px-4 py-3">Giảng viên</th>
                                <th class="px-4 py-3">Ca</th>
                                <th class="px-4 py-3">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700">
                            @foreach ($schedules as $index => $schedule)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($schedule->schedule_day)->translatedFormat('l, d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-xs">{{ $schedule->classroom->code ?? 'Chưa có' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $schedule->subjectClass->subject->name ?? 'Chưa có' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $schedule->subjectClass->name ?? 'Chưa có' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $schedule->subjectClass->employee->fullname ?? 'Chưa có' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $schedule->timeSlot->slot ?? 'Chưa có' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $schedule->timeSlot->start_time ?? 'Chưa có' }} - {{ $schedule->timeSlot->end_time ?? 'Chưa có' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9">
                    <span class="flex items-center col-span-3">Showing {{ $schedules->count() }} of {{ $schedules->total() }}</span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                        {{ $schedules->links() }}
                    </span>
                </div>
            </div>

        </div>
    </main>

@endsection
