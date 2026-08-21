{{-- resources/views/guestbook/form.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, maximum-scale=1.0, user-scalable=0">
    <title>Form Kunjungan - Mutu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.2.0/dist/signature_pad.umd.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        #signature-canvas {
            touch-action: none;
            cursor: crosshair;
        }
    </style>
</head>
<body 
    class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen min-h-[100dvh] flex flex-col relative"
    x-data="guestForm({ requirePhone: '{{ $requirePhone }}', requireEmail: '{{ $requireEmail }}', customQuestions: {{ json_encode($customQuestions ?? []) }} })"
>

    <!-- Header Sederhana -->
    <header class="w-full px-4 sm:px-8 py-3.5 sm:py-4 bg-white shadow-sm border-b border-slate-200/80 flex items-center justify-between z-30 sticky top-0 safe-area-top">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 w-full">
            <div class="flex items-center gap-3.5 sm:gap-4 min-w-0">
                <a href="{{ url('/') }}" class="p-2 text-slate-600 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all shrink-0 border border-slate-200/80 hover:border-primary-200 shadow-2xs">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMK TI" class="w-9 h-9 sm:w-11 sm:h-11 object-contain shrink-0 drop-shadow-xs">
                <div class="min-w-0 flex flex-col justify-center">
                    <h1 class="text-sm sm:text-lg font-black tracking-wide text-slate-900 leading-snug truncate">Form Buku Tamu Digital</h1>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mt-0.5 tracking-wider">
                        <span>SMK TI MUHAMMADIYAH CIKAMPEK</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 flex flex-col items-center py-5 sm:py-8 px-3 sm:px-4 lg:px-8 w-full max-w-4xl mx-auto safe-area-bottom">
        
        <!-- Modal Pop-Up Peringatan / Error -->
        <div 
            x-show="errorMessage" 
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            x-cloak
        >
            <div 
                class="bg-white rounded-3xl p-6 sm:p-8 max-w-sm w-full text-center shadow-2xl border border-slate-100 relative"
                @click.outside="errorMessage = ''"
            >
                <!-- Icon Warning Badge -->
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-red-100/60 shadow-xs" style="background-color: #fef2f2; color: #ef4444;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-9 h-9 sm:w-10 sm:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>

                <!-- Title -->
                <h3 class="text-lg sm:text-xl font-extrabold text-slate-800 mb-2">Data Belum Lengkap</h3>

                <!-- Error Message Text -->
                <p class="text-sm font-medium text-slate-600 mb-6 leading-relaxed" x-text="errorMessage"></p>

                <!-- Action Button -->
                <button 
                    type="button" 
                    @click="errorMessage = ''"
                    style="background-color: #dc2626; color: #ffffff;"
                    class="w-full py-3.5 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white rounded-xl font-bold text-base shadow-md shadow-red-200 transition-all transform hover:-translate-y-0.5 cursor-pointer"
                >
                    Saya Mengerti
                </button>
            </div>
        </div>

        <!-- Stepper Indicator -->
        <div class="w-full mb-6 sm:mb-10 px-1">
            <div class="flex items-center justify-between relative z-0 before:absolute before:inset-0 before:top-1/2 before:-translate-y-1/2 before:h-0.5 before:w-full before:bg-slate-200 before:-z-10">
                
                <!-- Step 1 Indicator -->
                <div class="flex flex-col items-center gap-1 sm:gap-2 bg-slate-50 px-1 sm:px-2 relative">
                    <div 
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm transition-colors duration-300 border-2"
                        :class="step >= 1 ? 'bg-primary-600 text-white border-primary-600 shadow-md' : 'bg-white text-slate-400 border-slate-200'"
                    >
                        <svg x-show="step > 1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        <span x-show="step === 1">1</span>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-center leading-tight max-w-[72px] sm:max-w-none" :class="step >= 1 ? 'text-primary-700' : 'text-slate-400'">Kategori Tamu</span>
                </div>

                <!-- Step 2 Indicator -->
                <div class="flex flex-col items-center gap-1 sm:gap-2 bg-slate-50 px-1 sm:px-2 relative">
                    <div 
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm transition-colors duration-300 border-2"
                        :class="step >= 2 ? 'bg-primary-600 text-white border-primary-600 shadow-md' : 'bg-white text-slate-400 border-slate-200'"
                    >
                        <svg x-show="step > 2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        <span x-show="step <= 2">2</span>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-center leading-tight max-w-[72px] sm:max-w-none" :class="step >= 2 ? 'text-primary-700' : 'text-slate-400'">Data Diri</span>
                </div>

                <!-- Step 3 Indicator -->
                <div class="flex flex-col items-center gap-1 sm:gap-2 bg-slate-50 px-1 sm:px-2 relative">
                    <div 
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm transition-colors duration-300 border-2"
                        :class="step === 3 ? 'bg-primary-600 text-white border-primary-600 shadow-md' : 'bg-white text-slate-400 border-slate-200'"
                    >
                        <span>3</span>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-center leading-tight max-w-[72px] sm:max-w-none" :class="step === 3 ? 'text-primary-700' : 'text-slate-400'">Konfirmasi</span>
                </div>

            </div>
        </div>

        <!-- Form Cards Container -->
        <div class="w-full bg-white rounded-xl sm:rounded-card shadow-soft border border-slate-100 overflow-hidden relative min-h-[420px] sm:min-h-[480px]">
            
            <!-- Step 1 View -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200 absolute inset-0" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4">
                @include('guestbook.form-step1')
            </div>
            
            <!-- Step 2 View -->
            <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200 absolute inset-0" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4">
                @include('guestbook.form-step2')
            </div>
            
            <!-- Step 3 View -->
            <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200 absolute inset-0" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4">
                @include('guestbook.form-step3')
            </div>
            
        </div>
        
    </main>
</body>
</html>
