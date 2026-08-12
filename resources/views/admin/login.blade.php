{{-- resources/views/admin/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Login Admin - Mutu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        
        /* Animasi Shake untuk kredensial salah */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .shake-element {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen min-h-[100dvh] flex items-center justify-center font-sans antialiased relative overflow-x-hidden px-4 py-6 safe-area-top safe-area-bottom">
    
    <!-- Decorative Background Blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute w-[800px] h-[800px] bg-primary-100/50 rounded-full blur-3xl -top-40 -left-40"></div>
        <div class="absolute w-[600px] h-[600px] bg-sky-100/40 rounded-full blur-3xl bottom-0 right-0"></div>
    </div>

    <!-- Login Container -->
    <div 
        class="relative z-10 w-full max-w-md p-6 sm:p-8 lg:p-10 bg-white/80 backdrop-blur-xl border border-slate-100 rounded-2xl sm:rounded-3xl shadow-[0_10px_45px_rgb(0,0,0,0.04)]"
        x-data="{
            email: '',
            pin: '',
            showPin: false,
            isLoading: false,
            errorMessage: '',
            isErrorShake: false,
            
            async submitLogin() {
                if (!this.email || this.pin.length === 0) {
                    this.triggerError('Silakan masukkan email dan PIN terlebih dahulu.');
                    return;
                }
                
                this.isLoading = true;
                this.errorMessage = '';
                
                try {
                    const csrfMeta = document.querySelector('meta[name=\'csrf-token\']');
                    const csrfToken = csrfMeta ? csrfMeta.content : '';
                    
                    const response = await fetch('/admin/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ email: this.email, pin: this.pin })
                    });
                    
                    if (response.ok) {
                        // Redirect ke Dashboard setelah login sukses
                        window.location.href = '/admin/dashboard';
                    } else {
                        const data = await response.json();
                        this.triggerError(data.message || 'Email atau kata sandi yang Anda masukkan salah.');
                    }
                } catch (error) {
                    this.triggerError('Terjadi kesalahan koneksi. Silakan coba lagi.');
                } finally {
                    this.isLoading = false;
                }
            },
            
            triggerError(msg) {
                this.errorMessage = msg;
                this.isErrorShake = true;
                // Reset kata sandi input
                this.email = '';
                this.pin = '';
                // Hapus kelas shake setelah animasi selesai (500ms)
                setTimeout(() => {
                    this.isErrorShake = false;
                }, 500);
            }
        }"
    >
        
        <!-- Header -->
        <div class="flex flex-col items-center mb-8 text-center">
            <a href="{{ url('/') }}" class="mb-4 group flex items-center justify-center w-14 h-14 bg-primary-50 rounded-2xl border border-primary-100 hover:bg-primary-100 transition-colors" title="Kembali ke Beranda">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMK TI" class="w-10 h-10 object-contain group-hover:scale-110 transition-transform">
            </a>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Login Administrator</h2>
            <p class="text-slate-500 text-sm mt-1">Masukkan email dan kata sandi untuk mengakses Dashboard Mutu</p>
        </div>

        <!-- Form -->
        <form @submit.prevent="submitLogin()" :class="{ 'shake-element': isErrorShake }">
            <!-- Input Email -->
            <div class="mb-4">
                <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email Admin</label>
                <input
                    type="email"
                    id="email"
                    x-model="email"
                    autocomplete="email"
                    class="w-full px-5 py-4 rounded-2xl border-2 border-slate-200 outline-none focus:border-primary-500 text-base bg-slate-50 focus:bg-white transition-all"
                    placeholder="nama@contoh.com"
                    required
                    :disabled="isLoading"
                >
            </div>
            
            <!-- Input Kata Sandi -->
            <div class="mb-6 relative">
                <label for="pin" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kata Sandi</label>
                <div class="relative">
                    <input 
                        :type="showPin ? 'text' : 'password'" 
                        id="pin" 
                        x-model="pin"
                        class="w-full pl-5 pr-12 py-4 rounded-2xl border-2 border-slate-200 outline-none focus:border-primary-500 font-mono tracking-widest text-center text-xl bg-slate-50 focus:bg-white transition-all"
                        placeholder="••••••"
                        autocomplete="current-password"
                        required
                        :disabled="isLoading"
                    >
                    <!-- Toggle Show/Hide PIN -->
                    <button 
                        type="button"
                        @click="showPin = !showPin"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none"
                    >
                        <!-- Eye Icon -->
                        <svg x-show="!showPin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <!-- Eye Slash Icon -->
                        <svg x-show="showPin" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.822 7.822L21 21m-2.228-2.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full py-4 rounded-2xl font-bold text-white bg-primary-600 hover:bg-primary-700 transition-all focus:outline-none shadow-[0_6px_20px_rgb(37,99,235,0.25)] hover:shadow-[0_6px_20px_rgb(37,99,235,0.4)] flex items-center justify-center gap-2"
                :disabled="isLoading"
            >
                <span x-show="!isLoading">Masuk</span>
                <span x-show="isLoading" x-cloak>Memproses...</span>
                
                <!-- Spinner Animasi -->
                <svg x-show="isLoading" x-cloak class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V4a10 10 0 00-10 10h2zm2 5.291A7.962 7.962 0 014 12H2c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>

            <!-- Error Message -->
            <div class="h-6 mt-4 flex items-center justify-center">
                <p 
                    x-show="errorMessage" 
                    x-transition
                    x-cloak
                    class="text-sm font-semibold text-danger-500 text-center"
                    x-text="errorMessage"
                ></p>
            </div>
            
            <!-- Forgot PIN Button -->
            <div class="mt-2 text-center">
                <button type="button" @click="$dispatch('open-forgot-pin')" class="text-sm text-slate-500 hover:text-primary-600 font-bold transition-colors">
                    Lupa PIN?
                </button>
            </div>
        </form>
    </div>

    <!-- Forgot PIN Modal -->
    <div 
        x-data="{
            showModal: false,
            email: '',
            answer: '',
            newPassword: '',
            newPasswordConfirmation: '',
            isLoading: false,
            errorMsg: '',
            successMsg: '',
            question: '{{ $securityQuestion ?? '' }}',
            
            async submitForgotPin() {
                if (!this.answer) return;
                
                this.isLoading = true;
                this.errorMsg = '';
                this.successMsg = '';
                
                try {
                    const csrfMeta = document.querySelector('meta[name=\'csrf-token\']');
                    const response = await fetch('/admin/forgot-pin', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfMeta ? csrfMeta.content : ''
                        },
                        body: JSON.stringify({
                            email: this.email,
                            answer: this.answer,
                            new_password: this.newPassword,
                            new_password_confirmation: this.newPasswordConfirmation
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        this.successMsg = data.message;
                        setTimeout(() => window.location.href = '/admin/dashboard', 1500);
                    } else {
                        this.errorMsg = data.message || 'Jawaban salah.';
                    }
                } catch (error) {
                    this.errorMsg = 'Terjadi kesalahan koneksi.';
                } finally {
                    this.isLoading = false;
                }
            }
        }"
        @open-forgot-pin.window="showModal = true"
        x-show="showModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    >
        <div class="bg-white rounded-2xl border border-slate-100 shadow-2xl max-w-md w-full p-6 space-y-4" @click.outside="showModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h4 class="font-bold text-slate-800 text-lg">Lupa PIN Admin</h4>
                <button type="button" @click="showModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <template x-if="!question">
                <div class="p-4 bg-danger-50 text-danger-700 rounded-xl text-sm font-semibold border border-danger-100">
                    Fitur pemulihan PIN belum diatur. Silakan hubungi tim IT/Programmer untuk mengatur ulang PIN Anda.
                </div>
            </template>
            
            <template x-if="question">
                <form @submit.prevent="submitForgotPin()" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Admin <span class="text-danger-500">*</span></label>
                        <input type="email" x-model="email" autocomplete="email" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 mb-4" required :disabled="isLoading" placeholder="nama@contoh.com">

                        <label class="block text-xs font-bold text-slate-700 mb-2">Pertanyaan Keamanan:</label>
                        <p class="text-sm text-slate-800 font-medium mb-3 italic" x-text="question"></p>
                        
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jawaban Anda <span class="text-danger-500">*</span></label>
                        <input type="password" x-model="answer" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" required :disabled="isLoading" placeholder="Masukkan jawaban">

                        <label class="block text-xs font-bold text-slate-700 mb-1 mt-4">Password Baru <span class="text-danger-500">*</span></label>
                        <input type="password" x-model="newPassword" minlength="6" autocomplete="new-password" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" required :disabled="isLoading" placeholder="Minimal 6 karakter">

                        <label class="block text-xs font-bold text-slate-700 mb-1 mt-4">Ulangi Password Baru <span class="text-danger-500">*</span></label>
                        <input type="password" x-model="newPasswordConfirmation" minlength="6" autocomplete="new-password" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" required :disabled="isLoading" placeholder="Ulangi password baru">
                    </div>
                    
                    <p x-show="errorMsg" class="text-xs font-bold text-danger-500" x-text="errorMsg"></p>
                    <p x-show="successMsg" class="text-xs font-bold text-success-600" x-text="successMsg"></p>
                    
                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                        <button type="button" @click="showModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100" :disabled="isLoading">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-primary-600 hover:bg-primary-700 text-white shadow-sm flex items-center gap-2" :disabled="isLoading || !email || !answer || !newPassword || newPassword !== newPasswordConfirmation">
                            <span x-show="!isLoading">Verifikasi</span>
                            <span x-show="isLoading">Memproses...</span>
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</body>
</html>
