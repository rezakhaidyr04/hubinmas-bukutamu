{{-- resources/views/guestbook/form-step3.blade.php --}}
<div class="p-4 sm:p-6 lg:p-8">
    <div class="mb-6 sm:mb-8 text-center md:text-left">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight mb-1">Konfirmasi Data</h2>
        <p class="text-slate-500 text-sm">Periksa kembali data Anda sebelum menyimpan kehadiran.</p>
    </div>

    <!-- Kotak Ringkasan Data -->
    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
            
            <div class="flex flex-col border-b md:border-b-0 border-slate-200 pb-3 md:pb-0">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori Tamu</span>
                <div class="flex items-center gap-2">
                    <!-- Icon badge berdasarkan kategori -->
                    <template x-if="form.kategori === 'Orang Tua / Wali'">
                        <span class="w-5 h-5 rounded flex items-center justify-center bg-sky-100 text-sky-600"><svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg></span>
                    </template>
                    <template x-if="form.kategori === 'Dinas / Instansi'">
                        <span class="w-5 h-5 rounded flex items-center justify-center bg-blue-100 text-blue-700"><svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg></span>
                    </template>
                    <template x-if="form.kategori === 'Umum'">
                        <span class="w-5 h-5 rounded flex items-center justify-center bg-slate-200 text-slate-700"><svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg></span>
                    </template>
                    <template x-if="form.kategori === 'Mahasiswa'">
                        <span class="w-5 h-5 rounded flex items-center justify-center bg-purple-100 text-purple-600"><svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" /></svg></span>
                    </template>
                    <template x-if="!['Orang Tua / Wali', 'Dinas / Instansi', 'Umum', 'Mahasiswa'].includes(form.kategori)">
                        <span class="w-5 h-5 rounded flex items-center justify-center bg-primary-100 text-primary-600"><svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg></span>
                    </template>
                    <span class="font-semibold text-slate-800" x-text="form.kategori"></span>
                </div>
            </div>

            <div class="flex flex-col border-b border-slate-200 pb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</span>
                <span class="font-semibold text-slate-800 truncate" x-text="form.nama_lengkap"></span>
            </div>

            <div class="flex flex-col border-b border-slate-200 pb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Asal Instansi / Alamat</span>
                <span class="font-semibold text-slate-800 truncate" x-text="form.asal_instansi"></span>
            </div>

            <div class="flex flex-col border-b border-slate-200 pb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tujuan / Bertemu</span>
                <span class="font-semibold text-slate-800 truncate" x-text="form.tujuan_bertemu"></span>
            </div>

            <div class="flex flex-col border-b md:border-b-0 border-slate-200 pb-3 md:pb-0 md:col-span-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Keperluan</span>
                <span class="font-semibold text-slate-800" x-text="form.keperluan"></span>
            </div>

            <div class="flex flex-col border-b md:border-b-0 border-slate-200 pb-3 md:pb-0">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">No. Telepon / WhatsApp</span>
                <span class="font-semibold text-slate-800 truncate" x-text="form.no_telepon || '-'"></span>
            </div>

            <div class="flex flex-col">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email</span>
                <span class="font-semibold text-slate-800 truncate" x-text="form.email || '-'"></span>
            </div>
            
        </div>
    </div>

    <!-- Tombol Submit -->
    <div class="border-t border-slate-100 pt-6 mt-6 flex flex-col-reverse md:flex-row gap-4">
        <button 
            type="button" 
            @click="prevStep()"
            class="w-full md:w-1/3 py-3.5 rounded-xl font-bold text-slate-600 bg-white border-2 border-slate-200 hover:bg-slate-50 hover:text-slate-800 transition-all flex justify-center items-center gap-2"
            :disabled="isLoading"
        >
            Kembali
        </button>
        <button 
            type="button" 
            @click="submitForm()"
            class="w-full md:w-2/3 py-3.5 rounded-xl font-bold text-white bg-primary-600 hover:bg-primary-700 shadow-[0_4px_15px_rgb(37,99,235,0.2)] transform hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2"
            :disabled="isLoading"
        >
            <svg x-show="!isLoading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span x-show="!isLoading">Simpan Kehadiran</span>

            <!-- Spinner -->
            <svg x-show="isLoading" x-cloak class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V4a10 10 0 00-10 10h2zm2 5.291A7.962 7.962 0 014 12H2c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span x-show="isLoading" x-cloak>Menyimpan...</span>
        </button>
    </div>
</div>
