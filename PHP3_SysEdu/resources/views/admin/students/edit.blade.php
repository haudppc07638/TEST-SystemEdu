@extends('layouts.master')

@section('title', 'Chỉnh sửa sinh viên')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản lý sinh viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                <li class="breadcrumb-item">Đào tạo</li>
                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Sinh viên</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa sinh viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <form class="row g-3 mt-3 needs-validation" novalidate method="POST" action="{{ route('admin.students.update', $student->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Họ và tên -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name', $student->full_name) }}">
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ngày sinh -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', \Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d')) }}">
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Giới tính -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Giới tính</label>
                    <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                        <option value="1" {{ old('gender', $student->gender) == 1 ? 'selected' : '' }}>Nam</option>
                        <option value="0" {{ old('gender', $student->gender) == 0 ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Quốc tịch -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Quốc tịch</label>
                    <input type="text" class="form-control @error('nation') is-invalid @enderror" name="nation" value="{{ old('nation', $student->nation) }}">
                    @error('nation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $student->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số điện thoại -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $student->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CMND/CCCD -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">CMND/CCCD</label>
                    <input type="text" class="form-control @error('identity_card') is-invalid @enderror" name="identity_card" value="{{ old('identity_card', $student->identity_card) }}">
                    @error('identity_card')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ngày cấp CMND/CCCD -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Ngày cấp CMND/CCCD</label>
                    <input type="date" class="form-control @error('card_issuance_date') is-invalid @enderror" name="card_issuance_date" value="{{ old('card_issuance_date', \Carbon\Carbon::parse($student->card_issuance_date)->format('Y-m-d')) }}">
                    @error('card_issuance_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nơi cấp CMND/CCCD -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Nơi cấp CMND/CCCD</label>
                    <input type="text" class="form-control @error('card_location') is-invalid @enderror" name="card_location" value="{{ old('card_location', $student->card_location) }}">
                    @error('card_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tỉnh/Thành phố -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Tỉnh/Thành phố</label>
                    <input type="text" class="form-control @error('provice_city') is-invalid @enderror" name="provice_city" value="{{ old('provice_city', $student->provice_city) }}">
                    @error('provice_city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Quận/Huyện -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Quận/Huyện</label>
                    <input type="text" class="form-control @error('district') is-invalid @enderror" name="district" value="{{ old('district', $student->district) }}">
                    @error('district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Xã/Phường -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Xã/Phường</label>
                    <input type="text" class="form-control @error('commune_level') is-invalid @enderror" name="commune_level" value="{{ old('commune_level', $student->commune_level) }}">
                    @error('commune_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số nhà -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Số nhà</label>
                    <input type="text" class="form-control @error('house_number') is-invalid @enderror" name="house_number" value="{{ old('house_number', $student->house_number) }}">
                    @error('house_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Người bảo hộ -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Tên người bảo hộ</label>
                    <input type="text" class="form-control @error('sponsor_name') is-invalid @enderror" name="sponsor_name" value="{{ old('sponsor_name', $student->sponsor_name) }}">
                    @error('sponsor_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số điện thoại người bảo hộ -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Số điện thoại người bảo hộ</label>
                    <input type="text" class="form-control @error('sponsor_phone') is-invalid @enderror" name="sponsor_phone" value="{{ old('sponsor_phone', $student->sponsor_phone) }}">
                    @error('sponsor_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Chuyên ngành -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Chuyên ngành</label>
                    <select class="form-select @error('major_id') is-invalid @enderror" name="major_id">
                        @foreach($majors as $major)
                            <option value="{{ $major->id }}" {{ old('major_id', $student->major_id) == $major->id ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
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
                        @foreach($classes as $majorClass)
                            <option value="{{ $majorClass->id }}" {{ old('major_class_id', $student->major_class_id) == $majorClass->id ? 'selected' : '' }}>
                                {{ $majorClass->name }}
                            </option>   
                        @endforeach
                    </select>
                    @error('major_class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ảnh đại diện -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Ảnh đại diện</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>

</main><!-- End #main -->
@endsection
