<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title> @yield('title') </title>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- icon -->
    <link href="{{ asset('assets/images/syseduicon.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <!-- dataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">

    @stack('style')


</head>

<body>

    {{-- header --}}
    <x-header></x-header>

    {{-- sidebar --}}
    <x-sidebar></x-sidebar>

    {{-- main --}}
    @yield('main')

    {{-- footer --}}
    <x-footer></x-footer>

    {{-- Back to top --}}
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="{{ asset('assets/vendor/jquery/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <!-- dataTables JS -->
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>

    <!-- jszip CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"
        integrity="sha512-XMVd28F1oH/O71fzwBnV7HucLxVwtxf26XV8P4wPk26EDxuGZ91N8bsOttmnomcCD3CS5ZMRL50H0GgOHvegtg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- pdfmake CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/pdfmake.min.js"
        integrity="sha512-axXaF5grZBaYl7qiM6OMHgsgVXdSLxqq0w7F4CQxuFyrcPmn0JfnqsOtYHUun80g6mRRdvJDrTCyL8LQqBOt/Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


    <!-- Template Main JS File -->
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var quill = new Quill('#editor-container', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            ['link', 'image'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }]
                        ]
                    }
                });

                quill.root.innerHTML = document.getElementById('description').value;

                quill.on('text-change', function() {
                    var content = quill.root.innerHTML;
                    document.getElementById('description').value = content.replace(/<\/?[^>]+(>|$)/g, "");
                });
            });
        </script>
    @endpush
    @stack('script')

</body>

</html>
