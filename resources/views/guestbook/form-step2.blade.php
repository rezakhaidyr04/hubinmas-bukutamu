{{-- resources/views/guestbook/form-step2.blade.php --}}
<div class="p-4 sm:p-6 lg:p-8">
    <div class="mb-6 sm:mb-8">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight mb-1">Data Diri</h2>
        <p class="text-slate-500 text-sm">Mohon lengkapi data di bawah ini dengan benar.</p>
    </div>

    <div class="space-y-6">
        
        <!-- Grid 2 Kolom -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Nama Lengkap <span class="text-danger-500">*</span>
                </label>
                <input 
                    type="text" 
                    x-model="form.nama_lengkap"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white"
                    placeholder="Masukkan nama lengkap Anda"
                    required
                >
            </div>

            <!-- Asal Instansi -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Asal Instansi / Alamat <span class="text-danger-500">*</span>
                </label>
                <input 
                    type="text" 
                    x-model="form.asal_instansi"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white"
                    placeholder="Contoh: PT. Maju Bersama / Jl. Merdeka No. 10"
                    required
                >
            </div>

            <!-- Tujuan / Bertemu -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Tujuan / Bertemu <span class="text-danger-500">*</span>
                </label>
                <select 
                    x-model="form.tujuan_bertemu"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white appearance-none"
                    required
                >
                    <option value="" disabled selected>Pilih tujuan / pihak yang dituju</option>
                    @foreach($tujuanOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Keperluan -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Keperluan <span class="text-danger-500">*</span>
                </label>
                <input 
                    type="text" 
                    x-model="form.keperluan"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white"
                    placeholder="Jelaskan secara singkat keperluan Anda"
                    required
                >
            </div>

        </div>

        <hr class="border-slate-100 my-4">

        <!-- Pertanyaan Tambahan Section -->
        <div>
            <h3 class="text-lg font-bold text-slate-800 mb-4">Informasi Kontak Tambahan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- No. Telepon -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        No. Telepon / WhatsApp <span class="text-danger-500" x-show="config.requirePhone === '1'">*</span>
                    </label>
                    <input 
                        type="tel" 
                        x-model="form.no_telepon"
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white"
                        placeholder="Contoh: 081234567890"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Email <span class="text-danger-500" x-show="config.requireEmail === '1'">*</span> <span class="text-slate-400 font-normal" x-show="config.requireEmail !== '1'">(Optional)</span>
                    </label>
                    <input 
                        type="email" 
                        x-model="form.email"
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white"
                        placeholder="nama@email.com"
                    >
                </div>
            </div>
        </div>

        <!-- Dynamic Custom Questions (Jika Ada) -->
        <template x-if="config.customQuestions && config.customQuestions.length > 0">
            <div class="mt-6 border-t border-slate-100 pt-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Pertanyaan Tambahan Lainnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <template x-for="(cq, index) in config.customQuestions" :key="index">
                        <div :class="cq.type === 'textarea' ? 'md:col-span-2' : ''">
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                <span x-text="cq.label"></span>
                                <span class="text-danger-500" x-show="cq.required">*</span>
                                <span class="text-slate-400 font-normal" x-show="!cq.required">(Optional)</span>
                            </label>

                            <!-- Tipe Text Input -->
                            <template x-if="cq.type === 'text' || !cq.type">
                                <input 
                                    type="text" 
                                    x-model="form.custom_answers[cq.label]"
                                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white"
                                    :placeholder="cq.placeholder || ('Masukkan ' + cq.label)"
                                >
                            </template>

                            <!-- Tipe Number Input -->
                            <template x-if="cq.type === 'number'">
                                <input 
                                    type="number" 
                                    x-model="form.custom_answers[cq.label]"
                                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white"
                                    :placeholder="cq.placeholder || ('Masukkan ' + cq.label)"
                                >
                            </template>

                            <!-- Tipe Textarea -->
                            <template x-if="cq.type === 'textarea'">
                                <textarea 
                                    x-model="form.custom_answers[cq.label]"
                                    rows="3"
                                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white"
                                    :placeholder="cq.placeholder || ('Masukkan ' + cq.label)"
                                ></textarea>
                            </template>

                            <!-- Tipe Dropdown Select -->
                            <template x-if="cq.type === 'select'">
                                <select 
                                    x-model="form.custom_answers[cq.label]"
                                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all text-slate-800 bg-slate-50 focus:bg-white appearance-none"
                                >
                                    <option value="" disabled selected x-text="'Pilih ' + cq.label"></option>
                                    <template x-for="opt in (cq.options ? cq.options.split(',') : [])" :key="opt.trim()">
                                        <option :value="opt.trim()" x-text="opt.trim()"></option>
                                    </template>
                                </select>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </template>
        
    </div>

    <!-- Tombol Navigasi -->
    <div class="border-t border-slate-100 pt-6 mt-8 flex flex-col-reverse md:flex-row gap-4">
        <button 
            type="button" 
            @click="prevStep()"
            class="w-full md:w-1/3 py-3.5 rounded-xl font-bold text-slate-600 bg-white border-2 border-slate-200 hover:bg-slate-50 hover:text-slate-800 transition-all flex justify-center items-center gap-2"
        >
            Batal
        </button>
        <button 
            type="button" 
            @click="nextStep()"
            class="w-full md:w-2/3 py-3.5 rounded-xl font-bold text-white bg-primary-600 hover:bg-primary-700 shadow-md transform hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2"
        >
            <span>Selanjutnya</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>
    </div>
</div>
