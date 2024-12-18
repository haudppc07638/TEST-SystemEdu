@extends('layouts.app')

@section('title', 'Thanh toán học phí | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
      Tổng Học Phần
    </h2>

    <!-- Card Wrapper -->
    <div class="bg-white rounded-lg shadow-md p-6 space-y-4">
      <!-- Card Header -->
      <div class="flex justify-between items-center mb-4">
        <h4 class="text-lg font-semibold text-gray-700">Thanh Toán</h4>
      </div>

      <!-- Table -->
      <div class="w-full overflow-hidden rounded-lg">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50">
                <th class="px-4 py-3">Tên môn học</th>
                <th class="px-4 py-3">Mã môn</th>
                <th class="px-4 py-3">Giá</th>
                <th class="px-4 py-3">Tín Chỉ</th>
                <th class="px-4 py-3">Học Kỳ</th>
              </tr>
            </thead>

            <!-- Table Body -->
            @forelse ($tuitionView as $tuiton)
            <tbody class="bg-white divide-y divide-gray-200">
              <tr class="text-gray-700">
                <td class="px-4 py-3 text-sm">
                  {{ $tuiton->studentSubjectClasses->subjectClass->subject->name }}
                </td>
                <td class="px-4 py-3 text-xs">
                  {{ $tuiton->studentSubjectClasses->subjectclass->subject->code }}
                </td>
                <td class="px-4 py-3 text-xs">
                  {{ number_format($tuiton->studentSubjectClasses->subjectclass->price) }} VNĐ
                </td>
                <td class="px-4 py-3 text-xs">
                  {{ $tuiton->studentSubjectClasses->subjectclass->subject->credit }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ $tuiton->studentSubjectClasses->subjectclass->semester->block }}
                </td>
              </tr>
            </tbody>
            @empty
            <tbody>
              <tr>
                <td colspan="5" class="px-4 py-3 text-center text-gray-500">Không có dữ liệu</td>
              </tr>
            </tbody>
            @endforelse
          </table>
        </div>
      </div>

      <!-- Summary Card -->
      @foreach($totalTuitionView as $totalTuition)
      <div class="mt-6 bg-gray-50 p-4 rounded-lg shadow">
        <p class="text-sm font-medium text-gray-700">
          Tổng Tín Chỉ: <span class="font-semibold">{{ ucfirst(strtolower($totalTuition->total_credit)) }}</span>
        </p>
        <p class="text-sm font-medium text-gray-700">
          Tổng Học Phí: <span class="font-semibold">{{ number_format($totalTuition->total_amount) }} VNĐ</span>
        </p>
        <a href="{{ route('vietqr', ['studentId' => $student->id]) }}"
          class="mt-4 inline-flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
          Thanh Toán
        </a>
      </div>
      @endforeach

    </div>
  </div>
</main>
@endsection
