@extends('layouts.app')

@section('title', 'Trang Chủ | SysEdu')

@section('main')
<main id="main" class="main">
    <div class="container mx-auto px-6 py-4">
        <!-- Tiêu đề thông báo -->
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center mb-4">
                <i class="bi bi-bell text-blue-500 text-xl mr-2"></i>
                <h2 class="text-lg font-semibold text-gray-700">Thông báo</h2>
            </div>

            <!-- Nội dung thông báo -->
            <div class="divide-y divide-gray-200">
                @forelse($notifications as $notification)
                    <div class="py-4">
                        <a href="{{ route('notifications.detail', $notification->id) }}" class="flex items-center text-blue-500 hover:underline">
                            <i class="bi bi-bell-fill mr-2 text-blue-500"></i>
                            <span class="font-medium">{{ $notification->title }}</span>
                            <small class="text-gray-500 ml-2">
                                ({{ $notification->date_sent->format('d/m/Y H:i') }})
                            </small>
                        </a>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-500">
                        Không có thông báo nào
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-4">
                    {{ $notifications->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr class="text-xs font-semibold tracking-wide text-left uppercase border-b">
              <th class="px-4 py-3">Tên môn học</th>
              <th class="px-4 py-3">Mã môn</th>
              <th class="px-4 py-3">Giá</th>
              <th class="px-4 py-3">Tín Chỉ</th>
              <th class="px-4 py-3">Học Kỳ</th>
            </tr>
          </thead>
          @forelse ($tuitionView as $tuiton)
  <tbody class="bg-white divide-y dark:divide-gray-700">
      <tr class="text-gray-700 ">
          <td class="px-4 py-3 text-sm">
              {{$tuiton->studentSubjectClasses->subjectClass->subject->name}}
          </td>
          <td class="px-4 py-3 text-xs">
              {{$tuiton->studentSubjectClasses->subjectclass->subject->code}}
          </td>
          <td class="px-4 py-3 text-xs">
            {{$tuiton->studentSubjectClasses->subjectclass->price}}
        </td>
        <td class="px-4 py-3 text-xs">
          {{$tuiton->studentSubjectClasses->subjectclass->subject->credit}}
      </td>
          <td class="px-4 py-3 text-sm">
              {{$tuiton->studentSubjectClasses->subjectclass->semester->block}}
          </td>
      </tr>
  </tbody>
@empty
  <tr>
      <td colspan="6">Không có dữ liệu</td>
  </tr>
@endforelse
@foreach($totalTuitionView as $totalTuition)
    <td class="px-4 py-3">
        Tổng Tín Chỉ: {{ ucfirst(strtolower($totalTuition->total_credit)) }} <br>
        Tổng Học Phí: {{ ucfirst(strtolower($totalTuition->total_amount)) }} <br>
        {{-- @if($totalTuition->payment_status === 'paid')
            <span class="px-4 py-2 text-sm font-medium text-green-600">Đã thanh toán</span>
        @else --}}
            <a href="{{ route('vietqr', ['studentId' => $student->id]) }}"
                class="mt-4 inline-block px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Thanh Toán
            </a>
        {{-- @endif --}}
    </td>
@endforeach

@endsection
