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
                                                <div class="checkbox-wrapper-7">
                                                    <input type="hidden" name="attendance[{{ $student->id }}]"
                                                        value="0">
                                                    <input class="tgl tgl-ios attendance-checkbox"
                                                        id="attendance-{{ $student->id }}"
                                                        name="attendance[{{ $student->id }}]" type="checkbox"
                                                        data-student-id="{{ $student->id }}"
                                                        checked
                                                        {{ $student->attendances->first()?->status ? 'checked' : '' }}>
                                                    <label class="tgl-btn" for="attendance-{{ $student->id }}"></label>
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
        .checkbox-wrapper-7 .tgl {
            display: none;
        }

        .checkbox-wrapper-7 .tgl,
        .checkbox-wrapper-7 .tgl:after,
        .checkbox-wrapper-7 .tgl:before,
        .checkbox-wrapper-7 .tgl *,
        .checkbox-wrapper-7 .tgl *:after,
        .checkbox-wrapper-7 .tgl *:before,
        .checkbox-wrapper-7 .tgl+.tgl-btn {
            box-sizing: border-box;
        }

        .checkbox-wrapper-7 .tgl+.tgl-btn {
            outline: 0;
            display: block;
            width: 4em;
            height: 2em;
            position: relative;
            cursor: pointer;
            user-select: none;
            background: #6b6969;
            border-radius: 2em;
            padding: 2px;
            transition: all 0.4s ease;
            border: 1px solid #e8eae9;
        }

        .checkbox-wrapper-7 .tgl+.tgl-btn:after {
            content: "";
            position: relative;
            display: block;
            width: 50%;
            height: 100%;
            background: #fbfbfb;
            border-radius: 2em;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1), 0 4px 0 rgba(0, 0, 0, 0.08);
            transition: left 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), padding 0.3s ease, margin 0.3s ease;
            left: 0;
        }

        .checkbox-wrapper-7 .tgl-ios:checked+.tgl-btn {
            background: #86d993;
        }

        .checkbox-wrapper-7 .tgl-ios:checked+.tgl-btn:after {
            left: 50%;
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
