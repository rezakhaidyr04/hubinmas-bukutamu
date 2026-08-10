{{-- resources/views/guestbook/success.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Sukses - Mutu</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body 
    class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen min-h-[100dvh] flex items-center justify-center relative overflow-x-hidden px-4 py-6 safe-area-top safe-area-bottom"
    x-data="{ 
        countdown: 5,
        init() {
            setTimeout(() => this.$el.classList.add('opacity-100'), 50);
            
            const timer = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) {
                    clearInterval(timer);
                    window.location.href = '{{ url('/') }}';
                }
            }, 1000);
        }
    }"
>
    <!-- Efek Latar Belakang -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute w-[300px] sm:w-[600px] h-[300px] sm:h-[600px] bg-success-100/50 rounded-full blur-3xl top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
    </div>

    <!-- Kotak Sukses -->
    <div class="relative z-10 w-full max-w-xl p-6 sm:p-8 lg:p-10 bg-white/80 backdrop-blur-xl border border-white rounded-2xl sm:rounded-3xl shadow-[0_10px_40px_rgb(0,0,0,0.05)] text-center transition-opacity duration-700 opacity-0" id="successCard">
        
        <!-- Ikon Centang -->
        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-[#48BB78] rounded-full flex items-center justify-center text-white mx-auto mb-5 sm:mb-6 shadow-lg animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-12 h-12 sm:w-16 sm:h-16">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>

        <h1 class="text-2xl sm:text-4xl font-extrabold text-[#2F855A] mb-2">Terima Kasih!</h1>
        <p class="text-base sm:text-lg text-slate-500 font-medium mb-6 sm:mb-8">Kehadiran Anda telah berhasil dicatat.</p>

        <!-- ID Kunjungan -->
        <p class="text-xs sm:text-sm font-bold text-slate-500 mb-2">ID Kunjungan Anda</p>
        <div class="bg-white border-2 border-[#68D391] rounded-xl sm:rounded-2xl p-3 sm:p-4 mb-6 sm:mb-8 max-w-sm mx-auto">
            <p class="text-xl sm:text-3xl font-black text-[#2F855A] font-mono tracking-wider break-all">
                {{ request()->query('id', 'TM-'.date('Ymd').'-'.rand(1000,9999)) }}
            </p>
        </div>

        <!-- Ikon Pengganti QR Code -->
        <div class="flex justify-center mb-6 sm:mb-10">
            <div class="p-2 bg-slate-50 text-slate-400 rounded-2xl border border-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 sm:w-24 sm:h-24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                </svg>
            </div>
        </div>

        <!-- Countdown -->
        <p class="text-xs sm:text-sm font-medium text-slate-500">
            Halaman akan kembali ke beranda dalam <span class="font-bold text-slate-700 text-sm sm:text-base" x-text="countdown">5</span> detik
        </p>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.getElementById('successCard').classList.remove('opacity-0');
            }, 100);
        });
    </script>
</body>
</html>
