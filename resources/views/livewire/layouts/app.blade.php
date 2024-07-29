<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Rapor | @yield('title')
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @yield('sticky-header-table')

    <!-- Scripts -->
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <wireui:scripts />
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <livewire:layout.navbar2 />

        <livewire:layout.sidebar />

        <!-- Page Content -->
        <main>
            <div class="p-4 mt-14 sm:ml-64">
                <x-notifications z-index="z-50" />
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts

    <script>
        window.addEventListener('showNotif', function(e) {
            const {
                title = 'Berhasil', description = 'Data berhasil disimpan', icon = 'success', timeout = 1500
            } = event.detail;
            $wireui.notify({
                title,
                description,
                icon,
                timeout
            });
        });
    </script>

</body>

</html>
