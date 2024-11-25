@extends('layouts.lecturer')

@section('main')
    <main id="main" class="main">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title mb-0 text-white">
                        Điểm Danh - {{ $subjectClass->class_code }} - {{ $subjectClass->subject->name }}
                    </h3>
                    <a href="{{ route('classes') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
                <div class="card-body mt-3">
                    <form action="{{ route('attendance.store', $subjectClass->id) }}" method="POST">
                        @csrf
                        <!-- Chọn ngày -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="date" class="form-label">Ngày điểm danh:</label>
                                <input type="date" name="date" id="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    value="{{ old('date', $date) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Tiết học: {{ $scheduleData->timeSlot->slot }}</label>
                                <div class="form-control-plaintext">
                                    {{ $scheduleData->timeSlot->start_time }} - {{ $scheduleData->timeSlot->end_time }}
                                </div>
                            </div>
                        </div>
                        <!-- Bảng điểm danh -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">STT</th>
                                        <th style="width: 120px;">Mã SV</th>
                                        <th>Họ và tên</th>
                                        <th style="width: 120px;">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scheduleData->subjectClass->studentSubjectClasses as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->student->code }}</td>
                                            <td>{{ $student->student->full_name }}</td>
                                            <td class="text-center">
                                                <div class="checkbox-wrapper-59">
                                                    <input type="hidden" name="attendance[{{ $student->id }}]" value="0"> <!-- Giá trị mặc định -->
                                                    <label class="switch">
                                                        <input type="checkbox" class="attendance-checkbox"
                                                            name="attendance[{{ $student->id }}]"
                                                            data-student-id="{{ $student->id }}"
                                                            {{ $student->attendances->first()?->status ? 'checked' : '' }}>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu điểm danh
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </main>
@endsection

@push('style')
    <style>
        .checkbox-wrapper-59 input[type="checkbox"] {
            visibility: hidden;
            display: none;
        }

        .checkbox-wrapper-59 *,
        .checkbox-wrapper-59 ::after,
        .checkbox-wrapper-59 ::before {
            box-sizing: border-box;
        }

        .checkbox-wrapper-59 .switch {
            width: 60px;
            height: 30px;
            position: relative;
            display: inline-block;
        }

        .checkbox-wrapper-59 .slider {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            border-radius: 30px;
            box-shadow: 0 0 0 2px #dc1414, 0 0 4px #dc1414;
            cursor: pointer;
            border: 4px solid transparent;
            overflow: hidden;
            transition: 0.2s;
        }

        .checkbox-wrapper-59 .slider:before {
            position: absolute;
            content: "";
            width: 100%;
            height: 100%;
            background-color: #dc1414;
            border-radius: 30px;
            transform: translateX(-56px);
            transition: 0.2s;
        }

        .checkbox-wrapper-59 input:checked+.slider:before {
            transform: translateX(4px);
            background-color: limeGreen;
        }

        .checkbox-wrapper-59 input:checked+.slider {
            box-shadow: 0 0 0 2px limeGreen, 0 0 8px limeGreen;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Xử lý checkbox điểm danh
            $('.attendance-checkbox').change(function() {
                const studentId = $(this).data('student-id');
                // Có thể thêm logic xử lý khi checkbox được thay đổi nếu cần
            });
        });
    </script>
@endpush
