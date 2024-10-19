@extends('layouts.master')

@section('title', 'Thêm Sinh Viên')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản Lý Sinh Viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">Đào tạo</li>
                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Sinh viên</a></li>
                <li class="breadcrumb-item active">Thêm sinh viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <form class="row g-3 mt-3 needs-validation" novalidate method="POST" action="{{ route('admin.students.create.post') }}" enctype="multipart/form-data">
                @csrf

                <!-- Họ và tên -->
                <div class="col-md-6">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" placeholder="Nhập họ và tên">
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ngày sinh -->
                <div class="col-md-6">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Nhập email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Giới tính -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Giới tính</label>
                    <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                        <option disabled selected>Chọn giới tính...</option>
                        <option value="0" {{ old('gender') === '0' ? 'selected' : '' }}>Nữ</option>
                        <option value="1" {{ old('gender') === '1' ? 'selected' : '' }}>Nam</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số điện thoại -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ảnh -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Ảnh</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Quốc tịch -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Quốc tịch</label>
                    <input type="text" class="form-control @error('nation') is-invalid @enderror" name="nation" value="{{ old('nation') }}" placeholder="Nhập quốc tịch">
                    @error('nation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CMND/CCCD -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">CMND/CCCD</label>
                    <input type="text" class="form-control @error('identity_card') is-invalid @enderror" name="identity_card" value="{{ old('identity_card') }}" placeholder="Nhập CMND/CCCD">
                    @error('identity_card')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ngày cấp -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Ngày cấp</label>
                    <input type="date" class="form-control @error('card_issuance_date') is-invalid @enderror" name="card_issuance_date" value="{{ old('card_issuance_date') }}">
                    @error('card_issuance_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nơi cấp -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Nơi cấp</label>
                    <input type="text" class="form-control @error('card_location') is-invalid @enderror" name="card_location" value="{{ old('card_location') }}" placeholder="Nhập nơi cấp">
                    @error('card_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Địa chỉ -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control @error('house_number') is-invalid @enderror" name="house_number" value="{{ old('house_number') }}" placeholder="Số nhà">
                    @error('house_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input type="text" class="form-control @error('commune_level') is-invalid @enderror" name="commune_level" value="{{ old('commune_level') }}" placeholder="Xã/Phường">
                    @error('commune_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input type="text" class="form-control @error('district') is-invalid @enderror" name="district" value="{{ old('district') }}" placeholder="Quận/Huyện">
                    @error('district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input type="text" class="form-control @error('provice_city') is-invalid @enderror" name="provice_city" value="{{ old('provice_city') }}" placeholder="Tỉnh/Thành phố">
                    @error('provice_city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Người bảo hộ -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Người bảo hộ</label>
                    <input type="text" class="form-control @error('sponsor_name') is-invalid @enderror" name="sponsor_name" value="{{ old('sponsor_name') }}" placeholder="Nhập tên người bảo hộ">
                    @error('sponsor_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số điện thoại bảo hộ -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Số điện thoại bảo hộ</label>
                    <input type="text" class="form-control @error('sponsor_phone') is-invalid @enderror" name="sponsor_phone" value="{{ old('sponsor_phone') }}" placeholder="Nhập số điện thoại bảo hộ">
                    @error('sponsor_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Chuyên ngành -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Chuyên ngành</label>
                    <select class="form-select @error('major_id') is-invalid @enderror" name="major_id">
                        <option disabled selected>Chọn chuyên ngành...</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                        @endforeach
                    </select>
                    @error('major_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lớp chuyên ngành -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Lớp chuyên ngành</label>
                    <select class="form-select @error('major_class_id') is-invalid @enderror" name="major_class_id">
                        <option disabled selected>Chọn lớp chuyên ngành...</option>
                        @foreach ($classes as $majorClass)
                            <option value="{{ $majorClass->id }}" {{ old('major_class_id') == $majorClass->id ? 'selected' : '' }}>{{ $majorClass->name }}</option>
                        @endforeach
                    </select>
                    @error('major_class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Thêm Sinh Viên</button>
                </div>

            </form>
        </div>
    </div>

</main><!-- End #main -->

@endsection

@push('style')
@endpush

@push('script')
@endpush
