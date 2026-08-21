{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('header_title', 'Riwayat Tamu')

@section('content')
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Stat Card 1 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-soft">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Hari Ini</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $stats['today'] }}</h3>
                    <p class="text-xs font-medium text-slate-500 mt-1">Tamu</p>
                </div>
                <div class="p-3 bg-sky-50 text-sky-500 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-slate-400">
                <span>Hari ini</span>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-soft">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Minggu Ini</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $stats['week'] }}</h3>
                    <p class="text-xs font-medium text-slate-500 mt-1">Tamu</p>
                </div>
                <div class="p-3 bg-blue-50 text-blue-500 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-slate-400">
                <span>Minggu ini (Senin-Ahad)</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-soft">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Keseluruhan</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $stats['total'] }}</h3>
                    <p class="text-xs font-medium text-slate-500 mt-1">Tamu</p>
                </div>
                <div class="p-3 bg-purple-50 text-purple-500 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-slate-400">
                <span>Sejak sistem diaktifkan</span>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-soft flex items-center gap-4">
            <div class="p-4 bg-slate-50 text-slate-600 rounded-full border border-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori Terbanyak</p>
                <h3 class="text-xl font-black text-slate-800">{{ $stats['top_category'] }}</h3>
                <p class="text-xs font-medium text-slate-500 mt-1">Kunjungan paling sering</p>
            </div>
        </div>

    </div>

    <!-- Data Table Section -->
    <div 
        class="bg-white rounded-2xl border border-slate-100 shadow-soft overflow-hidden flex flex-col"
        x-data="{ openDetail: false, selectedVisit: {} }"
    >
        
        <!-- Table Header & Filters -->
        <form action="{{ route('admin.dashboard') }}" method="GET" class="p-4 sm:p-6 border-b border-slate-100 flex flex-col gap-4 justify-between bg-slate-50/50">
            <!-- Search -->
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-all" 
                    placeholder="Cari nama, instansi, ID..."
                >
            </div>

            <!-- Filters -->
            <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3 w-full">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                    <input 
                        type="date" 
                        name="start_date" 
                        value="{{ request('start_date') }}"
                        class="w-full sm:w-auto px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                    <span class="text-slate-400 text-xs font-bold text-center sm:text-left hidden sm:inline">s/d</span>
                    <input 
                        type="date" 
                        name="end_date" 
                        value="{{ request('end_date') }}"
                        class="w-full sm:w-auto px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                </div>
                
                <select name="kategori" class="w-full sm:w-auto py-2.5 px-4 pr-8 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Kategori</option>
                    <option value="Orang Tua / Wali" {{ request('kategori') === 'Orang Tua / Wali' ? 'selected' : '' }}>Orang Tua / Wali</option>
                    <option value="Dinas / Instansi" {{ request('kategori') === 'Dinas / Instansi' ? 'selected' : '' }}>Dinas / Instansi</option>
                    <option value="Umum" {{ request('kategori') === 'Umum' ? 'selected' : '' }}>Umum</option>
                    <option value="Mahasiswa" {{ request('kategori') === 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>

                <select name="tujuan" class="w-full sm:w-auto py-2.5 px-4 pr-8 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Tujuan</option>
                    @foreach($tujuanOptions as $option)
                        <option value="{{ $option }}" {{ request('tujuan') === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>

                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">
                    Filter
                </button>

                <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto text-center px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-sm font-bold shadow-sm transition-colors">
                    Reset
                </a>

                <a 
                    href="{{ route('admin.export', array_merge(request()->query(), ['format' => 'excel'])) }}" 
                    class="w-full sm:w-auto justify-center px-4 py-2.5 bg-success-600 hover:bg-success-700 text-white rounded-xl text-sm font-bold shadow-sm transition-colors flex items-center gap-2 shrink-0"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    Export Excel
                </a>

                <a 
                    href="{{ route('admin.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" 
                    class="w-full sm:w-auto justify-center px-4 py-2.5 bg-danger-600 hover:bg-danger-700 text-white rounded-xl text-sm font-bold shadow-sm transition-colors flex items-center gap-2 shrink-0"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    Export PDF
                </a>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto w-full -mx-px">
            <table class="w-full text-left text-sm min-w-[640px]">
                <thead class="text-xs text-slate-500 bg-slate-50 uppercase font-bold tracking-wider">
                    <tr>
                        <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100">No</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100">ID Kunjungan</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100">Nama</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100">Kategori</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100">Tujuan / Bertemu</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100">Waktu Kunjungan</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    
                    @forelse($visits as $index => $visit)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-500">
                                {{ ($visits->currentPage() - 1) * $visits->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 text-primary-600 font-mono">
                                {{ $visit->id_kunjungan }}
                            </td>
                            <td class="px-6 py-4 text-slate-800 font-bold">
                                {{ $visit->nama_lengkap }}
                            </td>
                            <td class="px-6 py-4">
                                @if($visit->kategori === 'Orang Tua / Wali')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-sky-50 text-sky-600 border border-sky-100">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                                        {{ $visit->kategori }}
                                    </span>
                                @elseif($visit->kategori === 'Dinas / Instansi')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>
                                        {{ $visit->kategori }}
                                    </span>
                                @elseif($visit->kategori === 'Mahasiswa')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-purple-50 text-purple-600 border border-purple-100">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" /></svg>
                                        {{ $visit->kategori }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                                        {{ $visit->kategori }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $visit->tujuan_bertemu }}</td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $visit->created_at->translatedFormat('d M Y, H:i') }} WIB
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button 
                                        type="button"
                                        @click="selectedVisit = {{ json_encode($visit) }}; openDetail = true"
                                        class="px-3 py-1.5 text-xs font-bold text-primary-600 bg-white border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors inline-flex items-center gap-1.5"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                        Detail
                                    </button>
                                    
                                    <form action="{{ route('admin.visit.destroy', $visit->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kunjungan ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 transition-colors inline-flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-400">
                                Belum ada data kunjungan tamu.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($visits->hasPages())
            <div class="p-6 border-t border-slate-100 bg-slate-50/30">
                {{ $visits->links() }}
            </div>
        @endif

        <!-- Detail Modal (Alpine.js) -->
        <div 
            x-show="openDetail"
            class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-slate-900/60 backdrop-blur-sm"
            x-transition
            x-cloak
        >
            <div 
                class="bg-white rounded-t-3xl sm:rounded-3xl w-full max-w-lg shadow-xl overflow-hidden border border-slate-100 max-h-[90vh] overflow-y-auto"
                @click.away="openDetail = false"
            >
                <div class="px-6 py-5 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-lg">Detail Kunjungan</h3>
                    <button @click="openDetail = false" class="text-slate-400 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">ID KUNJUNGAN</span>
                            <span class="font-mono text-primary-600 font-bold" x-text="selectedVisit.id_kunjungan"></span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">WAKTU</span>
                            <span class="text-slate-700 font-semibold" x-text="selectedVisit.created_at ? new Date(selectedVisit.created_at).toLocaleString('id-ID', {day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute:'2-digit'}) + ' WIB' : ''"></span>
                        </div>
                    </div>
                    
                    <hr class="border-slate-100">

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">NAMA TAMU</span>
                        <span class="text-slate-800 font-bold text-base" x-text="selectedVisit.nama_lengkap"></span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">KATEGORI</span>
                            <span class="text-slate-700 font-semibold" x-text="selectedVisit.kategori"></span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">ASAL INSTANSI / ALAMAT</span>
                            <span class="text-slate-700 font-semibold truncate block" x-text="selectedVisit.asal_instansi"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">TUJUAN</span>
                            <span class="text-slate-700 font-semibold" x-text="selectedVisit.tujuan_bertemu"></span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">NO WHATSAPP</span>
                            <span class="text-slate-700 font-semibold" x-text="selectedVisit.no_telepon || '-'"></span>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">EMAIL</span>
                        <span class="text-slate-700 font-semibold" x-text="selectedVisit.email || '-'"></span>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">KEPERLUAN</span>
                        <div class="bg-slate-50 p-4 rounded-xl text-slate-700 border border-slate-100 text-sm font-medium whitespace-pre-line" x-text="selectedVisit.keperluan"></div>
                    </div>

                    <!-- Tanda Tangan -->
                    <div x-show="selectedVisit.signature">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">TANDA TANGAN</span>
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-center justify-center">
                            <img 
                                :src="selectedVisit.signature" 
                                alt="Tanda Tangan Tamu" 
                                class="max-h-32 object-contain rounded-lg"
                                style="background: white;"
                            >
                        </div>
                    </div>
                    <div x-show="!selectedVisit.signature">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">TANDA TANGAN</span>
                        <span class="text-slate-400 text-sm font-medium italic">Belum ada tanda tangan</span>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
