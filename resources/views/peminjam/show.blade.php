<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md text-xs font-mono font-bold bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/60">
                        TIKET E-RECEIPT
                    </span>
                    <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                        #PMJ-{{ str_pad($peminjaman->id_peminjaman, 5, '0', STR_PAD_LEFT) }}
                    </h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Detail permohonan, jadwal penggunaan, serta bukti fisik inspeksi sarpras.
                </p>
            </div>
            <a href="{{ route('peminjam.dashboard') }}"
               class="inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 bg-white dark:bg-gray-800 px-3.5 py-2 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Main Card Container -->
            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                
                <!-- Status Bar Header -->
                <div class="p-6 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50/50 dark:bg-gray-900/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">
                            Status Pengajuan Tiket
                        </span>
                        <div>
                            @if($peminjaman->status_pengajuan == 'Menunggu')
                                <span class="inline-flex items-center gap-1.5 bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 text-xs font-bold px-3 py-1.5 rounded-full border border-amber-200/80 dark:border-amber-800/80">
                                    <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Approval Admin
                                </span>
                            @elseif($peminjaman->status_pengajuan == 'Disetujui')
                                <span class="inline-flex items-center gap-1.5 bg-green-50 dark:bg-green-950/50 text-green-700 dark:text-green-300 text-xs font-bold px-3 py-1.5 rounded-full border border-green-200/80 dark:border-green-800/80">
                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                    Disetujui (Siap Diambil di Gudang)
                                </span>
                            @elseif($peminjaman->status_pengajuan == 'Dipinjam')
                                <span class="inline-flex items-center gap-1.5 bg-blue-50 dark:bg-blue-950/50 text-blue-700 dark:text-blue-300 text-xs font-bold px-3 py-1.5 rounded-full border border-blue-200/80 dark:border-blue-800/80">
                                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                    Sedang Dipinjam
                                </span>
                            @elseif($peminjaman->status_pengajuan == 'Selesai')
                                <span class="inline-flex items-center gap-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-bold px-3 py-1.5 rounded-full border border-gray-200 dark:border-gray-600">
                                    <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 text-xs font-bold px-3 py-1.5 rounded-full border border-red-200/80 dark:border-red-800/80">
                                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                    Pengajuan Ditolak
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($peminjaman->status_pengajuan == 'Menunggu')
                        <form action="{{ route('peminjam.pengajuan.cancel', $peminjaman->id_peminjaman) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan peminjaman ini?')" 
                                    class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 active:scale-[0.98] text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md shadow-red-600/20 transition-all">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batalkan Pengajuan
                            </button>
                        </form>
                    @endif
                </div>

                <div class="p-6 sm:p-8 space-y-8">
                    
                    <!-- Grid Informasi Aset & Waktu -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Card Aset -->
                        <div class="p-5 rounded-2xl bg-gray-50/80 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700/60 space-y-3">
                            <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Informasi Aset / Fasilitas
                                </h4>
                            </div>
                            <div>
                                <h3 class="text-lg font-extrabold text-gray-900 dark:text-gray-100">
                                    {{ $peminjaman->aset->nama_aset }}
                                </h3>
                                <div class="flex flex-wrap items-center gap-2 mt-2">
                                    <span class="px-2.5 py-1 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-mono font-semibold border border-gray-200 dark:border-gray-700">
                                        Kode: {{ $peminjaman->aset->kode_aset }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 text-xs font-semibold border border-indigo-100 dark:border-indigo-900/50">
                                        {{ $peminjaman->aset->kategori }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Jadwal -->
                        <div class="p-5 rounded-2xl bg-gray-50/80 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700/60 space-y-3">
                            <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Jadwal Peminjaman
                                </h4>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between items-center py-1 border-b border-gray-200/60 dark:border-gray-700/60">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Waktu Mulai:</span>
                                    <span class="font-bold font-mono text-gray-800 dark:text-gray-200">
                                        {{ $peminjaman->waktu_mulai->format('d M Y, H:i') }} WIB
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Waktu Pengembalian:</span>
                                    <span class="font-bold font-mono text-gray-800 dark:text-gray-200">
                                        {{ $peminjaman->waktu_selesai->format('d M Y, H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tujuan Penggunaan -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">
                            Tujuan & Alasan Kegiatan
                        </h4>
                        <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200/60 dark:border-gray-700/60 text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $peminjaman->tujuan_penggunaan }}
                        </div>
                    </div>

                    <!-- Rekam Jejak Inspeksi Gudang -->
                    @if($peminjaman->inspeksi)
                        <div class="pt-6 border-t border-gray-100 dark:border-gray-700/60 space-y-4">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M68 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">
                                    Rekam Jejak Inspeksi Fisik (Petugas Gudang)
                                </h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Foto Baseline (Serah Terima) -->
                                @if($peminjaman->inspeksi->foto_baseline_url)
                                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200/60 dark:border-gray-700/60 space-y-2">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300">
                                                Kondisi Awal (Serah Terima)
                                            </span>
                                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                                {{ $peminjaman->inspeksi->kondisi_baseline }}
                                            </span>
                                        </div>
                                        <div class="relative overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 aspect-video group">
                                            <img src="{{ asset('storage/' . $peminjaman->inspeksi->foto_baseline_url) }}" 
                                                 alt="Foto Kondisi Awal" 
                                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        </div>
                                    </div>
                                @endif

                                <!-- Foto Akhir (Pengembalian) -->
                                @if($peminjaman->inspeksi->foto_akhir_url)
                                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200/60 dark:border-gray-700/60 space-y-2">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300">
                                                Kondisi Akhir (Pengembalian)
                                            </span>
                                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-950 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                                {{ $peminjaman->inspeksi->kondisi_akhir }}
                                            </span>
                                        </div>
                                        <div class="relative overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 aspect-video group">
                                            <img src="{{ asset('storage/' . $peminjaman->inspeksi->foto_akhir_url) }}" 
                                                 alt="Foto Kondisi Akhir" 
                                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>
</x-app-layout>