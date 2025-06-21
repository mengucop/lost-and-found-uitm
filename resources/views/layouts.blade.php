<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Lost & Found') }}</title>

    {{-- ✅ Load Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ Optional: Font Awesome CDN --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-REPLACE_WITH_REAL_HASH"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
