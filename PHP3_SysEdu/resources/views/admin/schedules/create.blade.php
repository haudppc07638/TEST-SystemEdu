
@extends('layouts.master')

@section('title', 'Tạo Lịch Học')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tạo Lịch Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Quản Lý Lịch Học</a></li>
                <li class="breadcrumb-item active">Tạo Lịch Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3 mt-3 needs-validation" novalidate method="POST"
                              action="{{ route('admin.schedules.create.post', ['semesterId' => $semesterId]) }}">
                            @csrf
                            @method('POST')

                            <!-- Lớp Môn -->
                            <div class="col-md-12 mb-2">
                                <label for="subject_class_id" class="form-label">Lớp Môn</label>
                                <select class="form-select @error('subject_class_id') is-invalid @enderror"
                                        id="subject_class_id" name="subject_class_id">
                                    <option disabled selected>Chọn lớp môn...</option>
                                    @foreach ($subject_classes as $subject_class)
                                        <option value="{{ $subject_class->id }}"
                                                {{ old('subject_class_id') == $subject_class->id ? 'selected' : '' }}>
                                            {{ $subject_class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_class_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phòng Học -->
                            <div class="col-md-12 mb-2">
                                <label for="classroom_id" class="form-label">Phòng Học</label>
                                <select class="form-select @error('classroom_id') is-invalid @enderror"
                                        id="classroom_id" name="classroom_id">
                                    <option disabled selected>Chọn phòng học...</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}"
                                                {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                            {{ $classroom->code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classroom_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ca Học -->
                            <div class="col-md-12 mb-2">
                                <label for="time_slot_id" class="form-label">Ca Học</label>
                                <select class="form-select @error('time_slot_id') is-invalid @enderror"
                                        id="time_slot_id" name="time_slot_id">
                                    <option disabled selected>Chọn ca học...</option>
                                    @foreach ($time_slots as $time_slot)
                                        <option value="{{ $time_slot->id }}"
                                                {{ old('time_slot_id') == $time_slot->id ? 'selected' : '' }}>
                                            {{ $time_slot->slot }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('time_slot_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ngày Học -->
                            <div class="col-md-12 mb-2">
                                <label for="schedule_day" class="form-label">Ngày Học</label>
                                <input type="date" class="form-control @error('schedule_day') is-invalid @enderror"
                                       id="schedule_day" name="schedule_day" value="{{ old('schedule_day') }}">
                                @error('schedule_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Thêm hidden field cho semester_id -->
                            <input type="hidden" name="semester_id" value="{{ $semesterId }}">

                            <!-- Nút Submit -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Tạo Lịch Học</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- Kết thúc #main -->
@endsection
