{{-- resources/views/admin/settings.blade.php --}}
@extends('layouts.admin')

@section('header_title', 'Pengaturan Form')

@section('content')
    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-success-50 text-success-700 border border-success-200 rounded-xl text-sm font-semibold flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert Error / Validation -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-danger-50 text-danger-700 border border-danger-200 rounded-xl text-sm font-semibold flex flex-col gap-1 shadow-sm">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Mohon koreksi kesalahan berikut:</span>
            </div>
            <ul class="list-disc list-inside pl-9 text-xs mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST"
        data-categories="{{ json_encode($categories) }}"
        data-tujuan="{{ json_encode($tujuanOptions) }}"
        data-custom="{{ json_encode($customQuestions) }}"
        class="bg-white rounded-2xl border border-slate-100 shadow-soft overflow-hidden" 
        x-data="{ 
        activeTab: 'kategori',
        requirePhone: {{ $requirePhone == '1' ? 'true' : 'false' }},
        requireEmail: {{ $requireEmail == '1' ? 'true' : 'false' }},
        categories: JSON.parse($el.dataset.categories || '[]'),
        tujuanOptions: JSON.parse($el.dataset.tujuan || '[]'),
        customQuestions: JSON.parse($el.dataset.custom || '[]'),

        // Category Modal State
        showCategoryModal: false,
        editingCategoryIndex: null,
        categoryForm: { name: '', description: '' },

        // Tujuan Modal State
        showTujuanModal: false,
        editingTujuanIndex: null,
        tujuanForm: '',

        // Custom Question Modal State
        showCustomModal: false,
        editingCustomIndex: null,
        customForm: { label: '', type: 'text', required: false, placeholder: '', options: '' },

        openAddCategory() {
            this.editingCategoryIndex = null;
            this.categoryForm = { name: '', description: '' };
            this.showCategoryModal = true;
        },
        openEditCategory(index) {
            this.editingCategoryIndex = index;
            this.categoryForm = { name: this.categories[index].name || '', description: this.categories[index].description || '' };
            this.showCategoryModal = true;
        },
        saveCategory() {
            if (!this.categoryForm.name.trim()) return;
            if (this.editingCategoryIndex !== null) {
                this.categories[this.editingCategoryIndex] = {
                    name: this.categoryForm.name.trim(),
                    description: this.categoryForm.description.trim()
                };
            } else {
                this.categories.push({
                    name: this.categoryForm.name.trim(),
                    description: this.categoryForm.description.trim()
                });
            }
            this.showCategoryModal = false;
        },
        deleteCategory(index) {
            if (this.categories.length <= 1) {
                alert('Minimal harus ada 1 kategori tamu.');
                return;
            }
            if (confirm('Apakah Anda yakin ingin menghapus kategori ' + this.categories[index].name + '?')) {
                this.categories.splice(index, 1);
            }
        },

        openAddTujuan() {
            this.editingTujuanIndex = null;
            this.tujuanForm = '';
            this.showTujuanModal = true;
        },
        openEditTujuan(index) {
            this.editingTujuanIndex = index;
            this.tujuanForm = this.tujuanOptions[index];
            this.showTujuanModal = true;
        },
        saveTujuan() {
            if (!this.tujuanForm.trim()) return;
            if (this.editingTujuanIndex !== null) {
                this.tujuanOptions[this.editingTujuanIndex] = this.tujuanForm.trim();
            } else {
                this.tujuanOptions.push(this.tujuanForm.trim());
            }
            this.showTujuanModal = false;
        },
        deleteTujuan(index) {
            if (this.tujuanOptions.length <= 1) {
                alert('Minimal harus ada 1 opsi tujuan.');
                return;
            }
            if (confirm('Apakah Anda yakin ingin menghapus opsi tujuan ini?')) {
                this.tujuanOptions.splice(index, 1);
            }
        },

        openAddCustom() {
            this.editingCustomIndex = null;
            this.customForm = { label: '', type: 'text', required: false, placeholder: '', options: '' };
            this.showCustomModal = true;
        },
        openEditCustom(index) {
            this.editingCustomIndex = index;
            const item = this.customQuestions[index];
            this.customForm = {
                label: item.label || '',
                type: item.type || 'text',
                required: !!item.required,
                placeholder: item.placeholder || '',
                options: item.options || ''
            };
            this.showCustomModal = true;
        },
        saveCustom() {
            if (!this.customForm.label.trim()) return;
            const item = {
                label: this.customForm.label.trim(),
                type: this.customForm.type,
                required: this.customForm.required,
                placeholder: this.customForm.placeholder.trim(),
                options: this.customForm.options.trim()
            };
            if (this.editingCustomIndex !== null) {
                this.customQuestions[this.editingCustomIndex] = item;
            } else {
                this.customQuestions.push(item);
            }
            this.showCustomModal = false;
        },
        deleteCustom(index) {
            if (confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')) {
                this.customQuestions.splice(index, 1);
            }
        }
    }">
        @csrf
        <input type="hidden" name="categories" :value="JSON.stringify(categories)">
        <input type="hidden" name="tujuan_options" :value="JSON.stringify(tujuanOptions)">
        <input type="hidden" name="custom_questions" :value="JSON.stringify(customQuestions)">
        
        <!-- Tabs Header -->
        <div class="flex border-b border-slate-100 px-4 sm:px-6 pt-3 sm:pt-4 gap-4 sm:gap-8 overflow-x-auto whitespace-nowrap">
            <button type="button" @click="activeTab = 'kategori'" class="pb-3 text-sm font-bold border-b-2 transition-colors focus:outline-none" :class="activeTab === 'kategori' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent hover:text-slate-600'">
                Kategori Tamu
            </button>
            <button type="button" @click="activeTab = 'tujuan'" class="pb-3 text-sm font-bold border-b-2 transition-colors focus:outline-none" :class="activeTab === 'tujuan' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent hover:text-slate-600'">
                Tujuan / Bertemu
            </button>
            <button type="button" @click="activeTab = 'pertanyaan'" class="pb-3 text-sm font-bold border-b-2 transition-colors focus:outline-none" :class="activeTab === 'pertanyaan' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent hover:text-slate-600'">
                Pertanyaan Tambahan
            </button>
            <button type="button" @click="activeTab = 'keamanan'" class="pb-3 text-sm font-bold border-b-2 transition-colors focus:outline-none" :class="activeTab === 'keamanan' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent hover:text-slate-600'">
                Keamanan & PIN
            </button>
        </div>

        <!-- Tab Content -->
        <div class="p-4 sm:p-6 lg:p-8 min-h-[300px]">
            
            <!-- Tab: Kategori Tamu -->
            <div x-show="activeTab === 'kategori'" x-cloak class="flex flex-col lg:flex-row gap-10">
                <div class="w-full lg:w-1/3">
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Kategori Tamu</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-4">
                        Kelola kategori tamu yang tersedia pada halaman pengisian buku tamu. Anda dapat menambah, mengedit, atau menghapus kategori.
                    </p>
                    <button type="button" @click="openAddCategory()" class="px-4 py-2.5 bg-primary-50 text-primary-700 hover:bg-primary-100 rounded-xl text-xs font-bold transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Kategori Baru
                    </button>
                </div>
                <div class="w-full lg:w-2/3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="(cat, index) in categories" :key="index">
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-start justify-between gap-3 relative group hover:border-slate-200 transition-all">
                                <div class="flex items-start gap-3 min-w-0">
                                    <div class="w-10 h-10 bg-primary-100 text-primary-700 rounded-xl flex items-center justify-center font-bold shrink-0 text-sm" x-text="index + 1"></div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-800 text-sm truncate" x-text="cat.name"></h4>
                                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-2" x-text="cat.description || 'Tidak ada deskripsi'"></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 shrink-0">
                                    <button type="button" @click="openEditCategory(index)" class="p-1.5 text-slate-400 hover:text-primary-600 hover:bg-white rounded-lg transition-colors" title="Edit Kategori">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="deleteCategory(index)" class="p-1.5 text-slate-400 hover:text-danger-600 hover:bg-white rounded-lg transition-colors" title="Hapus Kategori">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Tab: Tujuan / Bertemu -->
            <div x-show="activeTab === 'tujuan'" x-cloak class="flex flex-col lg:flex-row gap-10">
                <div class="w-full lg:w-1/3">
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Tujuan / Bertemu</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-4">
                        Kelola opsi tujuan atau pihak sekolah yang dapat dipilih oleh tamu saat mengisi formulir.
                    </p>
                    <button type="button" @click="openAddTujuan()" class="px-4 py-2.5 bg-primary-50 text-primary-700 hover:bg-primary-100 rounded-xl text-xs font-bold transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Tujuan Baru
                    </button>
                </div>
                <div class="w-full lg:w-2/3">
                    <div class="bg-slate-50 rounded-2xl border border-slate-100 divide-y divide-slate-100 overflow-hidden">
                        <template x-for="(tujuan, index) in tujuanOptions" :key="index">
                            <div class="p-4 bg-white flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center text-xs font-bold" x-text="index + 1"></span>
                                    <span class="font-bold text-slate-700 text-sm" x-text="tujuan"></span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <button type="button" @click="openEditTujuan(index)" class="p-1.5 text-slate-400 hover:text-primary-600 hover:bg-slate-100 rounded-lg transition-colors" title="Edit Tujuan">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="deleteTujuan(index)" class="p-1.5 text-slate-400 hover:text-danger-600 hover:bg-slate-100 rounded-lg transition-colors" title="Hapus Tujuan">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            
            <!-- Tab: Pertanyaan Tambahan -->
            <div x-show="activeTab === 'pertanyaan'" class="flex flex-col lg:flex-row gap-10">
                
                <!-- Left Info -->
                <div class="w-full lg:w-1/3">
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Pertanyaan Tambahan</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-4">
                        Kelola pertanyaan tambahan yang akan ditampilkan di form kunjungan. Anda dapat menambah pertanyaan baru (misal: Nopol Kendaraan, Nama Anak, dll) serta mewajibkan atau menonaktifkan input ini secara dinamis.
                    </p>
                    <button type="button" @click="openAddCustom()" class="px-4 py-2.5 bg-primary-50 text-primary-700 hover:bg-primary-100 rounded-xl text-xs font-bold transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Pertanyaan Baru
                    </button>
                </div>

                <!-- Right Configuration List -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-slate-50 rounded-xl border border-slate-100 overflow-hidden divide-y divide-slate-100">
                        
                        <!-- Item 1: No. Telepon -->
                        <div class="p-3 sm:p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-slate-700 text-sm">No. Telepon / WhatsApp</span>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-4 sm:gap-6">
                                <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-md">Teks Pendek</span>
                                
                                <!-- Toggle -->
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="require_phone" x-model="requirePhone" class="hidden">
                                    <button type="button" 
                                        @click="requirePhone = !requirePhone"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2"
                                        :class="requirePhone ? 'bg-primary-600' : 'bg-slate-200'"
                                    >
                                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                            :class="requirePhone ? 'translate-x-5' : 'translate-x-0'"
                                        ></span>
                                    </button>
                                    <span class="text-xs font-bold w-16" :class="requirePhone ? 'text-primary-700' : 'text-slate-400'" x-text="requirePhone ? 'Wajib' : 'Tdk Wajib'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Item 2: Email -->
                        <div class="p-3 sm:p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-slate-700 text-sm">Email (Jika ada)</span>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-4 sm:gap-6">
                                <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-md">Teks Pendek</span>
                                
                                <!-- Toggle -->
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="require_email" x-model="requireEmail" class="hidden">
                                    <button type="button" 
                                        @click="requireEmail = !requireEmail"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2"
                                        :class="requireEmail ? 'bg-primary-600' : 'bg-slate-200'"
                                    >
                                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                            :class="requireEmail ? 'translate-x-5' : 'translate-x-0'"
                                        ></span>
                                    </button>
                                    <span class="text-xs font-bold w-16" :class="requireEmail ? 'text-primary-700' : 'text-slate-400'" x-text="requireEmail ? 'Wajib' : 'Tdk Wajib'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Dynamic Questions List -->
                        <template x-for="(cq, index) in customQuestions" :key="index">
                            <div class="p-3 sm:p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-slate-800 text-sm" x-text="cq.label"></span>
                                </div>
                                <div class="flex items-center justify-between sm:justify-end gap-3 sm:gap-4">
                                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md" 
                                          x-text="cq.type === 'number' ? 'Angka' : (cq.type === 'textarea' ? 'Teks Panjang' : (cq.type === 'select' ? 'Dropdown' : 'Teks Pendek'))">
                                    </span>
                                    
                                    <!-- Toggle Wajib -->
                                    <div class="flex items-center gap-2">
                                        <button type="button" 
                                            @click="cq.required = !cq.required"
                                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2"
                                            :class="cq.required ? 'bg-primary-600' : 'bg-slate-200'"
                                        >
                                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                :class="cq.required ? 'translate-x-5' : 'translate-x-0'"
                                            ></span>
                                        </button>
                                        <span class="text-xs font-bold w-14" :class="cq.required ? 'text-primary-700' : 'text-slate-400'" x-text="cq.required ? 'Wajib' : 'Tdk Wajib'"></span>
                                    </div>

                                    <!-- Action buttons -->
                                    <div class="flex items-center gap-1">
                                        <button type="button" @click="openEditCustom(index)" class="p-1.5 text-slate-400 hover:text-primary-600 hover:bg-slate-100 rounded-lg transition-colors" title="Edit Pertanyaan">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>
                                        </button>
                                        <button type="button" @click="deleteCustom(index)" class="p-1.5 text-slate-400 hover:text-danger-600 hover:bg-slate-100 rounded-lg transition-colors" title="Hapus Pertanyaan">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>

            </div>

            <!-- Tab: Keamanan & PIN -->
            <div x-show="activeTab === 'keamanan'" x-cloak class="flex flex-col lg:flex-row gap-10">
                <div class="w-full lg:w-1/3">
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Keamanan & PIN Admin</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed">
                        Perbarui PIN keamanan untuk masuk ke dashboard admin. PIN harus terdiri dari 6 digit angka.
                    </p>
                </div>
                <div class="w-full lg:w-2/3 max-w-md">
                    <div class="bg-slate-50 rounded-xl border border-slate-100 p-6 space-y-4">
                        <div>
                            <label for="pin" class="block text-sm font-bold text-slate-700 mb-2">PIN Admin Baru (6 Digit)</label>
                            <input 
                                type="password" 
                                name="pin" 
                                id="pin"
                                maxlength="6"
                                placeholder="Masukkan 6 digit PIN baru"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm font-mono tracking-widest text-center transition-all bg-white"
                            >
                            <p class="text-xs text-slate-400 mt-2">Kosongkan jika tidak ingin mengubah PIN admin saat ini.</p>
                        </div>
                        <hr class="border-slate-100 my-4">
                        <div>
                            <label for="security_question" class="block text-sm font-bold text-slate-700 mb-2">Pertanyaan Keamanan (Lupa PIN)</label>
                            <input 
                                type="text" 
                                name="security_question" 
                                id="security_question"
                                value="{{ $securityQuestion }}"
                                placeholder="Contoh: Siapa nama hewan peliharaan pertama Anda?"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-all bg-white"
                            >
                            <p class="text-xs text-slate-400 mt-2">Pertanyaan ini akan ditanyakan jika Anda menekan tombol Lupa PIN.</p>
                        </div>
                        <div class="mt-4">
                            <label for="security_answer" class="block text-sm font-bold text-slate-700 mb-2">Jawaban Keamanan</label>
                            <input 
                                type="password" 
                                name="security_answer" 
                                id="security_answer"
                                placeholder="Masukkan jawaban keamanan (case insensitive)"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-all bg-white"
                            >
                            <p class="text-xs text-slate-400 mt-2">Kosongkan jika tidak ingin mengubah jawaban saat ini.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Modal: Add/Edit Kategori -->
        <div x-show="showCategoryModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-2xl max-w-md w-full p-6 space-y-4" @click.outside="showCategoryModal = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h4 class="font-bold text-slate-800 text-lg" x-text="editingCategoryIndex !== null ? 'Edit Kategori Tamu' : 'Tambah Kategori Tamu'"></h4>
                    <button type="button" @click="showCategoryModal = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori <span class="text-danger-500">*</span></label>
                        <input type="text" x-model="categoryForm.name" @keydown.enter.prevent="saveCategory()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Alumni / Tamu Khusus">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                        <input type="text" x-model="categoryForm.description" @keydown.enter.prevent="saveCategory()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Kunjungan alumni sekolah">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" @click="showCategoryModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">Batal</button>
                    <button type="button" @click="saveCategory()" class="px-4 py-2 rounded-xl text-xs font-bold bg-primary-600 hover:bg-primary-700 text-white shadow-sm" :disabled="!categoryForm.name.trim()">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Modal: Add/Edit Tujuan -->
        <div x-show="showTujuanModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-2xl max-w-md w-full p-6 space-y-4" @click.outside="showTujuanModal = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h4 class="font-bold text-slate-800 text-lg" x-text="editingTujuanIndex !== null ? 'Edit Opsi Tujuan' : 'Tambah Opsi Tujuan'"></h4>
                    <button type="button" @click="showTujuanModal = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Tujuan / Pihak Sekolah <span class="text-danger-500">*</span></label>
                    <input type="text" x-model="tujuanForm" @keydown.enter.prevent="saveTujuan()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Perpustakaan / Lab Komputer">
                </div>
                <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" @click="showTujuanModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">Batal</button>
                    <button type="button" @click="saveTujuan()" class="px-4 py-2 rounded-xl text-xs font-bold bg-primary-600 hover:bg-primary-700 text-white shadow-sm" :disabled="!tujuanForm.trim()">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Modal: Add/Edit Pertanyaan Tambahan Kustom -->
        <div x-show="showCustomModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-2xl max-w-md w-full p-6 space-y-4" @click.outside="showCustomModal = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h4 class="font-bold text-slate-800 text-lg" x-text="editingCustomIndex !== null ? 'Edit Pertanyaan Tambahan' : 'Tambah Pertanyaan Tambahan'"></h4>
                    <button type="button" @click="showCustomModal = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama / Label Pertanyaan <span class="text-danger-500">*</span></label>
                        <input type="text" x-model="customForm.label" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Nomor Polisi Kendaraan / Nama Anak">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tipe Input Field</label>
                        <select x-model="customForm.type" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                            <option value="text">Teks Pendek (Text Input)</option>
                            <option value="number">Angka (Number)</option>
                            <option value="textarea">Teks Panjang (Textarea)</option>
                            <option value="select">Dropdown (Pilihan Select)</option>
                        </select>
                    </div>
                    <div x-show="customForm.type === 'select'">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan Options (Pisahkan dengan koma)</label>
                        <input type="text" x-model="customForm.options" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Motor, Mobil, Jalan Kaki">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Placeholder Teks (Opsional)</label>
                        <input type="text" x-model="customForm.placeholder" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Masukkan Nopol">
                    </div>
                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" id="customRequired" x-model="customForm.required" class="w-4 h-4 text-primary-600 rounded border-slate-300 focus:ring-primary-500">
                        <label for="customRequired" class="text-xs font-bold text-slate-700 cursor-pointer">Wajib Diisi oleh Pengunjung (Required)</label>
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="showCustomModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">Batal</button>
                    <button type="button" @click="saveCustom()" class="px-4 py-2 rounded-xl text-xs font-bold bg-primary-600 hover:bg-primary-700 text-white shadow-sm" :disabled="!customForm.label.trim()">Simpan</button>
                </div>
            </div>
        </div>
        
        <!-- Footer Action -->
        <div class="bg-slate-50 border-t border-slate-100 p-4 sm:px-8 flex flex-col-reverse sm:flex-row gap-3 sm:gap-0 sm:justify-between sm:items-center text-sm font-medium">
            <span class="text-slate-500 flex items-center gap-2 text-center sm:text-left justify-center sm:justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-primary-500"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                Perubahan akan diterapkan setelah disimpan.
            </span>
            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-bold shadow-sm transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Simpan Konfigurasi
            </button>
        </div>

    </form>
@endsection
