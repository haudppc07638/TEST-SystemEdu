@extends('layouts.master')

@section('title', 'Notification Detail')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Chi tiết thông báo</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.notifications.index')}}">Gửi thông báo</a></li>
                <li class="breadcrumb-item active">Chi tiết</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body p-4 row">
                <div class="col-md-12 form-group">
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" value="{{$notification->title}}" disabled>
                </div>
                <div class="col-md-12 form-group mt-4">
                    <label class="form-label">Nội dung</label>
                    <textarea class="form-control" style="height: 200px" disabled>{{$notification->content}}</textarea>
                </div>
                <div class="col-md-6 form-group mt-4">
                    <label class="form-label">Loại thông báo</label>
                    <input type="text" class="form-control" value="Gửi qua: {{$notification->type}}" disabled>
                </div>
                <div class="col-md-6 form-group mt-4">
                    <label class="form-label">Thời gian gửi</label>
                    <input type="text" class="form-control" value="{{$notification->formatted_date_sent}}" disabled>
                </div>
                <div class="col-md-12 form-group mt-4">
                    <label class="form-label">Người gửi</label>
                    <input type="text" class="form-control" value="{{$notification->employee->fullname}}" disabled>
                </div>
                <div class="col-md-12 form-group mt-4">
                    <label class="form-label">Gửi đến</label>
                    <select class="form-select" multiple aria-label="multiple select example">
                        @foreach($notification->recipients_list as $recipient)
                            <option value="{{ $recipient }}" disabled>{{ $recipient }}</option>
                        @endforeach
                    </select>
                </div>
        </div>
    </div>

</main><!-- End #main -->
@endsection

@push('style')
@endpush

@push('script')
@endpush
