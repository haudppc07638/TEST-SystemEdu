@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân | SysEdu')

@section('main')

<main class="h-full pb-16 overflow-y-auto">
  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">Hồ sơ cá nhân</h2>

    <form class="px-4 md:px-8 w-full mx-auto py-12">
      <div class="space-y-12">
        
        <div class="border-b border-gray-900/10 pb-12">
          <h2 class="text-base font-semibold leading-7 text-gray-900 mb-4">Thông tin cá nhân</h2>
        
          <!-- Table to display student information -->
          <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Thông tin</th>
                  <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Chi tiết</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Họ và tên</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->full_name }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Mã sinh viên</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->code }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Email</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Số điện thoại</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Ngày nhập học</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $formatDate }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Chuyên ngành</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->major->name }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Quốc tịch</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->nation }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">CMND/CCCD</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->identity_card }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Ngày cấp CMND/CCCD</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->card_issuance_date }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Nơi cấp CMND/CCCD</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->card_location }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Địa chỉ</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $user->house_number }}, {{ $user->commune_level }}, {{ $user->district }}, {{ $user->provice_city }}
                  </td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Người bảo hộ</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->sponsor_name }}</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">Số điện thoại người bảo hộ</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->sponsor_phone }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- End table -->
        </div>
      
      </div>
    </form>
  </div>
</main>

@endsection
