@extends('layouts.master')

@section('title', 'Add News')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Quản lý tin tức</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">Tin tức</a></li>
                    <li class="breadcrumb-item active">Thêm tin tức</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="card">
            <div class="card-body">

                <form class="row g-3 mt-3 needs-validation" novalidate method="POST" enctype="multipart/form-data"
                    action="{{ route('admin.news.store') }}">
                    @csrf
                    @method('POST')

                    <div class="row my-3">
                        <label class="col-sm-2 col-form-label" for="title">Tiêu đề</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-sm-2 col-form-label" for="image">Ảnh</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                                accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-sm-2 col-form-label" for="content">Nội dung</label>
                        <div class="col-sm-12">
                            <textarea name="content" cols="20" rows="10" id="content"
                                class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success">Thêm mới</button>
                        </div>
                    </div>
                </form>

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
