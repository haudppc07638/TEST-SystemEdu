@extends('layouts.master')

@section('title', 'Update Credit')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quản Lý Tín Chỉ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Đào Tạo</li>
                <li class="breadcrumb-item active">Sửa Tín Chỉ</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <form class="mt-3" method="POST" action="{{ route('admin.credits.update', $credit->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="price" class="col-sm-2 col-form-label">Giá Tiền (1TC)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', number_format($credit->price)) }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="vat" class="col-sm-2 col-form-label">Thuế (VAT)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('vat') is-invalid @enderror" id="vat" name="vat" value="{{ old('vat', number_format($credit->vat)) }}">
                        @error('vat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>                
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection