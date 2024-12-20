@extends('layouts.lecturer')

@section('title', 'Trang Chủ | SysEdu')

@section('main')
    <main id="main" class="main">
        <div class="container py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header p-3 mb-2 text-dark fw-bold d-flex align-items-center">
                            <i class="bi bi-bell me-2"></i>
                            <h5 class="mb-0">Thông báo</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Cột bên trái -->
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush">
                                        @forelse($notifications as $notification)
                                            <li class="list-group-item border-0 py-2">
                                                <i class="bi bi-bell text-primary me-2"></i>
                                                <a href="{{ route('notifications.show', $notification->id) }}" 
                                                  <small class="text-muted ms-2">
                                                        ({{ $notification->date_sent->format('d/m/Y H:i') }})
                                                    </small>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="list-group-item border-0 py-2 text-center">
                                                Không có thông báo nào
                                            </li>
                                        @endforelse
                                    </ul>
                                    
                                    @if($notifications->count() > 10)
                                        <div class="text-center mt-4">
                                            <a href="{{ route('notifications.index') }}" class="btn btn-primary">
                                                Xem thêm...
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
              class="text-primary text-decoration-none">
                                                    {{ $notification->title }}
                                       