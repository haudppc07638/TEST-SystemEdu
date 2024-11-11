@extends('layouts.master')

@section('title', 'Chỉnh sửa Lịch Học')

@section('main')
    <main id="main" class="main">
        <h1>Chỉnh sửa Lịch Học</h1>

        <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="date">Ngày Học</label>
                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                    value="{{ old('date', $schedule->date->format('Y-m-d')) }}" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="time_slot_id">Khung Giờ</label>
                <select name="time_slot_id" id="time_slot_id"
                    class="form-control @error('time_slot_id') is-invalid @enderror" required>
                    <option value="">Chọn khung giờ</option>
                    @foreach ($timeSlots as $timeSlot)
                        <option value="{{ $timeSlot->id }}"
                            {{ $schedule->time_slot_id == $timeSlot->id ? 'selected' : '' }}>
                            {{ $timeSlot->start_time }} - {{ $timeSlot->end_time }}
                        </option>
                    @endforeach
                </select>
                @error('time_slot_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="classroom_id">Phòng Học</label>
                <select name="classroom_id" id="classroom_id"
                    class="form-control @error('classroom_id') is-invalid @enderror" required>
                    <option value="">Chọn phòng học</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}"
                            {{ $schedule->classroom_id == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->code }}
                        </option>
                    @endforeach
                </select>
                @error('classroom_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject_class_id">Lớp Môn Học</label>
                <select name="subject_class_id" id="subject_class_id"
                    class="form-control @error('subject_class_id') is-invalid @enderror" required>
                    <option value="">Chọn lớp môn học</option>
                    @foreach ($subjectClasses as $subjectClass)
                        <option value="{{ $subjectClass->id }}"
                            {{ $schedule->subject_class_id == $subjectClass->id ? 'selected' : '' }}>
                            {{ $subjectClass->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_class_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Cập Nhật</button>
            <a href="{{ route('admin.schedules.view-schedule', ['subject_class_id' => $schedule->subject_class_id]) }}"
                class="btn btn-secondary">Quay Lại</a>
        </form>
    </main>
@endsection
