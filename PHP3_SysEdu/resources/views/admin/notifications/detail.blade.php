@extends('layouts.master')

@section('title', 'Chi tiết thông báo')

@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Chi tiết thông báo</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Gửi thông báo</a></li>
                <li class="breadcrumb-item active">Chi tiết</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-12 form-group">
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" value="{{ $notification->title }}" disabled>
                </div>
                <div class="col-md-12 form-group mt-4">
                    <label class="form-label">Nội dung</label>
                    <div class="border p-2" style="height: 200px; overflow-y: auto; background-color: #f8f9fa;">
                        {!! (($notification->content)) !!} <!-- Hiển thị nội dung với định dạng HTML -->
                    </div>
                </div>
                <div class="col-md-6 form-group mt-4">
                    <label class="form-label">Loại thông báo</label>
                    <input type="text" class="form-control" value="Gửi qua: {{ $notification->type }}" disabled>
                </div>
                <div class="col-md-6 form-group mt-4">
                    <label class="form-label">Thời gian gửi</label>
                    <input type="text" class="form-control" value="{{ $notification->formatted_date_sent }}" disabled>
                </div>
                <div class="col-md-12 form-group mt-4">
                    <label class="form-label">Người gửi</label>
                    <input type="text" class="form-control" value="{{ $notification->employee->full_name }}" disabled>
                </div>
                <div class="col-md-12 form-group mt-4">
                    <label class="form-label">Gửi đến</label>
                    <select class="form-select" multiple aria-label="multiple select example" disabled>
                        @foreach($notification->recipients as $recipient)
                            <option value="{{ $recipient }}">{{ $recipient }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

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

        /* Cải thiện kiểu dáng cho nội dung */
        .border {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            background-color: #f8f9fa;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Cải thiện kiểu dáng cho các trường input */
        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 1;
        }

        /* Cải thiện kiểu dáng cho nút */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
@endpush

@push('script')
    <script>
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