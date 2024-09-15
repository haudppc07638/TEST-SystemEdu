@extends('layouts.master')

@section('title', 'Send Notification')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gửi Thông báo</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item">Gửi thông báo</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.notifications.send') }}" method="POST" class="mt-3 needs-validation"
                    novalidate id="notification">
                    @csrf
                    <!-- Chọn người gửi -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="recipient_type">Gửi đến</label>
                        <div class="col-sm-10">
                            <select id="recipient_type" name="recipient_type" class="form-select"
                                onchange="toggleRecipientFields()">
                                <option disabled selected>-- Người nhận --</option>
                                <option value="students">Sinh viên</option>
                                <option value="teachers">Giáo viên</option>
                            </select>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <!-- Chọn khoa và chuyên ngành (ẩn/show tùy thuộc vào loại người nhận) -->
                    <div id="students-fields" style="display:none;">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="faculties">Khoa</label>
                            <div class="col-sm-10">
                                <select id="faculties" name="faculties" class="form-select" onchange="updateMajors()">
                                    <option value="">-- Chọn Khoa --</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="majors">Chuyên ngành</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div id="majors-checkboxes" class="col-4">
                                        <!-- Các checkbox cho chuyên ngành sẽ được hiển thị ở đây -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="teachers-fields" style="display:none;">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="faculties">Khoa</label>
                            <div class="col-sm-10">
                                <div id="faculties">
                                    <!-- Các checkbox cho khoa sẽ được hiển thị ở đây -->
                                    <select id="faculties" name="faculties[]" class="form-select" multiple aria-label="multiple select example">
                                        @foreach ($faculties as $faculty)
                                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="type">Gửi qua</label>
                        <div class="col-sm-10">
                            <select id="type" name="type" class="form-select">
                                <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="system" {{ old('type') == 'system' ? 'selected' : '' }}>Hệ thống</option>
                            </select>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="date_sent">Thời gian gửi</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" id="date_sent" name="date_sent" placeholder="Nhập tiêu đề ..."
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('date_sent') }}">
                            @error('date_sent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tiêu đề và nội dung -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="title">Tiêu đề</label>
                        <div class="col-sm-10">
                            <input type="text" id="title" name="title" placeholder="Nhập tiêu đề ..."
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="content">Nội dung</label>
                        <div class="col-sm-10">
                            <textarea name="content" id="content" class="form-control quill-editor-full mb-3 @error('content') is-invalid @enderror"
                                rows="4">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title p-4">
                            <h4>Các thông báo đã gửi</h4>
                        </div>
                        <div class="card-body">
                            <table id="tableNotification" class="table datatable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tiêu đề</th>
                                        <th>Nội dung</th>
                                        <th>Loại</th>
                                        <th>Ngày gửi</th>
                                        <th>Người gửi</th>
                                        <th>Gửi đến</th>
                                        <th>Xem</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($notifications as $index => $notification)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-limited">{{ $notification->title }}</td>
                                            <td class="text-limited">{{ $notification->content }}</td>
                                            <td>{{ $notification->type }}</td>
                                            <td>{{ $notification->formatted_date_sent }}</td>
                                            <td>{{ $notification->employee->fullname }}</td>
                                            <td class="text-limited">{{ $notification->formatted_recipient }}</td>
                                            <td>
                                                <a href="{{ route('admin.notifications.detail', $notification->id) }}">
                                                    <i class="bi fs-5 bi-box-arrow-in-down-left"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
          

    </main><!-- End #main -->

@endsection

@push('style')
   
@endpush

@push('script')
    <script id="faculty-majors-data" type="application/json">
    @json($faculties->mapWithKeys(function($faculty) {
        return [$faculty->id => $faculty->majors];
    }))
</script>

    <script src="{{ asset('assets/admin/js/notification.js') }}"></script>
@endpush



