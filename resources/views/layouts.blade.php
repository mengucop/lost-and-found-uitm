<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Lost & Found') }}</title>

    {{-- ✅ Use Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Optional Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-REPLACE_THIS" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
