<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','judul tidak masuk')</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('icons/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
  <script src="https://cdn.jsdelivr.net/npm/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')



</head>
<body class="bg-[#F1FFDE] h-full w-full ">
    @php
        $dataUser=session('dataUser')
    @endphp
    @if (!Route::is('login'))
        @include('components.navbar', $dataUser)
    @endif

    @if (!Route::is('login'))
    <div class="lg:ml-[16.5rem] ml-0 w-full lg:w-[63rem]  ">
        @yield('content')
    </div>
    @else
    @yield('content')
    @endif
    <script>
        const userStatus = "{{ session('dataUser')['status'] ?? 'guest' }}";
    </script>

</body>
</html>
