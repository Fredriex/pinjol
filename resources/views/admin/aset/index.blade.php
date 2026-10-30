<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                    {{ __('Master Data Aset & Inventaris') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Kelola daftar ruangan, fasilitas, dan alat elektronik terintegrasi.
                </p>
            </div>
            <a href="{{ route('admin.aset.create') }}" 
               class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm shadow-md shadow-indigo-600/20 transition duration-150">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Aset Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert -->
            @if(session('success'))
                <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200/80 dark:border-emerald-800/80 text-emerald-800 dark:text-emerald-200 text-sm shadow-sm">
                    <div class="shrink-0 p-1.5 rounded-lg bg-emerald-600 text-white">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center gap-3 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200/80 dark:border-rose-800/80 text-rose-800 dark:text-rose-200 text-sm shadow-sm">
                    <div class="shrink-0 p-1.5 rounded-lg bg-rose-600 text-white">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Cards Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-gray-200/80 dark:border-gray-700/80 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Fasilitas</p>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $asets->where('kategori', 'Fasilitas')->count() }} <span class="text-xs font-normal text-gray-400">Ruangan/GOR</span>
                        </h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center border border-indigo-100 dark:border-indigo-800/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-gray-200/80 dark:border-gray-700/80 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Barang Inventaris</p>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $asets->where('kategori', 'Barang')->count() }} <span class="text-xs font-normal text-gray-400">Unit Alat</span>
                        </h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center border border-blue-100 dark:border-blue-800/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-gray-200/80 dark:border-gray-700/80 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kondisi Baik</p>
                        <h3 class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">
                            {{ $asets->where('kondisi_saat_ini', 'Baik')->count() }} <span class="text-xs font-normal text-gray-400">Siap Pakai</span>
                        </h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-emerald-800/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-gray-100">Daftar Master Aset</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Seluruh unit yang terdaftar di dalam sistem beserta status ketersediaannya.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50/80 dark:bg-gray-700/50 border-b border-gray-200/80 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4">KODE ASET</th>
                                <th class="px-6 py-4">NAMA ASET / FASILITAS</th>
                                <th class="px-6 py-4">KATEGORI</th>
                                <th class="px-6 py-4">KONDISI FISIK</th>
                                <th class="px-6 py-4 text-center">AKSI MANAJEMEN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($asets as $item)
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-6 py-4 font-mono font-bold text-indigo-600 dark:text-indigo-400 text-xs">
                                        {{ $item->kode_aset }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $item->nama_aset }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold {{ $item->kategori == 'Fasilitas' ? 'bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800' : 'bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800' }}">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->kondisi_saat_ini == 'Baik')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-3 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Baik
                                            </span>
                                        @elseif($item->kondisi_saat_ini == 'Rusak Ringan')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/60 px-3 py-1 rounded-full border border-amber-200 dark:border-amber-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Rusak Ringan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-700 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/60 px-3 py-1 rounded-full border border-rose-200 dark:border-rose-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Rusak Berat
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            <!-- Tombol Toggle Nonaktifkan / Aktifkan Status -->
                                            <form action="{{ route('admin.aset.toggleStatus', $item->id_aset) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                @if(isset($item->is_active) && !$item->is_active)
                                                    <button type="submit" title="Aktifkan Aset"
                                                            class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold py-1.5 px-3 rounded-lg shadow-sm transition">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                        Aktifkan
                                                    </button>
                                                @else
                                                    <button type="submit" title="Nonaktifkan Aset"
                                                            onclick="return confirm('Nonaktifkan aset ini dari daftar peminjaman?')"
                                                            class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 active:scale-95 text-white text-xs font-bold py-1.5 px-3 rounded-lg shadow-sm transition">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                        Nonaktifkan
                                                    </button>
                                                @endif
                                            </form>

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.aset.edit', $item->id_aset) }}" 
                                               title="Edit Aset"
                                               class="p-2 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/60 rounded-lg transition">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.aset.destroy', $item->id_aset) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini secara permanen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus Permanen" class="p-2 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/60 rounded-lg transition">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500">
                                        Belum ada data aset yang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>