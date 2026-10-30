<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                    {{ __('Pos Serah Terima & Inspeksi Gudang') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Proses verifikasi fisik, serah terima aset, dan inspeksi foto pengembalian barang.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200/80 dark:border-blue-800/80">
                    <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Gudang Standby
                </span>
            </div>
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

            <!-- Metric Cards Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-emerald-200/80 dark:border-emerald-900/50 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Siap Diserahkan</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $peminjamanDisetujui->count() }} <span class="text-sm font-normal text-gray-400">Pengambilan</span>
                        </h3>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-emerald-800/50">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-blue-200/80 dark:border-blue-900/50 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">Sedang Dipinjam</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $peminjamanDipinjam->count() }} <span class="text-sm font-normal text-gray-400">Unit Aktif</span>
                        </h3>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center border border-blue-100 dark:border-blue-800/50">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-purple-200/80 dark:border-purple-900/50 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">Total Inspeksi Selesai</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $totalSelesai }} <span class="text-sm font-normal text-gray-400">Selesai</span>
                        </h3>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center border border-purple-100 dark:border-purple-800/50">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table Card: Antrean Serah Terima / Pengembalian -->
            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-gray-100">
                            Antrean Pelayanan Gudang
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Lakukan inspeksi fisik dan upload foto kondisi barang saat pengambilan atau pengembalian.
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50/80 dark:bg-gray-700/50 border-b border-gray-200/80 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4">KODE TIKET</th>
                                <th class="px-6 py-4">PEMINJAM</th>
                                <th class="px-6 py-4">ASET / BARANG</th>
                                <th class="px-6 py-4">TAHAP PELAYANAN</th>
                                <th class="px-6 py-4 text-center">INSPEKSI FISIK</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($antreanPetugas as $item)
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-6 py-4 font-mono font-bold text-indigo-600 dark:text-indigo-400 text-xs">
                                        #PMJ-{{ str_pad($item->id_peminjaman, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                                        <div class="flex flex-col">
                                            <span>{{ $item->user->nama_lengkap }}</span>
                                            <span class="text-[11px] font-mono text-gray-400 dark:text-gray-500 font-normal">
                                                ID: {{ $item->user->identitas }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-gray-200">
                                        <div class="flex flex-col">
                                            <span>{{ $item->aset->nama_aset }}</span>
                                            <span class="text-[11px] font-mono text-gray-400 dark:text-gray-500 font-normal">
                                                Kode: {{ $item->aset->kode_aset }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->status_pengajuan == 'Disetujui')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Penyerahan Awal
                                            </span>
                                        @elseif($item->status_pengajuan == 'Dipinjam')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                Pengembalian Barang
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('petugas.inspeksi.create', $item->id_peminjaman) }}"
                                           class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-bold py-2 px-4 rounded-xl shadow-md shadow-indigo-600/20 transition-all">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M68 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Proses Inspeksi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                            <div class="h-14 w-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-3 border border-indigo-100 dark:border-indigo-800/60">
                                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-bold text-base text-gray-900 dark:text-gray-100">
                                                Tidak Ada Antrean Inspeksi
                                            </h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                                                Semua barang peminjaman aktif telah selesai diserahterimakan atau diinspeksi.
                                            </p>
                                        </div>
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