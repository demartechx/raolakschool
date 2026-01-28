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

<body class="font-sans antialiased text-zinc-100 bg-zinc-950">
    <div class="flex min-h-screen bg-zinc-950" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 w-56 bg-zinc-950 border-r border-zinc-900 transition-transform duration-300 transform -translate-x-full md:translate-x-0 z-30 flex flex-col"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

            <!-- Logo -->
            <div class="h-20 flex items-center px-8 border-b border-zinc-900">
                <span class="text-xl font-bold text-white tracking-tighter">Raolak<span
                        class="text-zinc-600 font-light">School</span></span>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-8 space-y-1.5">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-zinc-900 text-white border border-zinc-800 shadow-sm' : 'text-zinc-500 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-zinc-600 group-hover:text-zinc-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('student.enroll') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('student.enroll') ? 'bg-zinc-900 text-white border border-zinc-800 shadow-sm' : 'text-zinc-500 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('student.enroll') ? 'text-white' : 'text-zinc-600 group-hover:text-zinc-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    Enrollments
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('profile.edit') ? 'bg-zinc-900 text-white border border-zinc-800 shadow-sm' : 'text-zinc-500 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-zinc-600 group-hover:text-zinc-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Account
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-6 border-t border-zinc-900">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-3 text-sm font-medium text-red-500/80 hover:text-red-400 rounded-lg hover:bg-red-500/5 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Header (Visible on small screens) -->
        <div
            class="md:hidden fixed top-0 w-full bg-zinc-950 border-b border-zinc-900 z-50 px-4 h-16 flex items-center justify-between backdrop-blur-md bg-opacity-80">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" class="w-8 h-8 object-contain" alt="Logo">
                <span class="font-bold text-lg text-white tracking-tighter">Raolak<span
                        class="text-zinc-600 font-light">School</span></span>
            </div>
            <!-- Mobile Menu Button -->
            <button @click="sidebarOpen = !sidebarOpen" class="text-zinc-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>


        <!-- Page Content -->
        <main class="flex-1 md:ml-56 p-8 md:p-12 pt-24 md:pt-12 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>
</body>

</html>