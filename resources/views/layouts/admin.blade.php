{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Admin - Mutu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body
    class="bg-slate-50 font-sans antialiased min-h-screen text-slate-800 lg:flex"
    x-data="{ sidebarOpen: false }"
    @keydown.escape.window="sidebarOpen = false"
>

    <!-- Mobile Sidebar Overlay -->
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 lg:hidden"
        x-cloak
    ></div>

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 z-40 w-72 max-w-[85vw] bg-primary-900 text-white flex flex-col shadow-2xl transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:max-w-none lg:shrink-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    >
        <!-- Logo Area -->
        <div class="px-5 sm:px-6 py-6 sm:py-8 border-b border-primary-800/50 flex items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SMK TI" class="w-11 h-11 sm:w-12 sm:h-12 object-contain shrink-0">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-xl font-bold tracking-tight text-white">MUTU</h1>
                <p class="text-xs font-medium text-primary-200 truncate">Admin Mutu</p>
            </div>
            <!-- Close button (mobile only) -->
            <button
                @click="sidebarOpen = false"
                class="ml-auto lg:hidden p-2 text-primary-200 hover:text-white hover:bg-primary-800/50 rounded-lg transition-colors"
                aria-label="Tutup menu"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 sm:px-4 py-5 sm:py-6 space-y-1 sm:space-y-2 overflow-y-auto">
            
            <a href="{{ url('/admin/dashboard') }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors font-medium {{ request()->is('admin/dashboard') ? 'bg-primary-800 text-white shadow-inner' : 'text-primary-100 hover:bg-primary-800/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                </svg>
                Riwayat Tamu
            </a>

            <a href="{{ url('/admin/settings') }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors font-medium {{ request()->is('admin/settings') ? 'bg-primary-800 text-white shadow-inner' : 'text-primary-100 hover:bg-primary-800/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Pengaturan Form
            </a>

        </nav>

        <!-- Logout -->
        <div class="p-3 sm:p-4 border-t border-primary-800/50 safe-area-bottom">
            <a href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-danger-300 hover:text-white hover:bg-danger-600 transition-colors font-medium group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 shrink-0 transform group-hover:-translate-x-1 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>
                Keluar
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-h-screen lg:h-screen lg:overflow-hidden w-full min-w-0">

        <!-- Top Header -->
        <header class="bg-white min-h-16 sm:h-20 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-3 border-b border-slate-200 shrink-0 shadow-sm z-10 safe-area-top">
            <div class="flex items-center gap-3 min-w-0">
                <!-- Hamburger (mobile) -->
                <button
                    @click="sidebarOpen = true"
                    class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors shrink-0"
                    aria-label="Buka menu"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <h2 class="text-base sm:text-xl font-bold text-slate-800 tracking-tight truncate">@yield('header_title', 'Dashboard')</h2>
            </div>

            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <div class="hidden sm:flex flex-col items-end">
                    <span class="text-sm font-bold text-slate-800">Administrator</span>
                    <span class="text-xs text-slate-500 font-medium">SMK TI MUHAMMADIYAH CIKAMPEK</span>
                </div>
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-200 border-2 border-primary-100 overflow-hidden flex items-center justify-center text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 relative">
            @yield('content')
        </div>

    </main>

</body>
</html>
