<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-zinc-100 bg-zinc-950 selection:bg-white selection:text-black">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10 p-6">

        <!-- Logo Area -->
        <div class="mb-8 text-center animate-fade-in">
            <a href="/" class="flex flex-col items-center gap-4 group">
                <img src="{{ asset('images/logo.png') }}"
                    class="w-16 h-16 object-contain grayscale group-hover:grayscale-0 transition-all duration-500"
                    alt="Logo">
                <span class="text-2xl font-light text-white tracking-tighter">Raolak<span
                        class="text-zinc-500 font-extralight">School</span></span>
            </a>
        </div>

        <!-- Glass Card -->
        <div
            class="w-full sm:max-w-md p-8 sm:p-10 bg-zinc-900/50 backdrop-blur-md border border-zinc-800/80 shadow-2xl rounded-2xl animate-slide-up">
            {{ $slot }}
        </div>

        <!-- Footer Text -->
        <div class="mt-8 text-center text-xs text-zinc-600 font-medium tracking-wide uppercase animate-fade-in"
            style="animation-delay: 0.2s;">
            &copy; {{ date('Y') }} Raolak Tech School.
        </div>
    </div>
</body>

</html>