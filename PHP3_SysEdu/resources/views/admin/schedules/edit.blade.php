@extends('layouts.master')

@section('title', 'Chỉnh sửa Lịch Học')

@section('main')
    <main id="main" class="main">
        <h1>Sửa Lịch Học</h1>
        <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="subject_class_id">Lớp Môn Học:</label>
                <select name="subject_class_id" id="subject_class_id" class="form-control" required>
                    <option value="">Chọn lớp môn học</option>
                    @foreach ($subjectClasses as $subjectClass)
                        <option value="{{ $subjectClass->id }}"
                            {{ $subjectClass->id == $schedule->subject_class_id ? 'selected' : '' }}>
                            {{ $subjectClass->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_class_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="time_slot_id">Khung Giờ:</label>
                <select name="time_slot_id" id="time_slot_id" class="form-control" required>
                    <option value="">Chọn khung giờ</option>
                    @foreach ($timeSlots as $timeSlot)
                        <option value="{{ $timeSlot->id }}"
                            {{ $timeSlot->id == $schedule->time_slot_id ? 'selected' : '' }}>
                            {{ $timeSlot->start_time }} - {{ $timeSlot->end_time }}
                        </option>
                    @endforeach
                </select>
                @error('time_slot_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="classroom_id">Phòng Học:</label>
                <select name="classroom_id" id="classroom_id" class="form-control" required>
                    <option value="">Chọn phòng học</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}"
                            {{ $classroom->id == $schedule->classroom_id ? 'selected' : '' }}>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                </select>
                @error('classroom_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="schedule_day">Ngày Học:</label>
                <input type="date" name="schedule_day" class="form-control" value="{{ $schedule->schedule_day }}"
                    required>
                @error('schedule_day')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
    </main><!-- Kết thúc #main -->
@endsection

@push('style')
@endpush

@push('script')
@endpush
