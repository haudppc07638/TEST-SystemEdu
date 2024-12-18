@extends('layouts.app')

@section('title', 'Chi tiết thông báo')

@section('main')
<main id="main" class="main">
    <div class="container mx-auto px-6 py-4">
        <!-- Card thông báo -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="border-b pb-4 mb-4">
                <!-- Tiêu đề thông báo -->
                <h1 class="text-2xl font-semibold text-gray-800">{{ $notification->title }}</h1>
                <small class="text-sm text-gray-500">
                    Gửi bởi: <span class="text-gray-700 font-medium">{{ $notification->employee->full_name }}</span> 
                    - {{ $notification->date_sent->format('H:i d/m/Y') }}
                </small>
            </div>

            <!-- Nội dung thông báo -->
            <div class="prose max-w-none text-gray-700">
                {!! $notification->content !!}
            </div>
        </div>

        <!-- Nút quay lại -->
        <div class="mt-4">
            <a href="{{ route('home') }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</main>
@endsection
