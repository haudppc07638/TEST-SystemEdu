@extends('layouts.app')

@section('title', 'Bảng điểm | SysEdu')

@section('main')

<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
      <h2
        class="my-6 text-2xl font-semibold text-gray-700"
      >
        Bảng Điểm
      </h2>

      <!-- With avatar -->
      <h4
        class="mb-4 text-sm font-semibold"
      >
        Chuyên ngành: 
      </h4>
      <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left uppercase border-b"
              >
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Học kỳ</th>
                <th class="px-4 py-3">Môn</th>
                <th class="px-4 py-3">Điểm giữa kỳ</th>
                <th class="px-4 py-3">Điểm cuối kỳ</th>
                <th class="px-4 py-3">Điểm trung bình</th>
                <th class="px-4 py-3">Trạng thái</th>
              </tr>
            </thead>
            <tbody
              class="bg-white divide-y dark:divide-gray-700"
            >
              <tr class="text-gray-700 ">
                <td class="px-4 py-3">
                  1
                </td>
                <td class="px-4 py-3 text-sm">
                  1
                </td>
                <td class="px-4 py-3 text-xs">
                 Java
                </td>
                <td class="px-4 py-3 text-sm">
                  8
                </td>
                <td class="px-4 py-3 text-sm">
                  9
                </td>
                <td class="px-4 py-3 text-sm">
                  8.8
                </td>
                <td class="px-4 py-3 text-xs">
                  <span
                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700"
                  >
                    Denied
                  </span>
                </td>
              </tr>

              <tr class="text-gray-700 ">
                <td class="px-4 py-3">
                  1
                </td>
                <td class="px-4 py-3 text-sm">
                  1
                </td>
                <td class="px-4 py-3 text-xs">
                 Java
                </td>
                <td class="px-4 py-3 text-sm">
                  8
                </td>
                <td class="px-4 py-3 text-sm">
                  9
                </td>
                <td class="px-4 py-3 text-sm">
                  8.8
                </td>
                <td class="px-4 py-3 text-xs">
                  <span
                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                  >
                    Approved
                  </span>
                </td>
              </tr>

              <tr class="text-gray-700 ">
                <td class="px-4 py-3">
                  1
                </td>
                <td class="px-4 py-3 text-sm">
                  1
                </td>
                <td class="px-4 py-3 text-xs">
                 Java
                </td>
                <td class="px-4 py-3 text-sm">
                  8
                </td>
                <td class="px-4 py-3 text-sm">
                  9
                </td>
                <td class="px-4 py-3 text-sm">
                  8.8
                </td>
                <td class="px-4 py-3 text-xs">
                  <span
                    class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-700"
                  >
                    Expired
                  </span>
                </td>
              </tr>

              <tr class="text-gray-700 ">
                <td class="px-4 py-3">
                  1
                </td>
                <td class="px-4 py-3 text-sm">
                  1
                </td>
                <td class="px-4 py-3 text-xs">
                 Java
                </td>
                <td class="px-4 py-3 text-sm">
                  8
                </td>
                <td class="px-4 py-3 text-sm">
                  9
                </td>
                <td class="px-4 py-3 text-sm">
                  8.8
                </td>
                <td class="px-4 py-3 text-xs">
                  <span
                    class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-500 dark:bg-sky-600"
                  >
                    Expired
                  </span>
                </td>
              </tr>
              

            </tbody>
          </table>
        </div>
        <div
          class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9"
        >
          <span class="flex items-center col-span-3">
            Showing 21-30 of 100
          </span>
          <span class="col-span-2"></span>
          <!-- Pagination -->
          <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            <nav aria-label="Table navigation">
              <ul class="inline-flex items-center">
                <li>
                  <button
                    class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                    aria-label="Previous"
                  >
                    <svg
                      aria-hidden="true"
                      class="w-4 h-4 fill-current"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                      ></path>
                    </svg>
                  </button>
                </li>
                <li>
                  <button
                    class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                  >
                    1
                  </button>
                </li>
                <li>
                  <button
                    class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                  >
                    2
                  </button>
                </li>
                <li>
                  <button
                    class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple"
                  >
                    3
                  </button>
                </li>
                <li>
                  <button
                    class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                  >
                    4
                  </button>
                </li>
                <li>
                  <span class="px-3 py-1">...</span>
                </li>
                <li>
                  <button
                    class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                  >
                    8
                  </button>
                </li>
                <li>
                  <button
                    class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                  >
                    9
                  </button>
                </li>
                <li>
                  <button
                    class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                    aria-label="Next"
                  >
                    <svg
                      class="w-4 h-4 fill-current"
                      aria-hidden="true"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                      ></path>
                    </svg>
                  </button>
                </li>
              </ul>
            </nav>
          </span>
        </div>
      </div>

    </div>
  </main>

@endsection
