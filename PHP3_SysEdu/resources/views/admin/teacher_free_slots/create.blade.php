@extends('layouts.master')

@section('title', 'Đăng Ký Ca Dạy Rảnh Của Giảng Viên')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Đăng Ký Ca Dạy Rảnh Của Giảng Viên</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <form action="{{ route('admin.teacher_free_slots.storeOrUpdate', $employee->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="time_slots" class="form-label">Ca Dạy Rảnh</label>
                                <select class="form-select" id="time_slots" name="time_slots[]" multiple>
                                    @foreach ($timeSlots as $timeSlot)
                                        <option value="{{ $timeSlot->id }}"
                                            {{ in_array($timeSlot->id, old('time_slots', $employeeTimeSlots)) ? 'selected' : '' }}>
                                            {{ $timeSlot->slot }} ({{ $timeSlot->start_time }} - {{ $timeSlot->end_time }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('time_slots')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_day" class="form-label">Ngày Bắt Đầu</label>
                                <input type="date" class="form-control" id="start_day" name="start_day" 
                                       value="{{ old('start_day', $freeSlot->start_day ?? '') }}">
                                @error('start_day')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_day" class="form-label">Ngày Kết Thúc</label>
                                <input type="date" class="form-control" id="end_day" name="end_day" 
                                       value="{{ old('end_day', $freeSlot->end_day ?? '') }}">
                                @error('end_day')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Lưu Ca Dạy Rảnh</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Sử dụng Select2 để hiển thị và chọn nhiều ca học
        $('#time_slots').select2({
            placeholder: "Chọn các ca dạy rảnh",
            allowClear: true
        });
    });
</script>
@endpush
