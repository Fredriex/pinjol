<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                    {{ __('Dashboard Otorisasi & Pengelolaan Aset') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Kelola persetujuan izin peminjaman fasilitas/barang dan pantau batas waktu SLA secara real-time.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/80">
                    <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                    SLA Monitor Active
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alerts -->
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

            <!-- Metric Cards (KPI) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                
                <!-- Card 1: Menunggu Approval -->
                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-amber-200/80 dark:border-amber-900/50 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between transition-all">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">
                            Menunggu Persetujuan
                        </p>
                        <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $totalPengajuanMenunggu }} <span class="text-sm font-semibold text-gray-400">Tiket</span>
                        </h3>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center border border-amber-100 dark:border-amber-800/50">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Card 2: Total Aset Aktif -->
                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-indigo-200/80 dark:border-indigo-900/50 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between transition-all">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                            Total Aset Aktif
                        </p>
                        <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $totalAsetAktif }} <span class="text-sm font-semibold text-gray-400">Unit</span>
                        </h3>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center border border-indigo-100 dark:border-indigo-800/50">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>

                <!-- Card 3: Sedang Dipinjam -->
                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-emerald-200/80 dark:border-emerald-900/50 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between transition-all">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                            Aset Sedang Dipinjam
                        </p>
                        <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $totalAsetDipinjam }} <span class="text-sm font-semibold text-gray-400">Unit</span>
                        </h3>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-emerald-800/50">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                </div>

            </div>

            <!-- Table Container: Antrean Approval -->
            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                
                <div class="p-6 border-b border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-gray-100">
                            Daftar Pengajuan Masuk (Antrean Approval)
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Segera lakukan verifikasi sebelum batas toleransi waktu (SLA 24 jam) habis.
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50/80 dark:bg-gray-700/50 border-b border-gray-200/80 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4">PEMINJAM</th>
                                <th class="px-6 py-4">ASET / FASILITAS</th>
                                <th class="px-6 py-4">JADWAL PINJAM</th>
                                <th class="px-6 py-4">TUJUAN KEGIATAN</th>
                                <th class="px-6 py-4">SISA WAKTU SLA</th>
                                <th class="px-6 py-4 text-center">OTORISASI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($pengajuanMasuk as $item)
                                @php
                                    $sisaSla = now()->diff($item->batas_sla_admin);
                                    $isTerlewat = now()->greaterThan($item->batas_sla_admin);
                                @endphp
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors">
                                    
                                    <!-- Peminjam -->
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                                        <div class="flex flex-col">
                                            <span>{{ $item->user->nama_lengkap }}</span>
                                            <span class="text-[11px] font-mono text-gray-400 dark:text-gray-500 font-normal">
                                                NIM/NIP: {{ $item->user->identitas }} | {{ $item->user->unit_organisasi }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Aset -->
                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-gray-200">
                                        <div class="flex flex-col">
                                            <span>{{ $item->aset->nama_aset }}</span>
                                            <span class="text-[11px] font-mono text-gray-400 dark:text-gray-500 font-normal">
                                                Kode: {{ $item->aset->kode_aset }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Jadwal Pinjam -->
                                    <td class="px-6 py-4 text-xs font-mono text-gray-700 dark:text-gray-300">
                                        <div class="space-y-0.5">
                                            <span class="block text-gray-900 dark:text-gray-100 font-semibold">
                                                {{ $item->waktu_mulai->format('d M Y, H:i') }}
                                            </span>
                                            <span class="block text-gray-400">s.d.</span>
                                            <span class="block text-gray-900 dark:text-gray-100 font-semibold">
                                                {{ $item->waktu_selesai->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Tujuan -->
                                    <td class="px-6 py-4 text-xs text-gray-600 dark:text-gray-300 leading-relaxed max-w-xs">
                                        {{ $item->tujuan_penggunaan }}
                                    </td>

                                    <!-- Sisa SLA -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($isTerlewat)
                                            <span class="inline-flex items-center gap-1.5 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm shadow-red-600/30 animate-pulse">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                                </svg>
                                                SLA Terlewat!
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $sisaSla->h }}j {{ $sisaSla->i }}m tersisa
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi Otorisasi -->
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            <!-- Form Approve -->
                                            <form action="{{ route('admin.pengajuan.approve', $item->id_peminjaman) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold py-2 px-3.5 rounded-xl shadow-md shadow-emerald-600/20 transition-all">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                    </svg>
                                                    Approve
                                                </button>
                                            </form>

                                            <!-- Form Reject -->
                                            <form action="{{ route('admin.pengajuan.reject', $item->id_peminjaman) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan peminjaman ini?')"
                                                        class="inline-flex items-center gap-1 bg-rose-600 hover:bg-rose-700 active:scale-95 text-white text-xs font-bold py-2 px-3.5 rounded-xl shadow-md shadow-rose-600/20 transition-all">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Reject
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                            <div class="h-14 w-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-3 border border-indigo-100 dark:border-indigo-800/60">
                                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-bold text-base text-gray-900 dark:text-gray-100">
                                                Antrean Bersih!
                                            </h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                                                Tidak ada pengajuan peminjaman baru yang membutuhkan otorisasi Admin saat ini.
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