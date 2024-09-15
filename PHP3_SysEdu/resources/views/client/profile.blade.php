@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân | SysEdu')

@section('main')

<main class="h-full pb-16 overflow-y-auto">
  <div class="container grid px-6 mx-auto">
      <h2 class="my-6 text-2xl font-semibold text-gray-700">
          Hồ sơ cá nhân
      </h2>

      <form class="px-4 md:px-8 w-full mx-auto py-12">
        <div class="space-y-12">
          
          <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900 mb-4">Thông tin cá nhân</h2>
      
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
              <div class="sm:col-span-3">
                <label for="first-name" class="text-sm font-medium leading-6 text-gray-900">Họ và tên</label>
                <div class="mt-2 mb-4">
                  <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="form-input w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  value="{{ $user->fullname }}"
                  readonly>
                </div>
              </div>

              <div class="sm:col-span-3">
                <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Mã sinh viên</label>
                <div class="mt-2 mb-4">
                  <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  value="{{ $user->code }}"
                  readonly>
                </div>
              </div>

              <div class="sm:col-span-3">
                <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                <div class="mt-2 mb-4">
                  <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  value="{{ $user->email }}"
                  readonly>
                </div>
              </div>

              <div class="sm:col-span-3">
                <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Số điện thoại</label>
                <div class="mt-2 mb-4">
                  <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  value="{{ $user->phone }}"
                  readonly>
                </div>
              </div>

              <div class="sm:col-span-3">
                <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Chuyên ngành</label>
                <div class="mt-2 mb-4">
                  <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  value="{{ $user->major->name }}"
                  readonly>
                </div>
              </div>

              <div class="sm:col-span-3">
                <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Ngày nhập học</label>
                <div class="mt-2 mb-4">
                  <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="form-input w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  value="{{ $formatDate }}"
                  readonly>
                </div>
              </div>
          
            </div>
          </div>
      
        </div>
      </form>

  </div>
</main>

@endsection