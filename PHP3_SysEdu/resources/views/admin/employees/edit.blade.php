@extends('layouts.master')

@section('title', 'schedules')

@section('main')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản Lý Nhân Sự</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Đào tạo</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">Nhân sự</a></li>
                    <li class="breadcrumb-item active">Cập nhập thông tin nhân sự</li>
                </ol>
            </nav>
        </div>
    
        <div class="card">
            <div class="card-body">
                <form class="row g-3 mt-3 needs-validation" 
                novalidate 
                method="POST"
                action="{{ route('admin.employees.update',$employee->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <!-- Họ và tên -->
                    <div class="col-md-6">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name', $employee->full_name) }}">
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Mã Số:</label>
                        <input type="code" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $employee->code) }}">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Email -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $employee->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Chức vụ -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Chức vụ</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="position" id="positionTeacher"
                                value="teacher" {{ old('position', $employee->position) == 'teacher' ? 'checked' : '' }}>
                            <label class="form-check-label" for="positionTeacher">Giáo viên</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="position" id="positionOfficer"
                                value="admin" {{ old('position', $employee->position) == 'admin' ? 'checked' : '' }}>
                            <label class="form-check-label" for="positionOfficer">Cán bộ đào tạo</label>
                        </div>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Số điện thoại -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $employee->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Ảnh -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Ảnh</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Chuyên Nghành -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Chuyên Nghành</label>
                        <select class="form-select @error('major_id') is-invalid @enderror" name="major_id">
                            <option disabled selected>Chọn Chuyên Nghành</option>
                            @foreach ($majors as $major)
                                <option value="{{ $major->id }}" {{ old('major_id', $employee->major_id) == $major->id ? 'selected' : '' }}>
                                    {{ $major->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('major_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Phòng Ban -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Phòng Ban</label>
                        <select class="form-select @error('department_id') is-invalid @enderror" name="department_id">
                            <option disabled selected>Chọn phòng ban...</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Quốc tịch -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Quốc tịch</label>
                        <input type="text" class="form-control @error('nation') is-invalid @enderror" name="nation" value="{{ old('nation', $employee->nation) }}">
                        @error('nation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Trình độ học vấn -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Trình độ học vấn</label>
                        <input type="text" class="form-control @error('educational_level') is-invalid @enderror" name="educational_level" value="{{ old('educational_level', $employee->educational_level ) }}">
                        @error('educational_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Số CMND -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Số CMND</label>
                        <input type="text" class="form-control @error('identity_card') is-invalid @enderror" name="identity_card" value="{{ old('identity_card',$employee->identity_card) }}">
                        @error('identity_card')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Ngày cấp -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Ngày cấp</label>
                        <input type="date" class="form-control @error('card_issuance_date') is-invalid @enderror" name="card_issuance_date" value="{{ old('card_issuance_date',$employee->card_issuance_date) }}">
                        @error('card_issuance_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Nơi cấp -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Nơi cấp</label>
                        <input type="text" class="form-control @error('card_location') is-invalid @enderror" name="card_location" value="{{ old('card_location',$employee->card_location) }}">
                        @error('card_location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Địa chỉ -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control @error('house_number') is-invalid @enderror" name="house_number" value="{{ old('house_number',$employee->house_number) }}">
                        @error('house_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Ngày sinh -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth',$employee->date_of_birth) }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Năm tốt nghiệp -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Năm tốt nghiệp</label>
                        <input type="text" class="form-control @error('year_graduation') is-invalid @enderror" name="year_graduation" value="{{ old('year_graduation',$employee->year_graduation) }}">
                        @error('year_graduation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Tốt nghiệp -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Tốt nghiệp</label>
                        <input type="text" class="form-control @error('graduate') is-invalid @enderror" name="graduate" value="{{ old('graduate',$employee->graduate) }}">
                        @error('graduate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Add Gender -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Giới tính</label>
                        <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                            <option disabled selected>Chọn giới tính...</option>
                            <option value="0" {{ old('gender',$employee->gender) == '0' ? 'selected' : '' }}>Nam</option>
                            <option value="1" {{ old('gender',$employee->gender) == '1' ? 'selected' : '' }}>Nữ</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Province/City -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Tỉnh/Thành phố</label>
                        <input type="text" class="form-control @error('provice_city') is-invalid @enderror" name="provice_city" value="{{ old('provice_city',$employee->provice_city) }}">
                        @error('provice_city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- District -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Quận/Huyện</label>
                        <input type="text" class="form-control @error('district') is-invalid @enderror" name="district" value="{{ old('district',$employee->district) }}">
                        @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Commune/Level -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Xã/Phường</label>
                        <input type="text" class="form-control @error('commune_level') is-invalid @enderror" name="commune_level" value="{{ old('commune_level',$employee->commune_level) }}">
                        @error('commune_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Thêm mới</button>
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
