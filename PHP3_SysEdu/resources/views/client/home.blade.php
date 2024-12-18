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
</main>
@endsection
