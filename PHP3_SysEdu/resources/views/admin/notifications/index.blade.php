@extends('layouts.master')

@section('title', 'Send Notification')

@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gửi thông báo</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
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
                                <select id="faculties" name="faculties" class="form-select"
                                    onchange="updateMajors()">
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
                                    <select id="faculties" name="faculties[]" class="form-select" multiple
                                        aria-label="multiple select example">
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

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="title">Tiêu đề</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                id="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="content">Nội dung</label>
                        <div class="col-sm-10">
                            <textarea name="content" cols="20" rows="10" id="content"
                                class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pagetitle">
                        <h1>Quản lý thông báo</h1>
                    </div>
        
                    <div class="card shadow-sm">
                        <div class="card-body mt-3">
                            <!-- Tab navigation -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending"
                                       role="tab" aria-controls="pending" aria-selected="true">
                                       <i class="bx bx-clock"></i> Thông báo đang lên lịch
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="sent-tab" data-bs-toggle="tab" href="#sent"
                                       role="tab" aria-controls="sent" aria-selected="false">
                                       <i class="bx bx-send"></i> Thông báo đã gửi
                                    </a>
                                </li>
                            </ul>
        
                            <div class="tab-content mt-3" id="myTabContent">
                                <!-- Tab cho thông báo đang lên lịch -->
                                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                    <table class="table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tiêu đề</th>
                                                <th>Loại</th>
                                                <th>Ngày gửi</th>
                                                <th>Người gửi</th>
                                                <th>Gửi đến</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendingNotifications as $index => $notification)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="text-limited">{{ $notification->title }}</td>
                                                    <td>{{ $notification->type }}</td>
                                                    <td>{{ $notification->formatted_date_sent }}</td>
                                                    <td>{{ $notification->employee->full_name }}</td>
                                                    <td class="text-limited">{{ $notification->formatted_recipient }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                   href="{{ route('admin.notifications.detail', $notification->id) }}">
                                                                    <i class="bx bx-id-card me-2"></i>
                                                                    Xem chi tiết
                                                                </a>
        
                                                                <a class="dropdown-item"
                                                                   href="{{ route('admin.notifications.edit', $notification->id) }}">
                                                                    <i class="bx bx-edit-alt me-2"></i>
                                                                    Chỉnh sửa
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        {{ $pendingNotifications->links() }} <!-- Phân trang -->
                                    </div>
                                </div>
        
                                <!-- Tab cho thông báo đã gửi -->
                                <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab">
                                    <table class="table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tiêu đề</th>
                                                <th>Loại</th>
                                                <th>Ngày gửi</th>
                                                <th>Người gửi</th>
                                                <th>Gửi đến</th>
                                                <th>Tác vụ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sentNotifications as $index => $notification)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="text-limited">{{ $notification->title }}</td>
                                                    <td>{{ $notification->type }}</td>
                                                    <td>{{ $notification->formatted_date_sent }}</td>
                                                    <td>{{ $notification->employee->full_name }}</td>
                                                    <td class="text-limited">{{ $notification->formatted_recipient }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                   href="{{ route('admin.notifications.detail', $notification->id) }}">
                                                                    <i class="bx bx-id-card me-2"></i>
                                                                    Xem chi tiết
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        {{ $sentNotifications->links() }} <!-- Phân trang -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

@endsection

@push('style')
    <style>
        .ck-editor__editable {
            min-height: 200px;
        }

        .select2-container .select2-selection--multiple {
            min-height: 38px;
        }

        .text-limited {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@push('script')
    <script id="faculty-majors-data" type="application/json">
        @json($faculties->mapWithKeys(function($faculty) {
            return [$faculty->id => $faculty->majors];
        }))
    </script>

    <script src="{{ asset('assets/admin/js/notification.js') }}"></script>

    <script>
        // Khởi tạo CKEditor
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'undo', 'redo'
                ],
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        }
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
