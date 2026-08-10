{{-- resources/views/guestbook/form-step1.blade.php --}}
<div class="p-4 sm:p-6 lg:p-8">
    <div class="mb-6 sm:mb-8 text-center">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Pilih Kategori Tamu</h2>
        <p class="text-slate-500 mt-2 text-sm">Pilih kategori yang sesuai dengan status Anda saat ini.</p>
    </div>

    <!-- Grid Pilihan Kategori -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
        @php
            $themes = [
                ['border' => 'border-sky-500', 'bg' => 'bg-sky-50', 'ring' => 'focus:ring-sky-100', 'hover' => 'hover:border-sky-300 hover:bg-sky-50/50', 'icon_active' => 'bg-sky-500 text-white', 'icon_inactive' => 'bg-sky-100 text-sky-600 group-hover:bg-sky-200'],
                ['border' => 'border-blue-500', 'bg' => 'bg-blue-50', 'ring' => 'focus:ring-blue-100', 'hover' => 'hover:border-blue-300 hover:bg-blue-50/50', 'icon_active' => 'bg-blue-600 text-white', 'icon_inactive' => 'bg-blue-100 text-blue-700 group-hover:bg-blue-200'],
                ['border' => 'border-slate-500', 'bg' => 'bg-slate-50', 'ring' => 'focus:ring-slate-100', 'hover' => 'hover:border-slate-300 hover:bg-slate-50/50', 'icon_active' => 'bg-slate-600 text-white', 'icon_inactive' => 'bg-slate-100 text-slate-600 group-hover:bg-slate-200'],
                ['border' => 'border-purple-500', 'bg' => 'bg-purple-50', 'ring' => 'focus:ring-purple-100', 'hover' => 'hover:border-purple-300 hover:bg-purple-50/50', 'icon_active' => 'bg-purple-600 text-white', 'icon_inactive' => 'bg-purple-100 text-purple-600 group-hover:bg-purple-200'],
                ['border' => 'border-primary-500', 'bg' => 'bg-primary-50', 'ring' => 'focus:ring-primary-100', 'hover' => 'hover:border-primary-300 hover:bg-primary-50/50', 'icon_active' => 'bg-primary-600 text-white', 'icon_inactive' => 'bg-primary-100 text-primary-600 group-hover:bg-primary-200'],
            ];
        @endphp

        @foreach($categories as $index => $cat)
            @php
                $catName = is_array($cat) ? ($cat['name'] ?? '') : $cat;
                $catDesc = is_array($cat) ? ($cat['description'] ?? '') : '';
                $theme = $themes[$index % count($themes)];
                $safeName = addslashes($catName);
            @endphp
            <button 
                type="button"
                @click="setKategori('{{ $safeName }}')"
                class="flex flex-col items-center justify-center p-4 sm:p-6 rounded-2xl border-2 transition-all duration-200 group text-center focus:outline-none focus:ring-4 {{ $theme['ring'] }} min-h-[140px] sm:min-h-0"
                :class="form.kategori === '{{ $safeName }}' ? '{{ $theme['border'] }} {{ $theme['bg'] }} shadow-md transform scale-[1.02]' : 'border-slate-200 bg-white {{ $theme['hover'] }}'"
            >
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 transition-colors"
                     :class="form.kategori === '{{ $safeName }}' ? '{{ $theme['icon_active'] }}' : '{{ $theme['icon_inactive'] }}'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-800 text-lg mb-1">{{ $catName }}</h3>
                @if($catDesc)
                    <p class="text-xs font-medium text-slate-500">{{ $catDesc }}</p>
                @endif
            </button>
        @endforeach
    </div>

    <!-- Tombol Lanjut -->
    <div class="border-t border-slate-100 pt-6">
        <button 
            type="button" 
            @click="nextStep()"
            class="w-full py-4 rounded-xl font-bold text-white transition-all flex justify-center items-center gap-2"
            :class="form.kategori ? 'bg-primary-600 hover:bg-primary-700 shadow-md transform hover:-translate-y-0.5' : 'bg-slate-300 cursor-not-allowed opacity-70'"
            :disabled="!form.kategori"
        >
            <span>Selanjutnya</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>
    </div>
</div>
