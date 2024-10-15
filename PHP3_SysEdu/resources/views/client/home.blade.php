@extends('layouts.app')

@section('title', 'Trang Chủ | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
  Tổng Học Phần 
    </h2>

    <div class="flex justify-between items-center mb-4">
  
        <h4 class="text-sm font-semibold">Thanh Toán</h4>
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
            {{$tuiton->studentSubjectClasses->subjectclass->subject->price}}
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
        <button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Thanh Toán</button>
  </td>

@endforeach
@endsection
