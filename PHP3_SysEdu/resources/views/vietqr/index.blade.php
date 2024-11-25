@extends('layouts.app')

@section('title', 'Trang Chủ | SysEdu')

@section('main')
<main class="h-full pb-16 overflow-y-auto">
    <h1>Quét mã QR để thanh toán</h1>
    <div class="qrcode">
        @if(isset($qrCodeUrl))
            <img src="{{ $qrCodeUrl }}" alt="Mã QR" width="540" height="540">
        @else
            <p>Không có mã QR để hiển thị</p>
        @endif
    </div>
@endsection
