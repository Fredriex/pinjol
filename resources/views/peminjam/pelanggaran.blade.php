<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                    {{ __('Riwayat Pelanggaran & Sanksi') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Catatan keterlambatan pengembalian, kerusakan aset, serta status sinkronisasi denda keuangan.
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Banner Peringatan Integrasi Keuangan --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-500/10 via-amber-500/5 to-transparent dark:from-red-500/15 dark:via-amber-500/10 dark:to-transparent border border-red-200/80 dark:border-red-900/50 p-4 sm:p-5 shadow-sm">
                <div class="flex items-start gap-3.5">
                    <div class="shrink-0 flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-md shadow-red-600/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-red-900 dark:text-red-300">
                            Pencatatan Otomatis & Sinkronisasi Keuangan
                        </h4>
                        <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-300 mt-0.5">
                            Setiap keterlambatan atau kerusakan aset secara otomatis diteruskan ke <strong class="text-gray-800 dark:text-gray-200">Modul Keuangan Kampus</strong>. Pelunasan denda diperlukan agar akun Anda terbebas dari pembatasan peminjaman (*banned*).
                        </p>
                    </div>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-gray-100">
                            Catatan Pelanggaran Pribadi
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Daftar seluruh rekam jejak sanksi dan denda atas akun Anda.
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50/80 dark:bg-gray-700/50 border-b border-gray-200/80 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4">ASET TERKAIT</th>
                                <th class="px-6 py-4">JENIS PELANGGARAN</th>
                                <th class="px-6 py-4">RINCIAN KETERANGAN</th>
                                <th class="px-6 py-4 text-center">STATUS SINKRONISASI KEUANGAN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($pelanggaran as $p)
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                                        <div class="flex flex-col">
                                            <span>{{ $p->peminjaman->aset->nama_aset }}</span>
                                            <span class="text-[11px] font-mono text-gray-400 dark:text-gray-500">
                                                Kode: {{ $p->peminjaman->aset->kode_aset ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-400 border border-red-200/60 dark:border-red-800/60">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>
                                            {{ $p->jenis_pelanggaran }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 dark:text-gray-300 leading-relaxed max-w-xs">
                                        {{ $p->keterangan }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if(in_array(strtolower($p->status_keuangan), ['lunas', 'terbayar', 'sinkron', 'success']))
                                            <span class="inline-flex items-center gap-1.5 bg-green-50 dark:bg-green-950/50 text-green-700 dark:text-green-300 text-xs font-semibold px-3 py-1 rounded-full border border-green-200 dark:border-green-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                {{ $p->status_keuangan }}
                                            </span>
                                        @elseif(in_array(strtolower($p->status_keuangan), ['pending', 'proses', 'belum lunas']))
                                            <span class="inline-flex items-center gap-1.5 bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 text-xs font-semibold px-3 py-1 rounded-full border border-amber-200 dark:border-amber-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                {{ $p->status_keuangan }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 bg-blue-50 dark:bg-blue-950/50 text-blue-700 dark:text-blue-300 text-xs font-semibold px-3 py-1 rounded-full border border-blue-200 dark:border-blue-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                {{ $p->status_keuangan }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                            <div class="h-14 w-14 rounded-2xl bg-green-50 dark:bg-green-950/50 text-green-600 dark:text-green-400 flex items-center justify-center mb-3.5 border border-green-200/60 dark:border-green-800/60">
                                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-bold text-base text-gray-900 dark:text-gray-100">
                                                Tidak Ada Pelanggaran
                                            </h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                                                Selamat! Rekam jejak peminjaman Anda sangat bersih. Anda tidak memiliki catatan keterlambatan maupun denda.
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