@extends('layouts.app')

@section('title', 'Thanh Toán Học Phí | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <!-- Header Section -->
        <div class="my-6 text-center">
            <h1 class="text-3xl font-bold text-gray-700">Thanh Toán Học Phí</h1>
            <p class="mt-2 text-gray-500">Quét mã QR bên dưới để hoàn tất thanh toán học phí nhanh chóng và tiện lợi.</p>
        </div>

        <!-- QR Code Section -->
        <div class="flex justify-center items-center mt-8">
            @if(isset($qrCodeUrl))
                <div class="border border-gray-300 rounded-lg shadow-lg p-6 bg-white">
                    <img src="{{ $qrCodeUrl }}" alt="Mã QR" class="w-80 h-80 mx-auto">
                    <p class="mt-4 text-center text-gray-700 font-medium">
                        Hãy sử dụng ứng dụng ngân hàng để quét mã QR này.
                    </p>
                </div>
            @else
                <div class="text-center bg-gray-50 p-6 rounded-lg shadow-lg">
                    <p class="text-gray-500">Không có mã QR để hiển thị. Vui lòng thử lại sau hoặc liên hệ hỗ trợ.</p>
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('tuition') }}"
                class="inline-block px-6 py-2 text-sm font-medium leading-5 text-white bg-purple-600 rounded-lg shadow hover:bg-purple-600 focus:outline-none focus:shadow-outline">
                Quay lại
            </a>
        </div>
    </div>
</main>
@endsection
