@extends('layouts.app')

@section('title', 'Lịch thi | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
        <!-- Card for exam schedules -->
        <div class="w-full mb-8 bg-white rounded-lg shadow-lg p-6">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left uppercase border-b">
                            <th class="px-4 py-3">STT</th>
                            <th class="px-4 py-3">Ngày</th>
                            <th class="px-4 py-3">Phòng</th>
                            <th class="px-4 py-3">Mã Môn</th>
                            <th class="px-4 py-3">Môn thi</th>
                            <th class="px-4 py-3">Lớp</th>
                            <th class="px-4 py-3">Giám thị 1</th>
                            <th class="px-4 py-3">Giám thị 2</th>
                            <th class="px-4 py-3">Ca thi</th>
                            <th class="px-4 py-3">Thời gian</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700">
                        @foreach ($examStudents as $index => $examStudent)
                            {{-- {{$examStudent->examSchedule->schedule}} --}}
                            <tr class="text-gray-700">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm">{{ ucfirst(\Carbon\Carbon::parse($examStudent->examSchedule->schedule->date)->translatedFormat('l, d/m/Y')) }}</td>
                                <td class="px-4 py-3 text-xs">{{ $examStudent->examSchedule->schedule->classroom->code ?? 'Chưa có' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $examStudent->examSchedule->schedule->subjectClass->subject->code ?? 'Chưa có' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $examStudent->examSchedule->schedule->subjectClass->subject->name ?? 'Chưa có' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $examStudent->examSchedule->schedule->subjectClass->name ?? 'Chưa có' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $examStudent->examSchedule->teacher1->full_name ?? 'Chưa có' }} - {{ $examStudent->examSchedule->teacher1->code ?? 'Chưa có' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $examStudent->examSchedule->teacher2->full_name ?? 'Chưa có' }} - {{ $examStudent->examSchedule->teacher2->code ?? 'Chưa có' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $examStudent->examSchedule->schedule->timeSlot->slot ?? 'Chưa có' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $examStudent->examSchedule->schedule->timeSlot->start_time ?? 'Chưa có' }} - {{ $examStudent->examSchedule->schedule->timeSlot->end_time ?? 'Chưa có' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9">
                <span class="flex items-center col-span-3">Hiển thị {{ $examStudents->count() }} trên {{ $examStudents->total() }}</span>
                <span class="col-span-2"></span>
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    {{ $examStudents->links('pagination::bootstrap-4') }}
                </span>
            </div>
        </div>
    </div>
</main>
@endsection
