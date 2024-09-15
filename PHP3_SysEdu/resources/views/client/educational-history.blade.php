@extends('layouts.app')

@section('title', 'Lịch sử học | SysEdu')

@section('main')

<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
      <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Bảng Điểm
      </h2>

      <div class="flex justify-between items-center mb-4">
    
          <h4 class="text-sm font-semibold">Danh sách các môn đã học</h4>
        <form action="{{route('educational-history')}}" method="get">
          @csrf
          <div class="flex space-x-4">
            <label class="block text-sm flex-1">
                <span class="text-gray-800">Học Kỳ</span>
                <select name="semester" id="semester" class="block w-full mt-1 text-sm form-select">
                    <option value="">Chọn kỳ học</option>
                    @foreach($showHistorys as $showHistory)
                        <option value="{{ $showHistory->subjectclass->semester->id }}" {{ $showHistory->subjectclass->semester->id == request('semester') ? 'selected' : '' }}>
                            {{ $showHistory->subjectclass->semester->block }}
                        </option>
                    @endforeach
                </select>
            </label>
        
            <label class="block text-sm flex-1">
                <span class="text-gray-800">Năm học</span>
                <select class="block w-full mt-1 text-sm form-select" id="year" name="year">
                    <option value="">Chọn năm học</option>
                    @foreach($years as $year)
                        <option value="{{ $year->id }}" {{ $year->id == request('year') ? 'selected' : '' }}>
                            {{ $year->year }}
                        </option>
                    @endforeach
                </select>
            </label>
        
            <button type="submit" class="btn btn-primary">Lọc</button>
        </div>
        
          </form>
      </div>

      <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left uppercase border-b">
                <th class="px-4 py-3">Id</th>
                <th class="px-4 py-3">Tên môn học</th>
                <th class="px-4 py-3">Mã môn</th>
                <th class="px-4 py-3">Kỳ</th>
                <th class="px-4 py-3">Điểm trung bình</th>
                <th class="px-4 py-3">Xếp Loại</th>
                <th class="px-4 py-3">Trạng thái</th>
              </tr>
            </thead>
            @forelse ($showHistorys as $showHistory)
    <tbody class="bg-white divide-y dark:divide-gray-700">
        <tr class="text-gray-700 ">
            <td class="px-4 py-3">
                {{$showHistory->subjectclass->id}}
            </td>
            <td class="px-4 py-3 text-sm">
                {{$showHistory->subjectclass->subject->name}}
            </td>
            <td class="px-4 py-3 text-xs">
                {{$showHistory->subjectclass->subject->code}}
            </td>
            <td class="px-4 py-3 text-sm">
                {{$showHistory->subjectclass->semester->block}}
            </td>
            <td class="px-4 py-3 text-sm">
                {{$showHistory->total_score}}
            </td>
            <td class="px-4 py-3 text-sm">
              {{$showHistory->classfication}}
          </td>
            <td class="px-4 py-3 text-xs">
                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">
                  {{ ucfirst(strtolower($showHistory->status)) }}
                </span>
            </td>
        </tr>
    </tbody>
@empty
    <tr>
        <td colspan="6">Không có dữ liệu</td>
    </tr>
@endforelse

          </table>
        </div>
        {{-- <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9">
          <span class="flex items-center col-span-3">
            Showing 21-30 of 100
          </span>
          <span class="col-span-2"></span>

          <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            <nav aria-label="Table navigation">
              <ul class="inline-flex items-center">
                <li>
                  <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                    <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                      <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                  </button>
                </li>
                <li>
                  <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1</button>
                </li>
                <li>
                  <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">2</button>
                </li>
                <li>
                  <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">3</button>
                </li>
                <li>
                  <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">4</button>
                </li>
                <li>
                  <span class="px-3 py-1">...</span>
                </li>
                <li>
                  <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">8</button>
                </li>
                <li>
                  <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">9</button>
                </li>
                <li>
                  <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                      <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                  </button>
                </li>
              </ul>
            </nav>
          </span>
        </div> --}}
      </div>

    </div>
  </main>

@endsection
