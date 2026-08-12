{{-- resources/views/guestbook/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>SMK TI Muhammadiyah Cikampek - Buku Tamu Digital</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        
        .ticker-wrap {
            overflow: hidden;
            white-space: nowrap;
        }
        .ticker-content {
            display: inline-block;
            animation: ticker 25s linear infinite;
        }
        @keyframes ticker {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
    </style>
</head>
<body 
    class="bg-white text-slate-900 font-sans antialiased min-h-screen min-h-[100dvh] flex flex-col relative"
    x-data="{ 
        currentTime: '',
        currentDate: '',
        
        init() {
            this.updateDateTime();
            setInterval(() => this.updateDateTime(), 1000);
        },
        
        updateDateTime() {
            const now = new Date();
            this.currentTime = now.toLocaleTimeString('id-ID', { 
                timeZone: 'Asia/Jakarta',
                hour: '2-digit', 
                minute: '2-digit',
                second: '2-digit'
            });
            const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            this.currentDate = `${formattedDate} - WIB`;
        }
    }"
>

    <!-- Header Section -->
    <header class="w-full px-4 sm:px-8 py-3.5 sm:py-4 bg-white shadow-sm border-b border-slate-200/80 z-30 shrink-0 sticky top-0 safe-area-top">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 w-full">
            
            <!-- Left: Logo & School Name -->
            <div class="flex items-center gap-3.5 sm:gap-4 min-w-0">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMK TI Muhammadiyah Cikampek" class="w-10 h-10 sm:w-12 sm:h-12 object-contain shrink-0 drop-shadow-xs">
                <div class="min-w-0 flex flex-col justify-center">
                    <span class="text-xs sm:text-sm font-bold tracking-wide text-slate-700 leading-snug uppercase">
                        SMK TI MUHAMMADIYAH
                    </span>
                    <h1 class="text-lg sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                        Buku Tamu Digital <span class="text-primary-600 font-extrabold">MUTU</span>
                    </h1>
                </div>
            </div>

            <!-- Right: Realtime Time & Date Badge -->
            <div class="flex items-center gap-2 sm:gap-4">
                <a href="{{ route('admin.login') }}" class="text-xs font-semibold text-slate-200 hover:text-primary-600 transition-colors select-none" title="Admin Login">Admin</a>
                <div class="flex flex-col items-end shrink-0 bg-slate-50 border border-slate-200/80 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl shadow-2xs">
                    <div class="text-sm sm:text-xl font-black text-primary-700 font-mono tracking-wider leading-none" x-text="currentTime"></div>
                    <div class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1" x-text="currentDate"></div>
                </div>
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col lg:flex-row items-stretch w-full">
        
        <!-- Left Side: Copywriting & CTA -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-5 sm:px-10 lg:px-16 xl:px-24 py-8 lg:py-0 order-2 lg:order-1">
            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-slate-600 mb-1 sm:mb-2">Selamat Datang di</h3>
            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-extrabold text-primary-600 leading-tight mb-6 sm:mb-8 tracking-tight">
                SMK TI MUHAMMADIYAH<br/>CIKAMPEK
            </h2>
            
            <p class="text-base sm:text-lg text-slate-600 mb-8 sm:mb-12 max-w-md font-medium leading-relaxed">
                Silakan isi buku tamu sebagai bukti kunjungan Anda.
            </p>
            
            <a 
                href="{{ url('/form') }}"
                class="group inline-flex items-center gap-4 sm:gap-5 px-6 sm:px-8 py-4 sm:py-5 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-2xl shadow-[0_8px_30px_rgb(37,99,235,0.25)] hover:shadow-[0_8px_30px_rgb(37,99,235,0.4)] transition-all duration-300 transform hover:-translate-y-1 focus:ring-4 focus:ring-primary-200 outline-none w-full sm:w-fit"
            >
                <div class="bg-white/20 p-2.5 sm:p-3 rounded-xl group-hover:scale-110 transition-transform duration-300 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 sm:w-7 sm:h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </div>
                <div class="flex flex-col text-left min-w-0">
                    <span class="text-lg sm:text-2xl font-bold tracking-wide">Isi Buku Tamu</span>
                    <span class="text-xs sm:text-sm text-primary-100 font-medium opacity-90">Sentuh untuk memulai</span>
                </div>
            </a>
            
            <!-- Credits -->
            <div class="mt-12 text-[10px] sm:text-xs text-slate-300 opacity-50 font-medium tracking-wide" style="font-family: 'Book Antiqua', Palatino, serif;">
                Created by Reza, Dhafi & Issma
            </div>
        </div>

        <!-- Right Side: Illustration -->
        <div class="w-full lg:w-1/2 bg-primary-50 relative overflow-hidden min-h-[280px] sm:min-h-[360px] lg:min-h-[520px] order-1 lg:order-2">
            <div class="absolute w-[300px] sm:w-[450px] lg:w-[600px] h-[300px] sm:h-[450px] lg:h-[600px] bg-primary-100/50 rounded-full blur-3xl -top-16 -right-12"></div>
            <div class="absolute w-[220px] sm:w-[340px] lg:w-[500px] h-[220px] sm:h-[340px] lg:h-[500px] bg-sky-200/40 rounded-full blur-3xl bottom-0 left-0"></div>
            
            <img 
                src="{{ asset('images/banner_mutu.png') }}" 
                alt="Banner MUTU" 
                class="relative z-10 w-full h-full object-cover drop-shadow-2xl"
            />
        </div>
        
    </main>

    <!-- Footer: Ticker Pengumuman -->
    <footer class="w-full bg-primary-50 text-primary-800 py-2.5 sm:py-3 px-4 sm:px-6 flex items-center gap-3 sm:gap-4 shrink-0 border-t border-primary-100 safe-area-bottom">
        <div class="flex items-center gap-1.5 sm:gap-2 font-bold shrink-0 z-10 bg-primary-50 pr-2 sm:pr-4 text-xs sm:text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
            </svg>
            <span class="hidden sm:inline">Pengumuman:</span>
        </div>
        
        <div class="ticker-wrap w-full flex-1 min-w-0">
            <div class="ticker-content text-xs sm:text-sm font-medium">
                Selamat datang di SMK TI MUHAMMADIYAH CIKAMPEK. Terima kasih atas kunjungan Anda. Harap mematuhi tata tertib sekolah selama berada di lingkungan sekolah.
            </div>
        </div>
    </footer>



</body>
</html>
