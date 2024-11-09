@extends('layouts.lecturer')

@section('title', 'Chi tiết thông báo')

@section('main')
<main id="main" class="main">
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="card-title">{{ $notification->title }}</h5>
                <small class="text-muted">
                    Gửi bởi: {{ $notification->employee->fullname }} - 
                    {{ $notification->date_sent->format('H:i d/m/Y') }}
                </small>
            </div>
            <div class="card-body">
                {!! $notification->content !!}
            </div>
        </div>
    </div>
</main>
@endsection