@extends('layouts.app')

@section('title', 'Lịch sử học | SysEdu')

@section('main')

    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700">
                Lịch sử học tập
            </h2>

            <!-- Thẻ card hiển thị thông tin trung bình điểm và tín chỉ -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <div class="flex items-center">
                        <h5 class="font-semibold text-gray-700">Tổng tín chỉ đã học:</h5>
                        <p class="text-gray-800 pl-2">
                            {{ $totalCredits ?? '0' }} / {{ $totalCreditsMajor }} tín chỉ
                        </p>
                    </div>

                    <div class="flex items-center mt-4">
                        <h5 class="font-semibold text-gray-700">Điểm trung bình:</h5>
                        <p class="text-xl font-bold text-gray-800 pl-2">
                            {{ number_format($averageScore ?? 0, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 mb-6">
              <h4 class="text-sm font-semibold mb-4">Lọc thông tin</h4>
              <form action="{{ route('educational-history') }}" method="get">
                  @csrf
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <label class="block text-sm">
                          <span class="text-gray-800">Học Kỳ</span>
                          <select name="semester" id="semester" class="block w-full mt-1 text-sm form-select">
                              <option value="">Chọn kỳ học</option>
                              @foreach ($showHistorys as $showHistory)
                                  @if ($showHistory->subjectclass && $showHistory->subjectclass->semester)
                                      <option value="{{ $showHistory->subjectclass->semester->id }}"
                                          {{ $showHistory->subjectclass->semester->id == request('semester') ? 'selected' : '' }}>
                                          {{ $showHistory->subjectclass->semester->block }}
                                      </option>
                                  @endif
                              @endforeach
                          </select>
                      </label>
          
                      <label class="block text-sm">
                          <span class="text-gray-800">Năm học</span>
                          <select class="block w-full mt-1 text-sm form-select" id="year" name="year">
                              <option value="">Chọn năm học</option>
                              @foreach ($years as $year)
                                  <option value="{{ $year->id }}"
                                      {{ $year->id == request('year') ? 'selected' : '' }}>
                                      {{ $year->year }}
                                  </option>
                              @endforeach
                          </select>
                      </label>
                  </div>
          
                  <div class="flex items-center justify-start mt-4">
                      <button type="submit"
                          class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none transition duration-300">
                          Lọc
                      </button>
                  </div>
              </form>
          </div>

            <!-- Card cho bảng danh sách các môn học -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h4 class="text-lg font-semibold mb-4">Danh sách các môn đã học</h4>
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap table-auto">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left uppercase border-b">
                                <th class="px-4 py-3">STT</th>
                                <th class="px-4 py-3">Tên môn học</th>
                                <th class="px-4 py-3">Mã môn</th>
                                <th class="px-4 py-3">Tín chỉ</th>
                                <th class="px-4 py-3">Kỳ</th>
                                <th class="px-4 py-3">Điểm trung bình</th>
                                <th class="px-4 py-3">Xếp Loại</th>
                                <th class="px-4 py-3">Trạng thái</th>
                            </tr>
                        </thead>
                        @foreach ($showHistorys as $index => $showHistory)
                            <tbody class="bg-white divide-y dark:divide-gray-700">
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $showHistory->studentSubjectClass->subjectClass->subject->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        {{ $showHistory->studentSubjectClass->subjectClass->subject->code ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        {{ $showHistory->studentSubjectClass->subjectClass->subject->credit ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $showHistory->studentSubjectClass->subjectClass->semester->block ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $showHistory->studentSubjectClass->total_score ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $showHistory->classfication ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">
                                            {{ ucfirst(strtolower($showHistory->studentSubjectClass->status ?? 'N/A')) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </main>

@endsection
