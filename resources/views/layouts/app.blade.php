<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Travel Insurance Quoting System ') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-white text-gray-900 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-sky-600 text-white py-4 shadow">
        <div class="px-16">
            <h1 class="text-lg font-semibold">
                Travel Insurance Quoting System
            </h1>
        </div>
    </header>

    <!-- Main content -->
    <main class="flex-grow p-6">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 text-gray-600 text-sm py-4 text-center">
        © {{ date('Y') }} Travel Insurance Quoting System. Osanda Gamage. All rights reserved.
    </footer>

    @livewireScripts
</body>
</html>
