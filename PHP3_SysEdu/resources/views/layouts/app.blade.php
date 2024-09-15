<!DOCTYPE html>
<html x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> @yield('title') </title>

    <link href="{{ asset('assets/images/syseduicon.png') }}" rel="icon">

    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
    />
   
    <link href="{{ asset('assets/client/css/tailwind.output.css') }}" rel="stylesheet">

    @stack('style')

    
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50"
      :class="{ 'overflow-hidden': isSideMenuOpen }"
    >

    <x-client.sidebar class="w-1/4 bg-gray-200 p-4">
   <!-- Nội dung của sidebar -->
    </x-client.sidebar>

     <!-- Nội dung chính -->
      <div class="flex flex-col flex-1 w-3/4 p-6">
        <x-client.header></x-client.header>
       
        @yield('main')

        <div class="loader"></div>

      </div>
    </div>

    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
      defer
    ></script>

    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>

    <script src="{{ asset('assets/client/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('assets/client/js/charts-pie.js') }}" defer></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <script src="{{ asset('assets/client/js/init-alpine.js') }}"></script>
    <script src="{{ asset('assets/client/js/main.js') }}"></script>

    @stack('script')

  </body>
</html>