<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Aplikasi Rapor' }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-gray-800 bg-blue-50">
    {{ $slot }}
    <!-- Footer -->
    <footer class="py-6 text-center text-white bg-blue-500">
        <p class="text-sm">&copy; 2025 Aplikasi Rapor. Dikembangkan untuk kemudahan staf sekolah dan orang tua siswa.
        </p>
    </footer>

    @livewireScripts

    @yield('js')
</body>

</html>
