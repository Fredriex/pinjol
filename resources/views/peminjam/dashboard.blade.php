<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard Peminjam') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pantau status pengajuan peminjaman aset dan fasilitas kamu.</p>
            </div>
            <a href="{{ route('peminjam.pengajuan.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg text-sm shadow-sm shadow-indigo-600/30 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Cari & Ajukan Peminjaman
            </a>
        </div>
    </x-slot>

    @php
        $user = Auth::user();

        $statusMap = [
            'Menunggu'  => ['badge' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20 dark:bg-yellow-500/10 dark:text-yellow-300 dark:ring-yellow-400/20', 'dot' => 'bg-yellow-500'],
            'Disetujui' => ['badge' => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-300 dark:ring-green-400/20',       'dot' => 'bg-green-500'],
            'Dipinjam'  => ['badge' => 'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-500/10 dark:text-blue-300 dark:ring-blue-400/20',             'dot' => 'bg-blue-500'],
            'Selesai'   => ['badge' => 'bg-gray-100 text-gray-700 ring-gray-500/20 dark:bg-gray-500/10 dark:text-gray-300 dark:ring-gray-400/20',             'dot' => 'bg-gray-400'],
            'Ditolak'   => ['badge' => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-300 dark:ring-red-400/20',                   'dot' => 'bg-red-500'],
        ];

        $stats = [
            ['label' => 'Menunggu',  'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',                                   'color' => 'text-yellow-600 bg-yellow-100 dark:text-yellow-300 dark:bg-yellow-500/15'],
            ['label' => 'Disetujui', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',                      'color' => 'text-green-600 bg-green-100 dark:text-green-300 dark:bg-green-500/15'],
            ['label' => 'Dipinjam',  'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'color' => 'text-blue-600 bg-blue-100 dark:text-blue-300 dark:bg-blue-500/15'],
            ['label' => 'Selesai',   'icon' => 'M4.5 12.75l6 6 9-13.5',                                                            'color' => 'text-gray-600 bg-gray-100 dark:text-gray-300 dark:bg-gray-500/15'],
        ];
    @endphp

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Banner selamat datang --}}
            <div class="bg-white dark:bg-gray-800 p-5 sm:p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between transition-colors">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="shrink-0 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-lg font-bold">
                        {{ strtoupper(mb_substr($user->nama_lengkap, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-xl font-extrabold text-gray-800 dark:text-gray-100 truncate">
                            Selamat datang, {{ $user->nama_lengkap }}!
                        </h3>
                        <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
                            <span>NIM/NIP: <span class="font-mono text-gray-700 dark:text-gray-300">{{ $user->identitas }}</span></span>
                            <span class="hidden sm:inline text-gray-300 dark:text-gray-600">•</span>
                            <span>Unit: <span class="text-gray-700 dark:text-gray-300">{{ $user->unit_organisasi }}</span></span>
                        </div>
                    </div>
                </div>

                @if($user->is_banned)
                    <span class="inline-flex items-center gap-1.5 self-start sm:self-auto rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/20 dark:bg-red-500/10 dark:text-red-300 dark:ring-red-400/20">
                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Diblokir
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 self-start sm:self-auto rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-500/10 dark:text-green-300 dark:ring-green-400/20">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Aktif
                    </span>
                @endif
            </div>

            {{-- Kartu ringkasan --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($stats as $stat)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-3 transition-colors">
                        <div class="shrink-0 flex h-10 w-10 items-center justify-center rounded-lg {{ $stat['color'] }}">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold leading-none text-gray-800 dark:text-gray-100">
                                {{ $riwayat->where('status_pengajuan', $stat['label'])->count() }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tabel riwayat --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 transition-colors">
                <div class="flex items-center justify-between px-5 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-base sm:text-lg text-gray-800 dark:text-gray-100">
                        Riwayat Pengajuan Peminjaman
                    </h3>
                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $riwayat->count() }} pengajuan</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[11px] font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-5 py-3">Aset / Fasilitas</th>
                                <th class="px-5 py-3">Jadwal</th>
                                <th class="px-5 py-3">Tujuan Kegiatan</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                <th class="px-5 py-3 text-right">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($riwayat as $item)
                                @php
                                    $status = $statusMap[$item->status_pengajuan] ?? $statusMap['Ditolak'];
                                    $sameDay = $item->waktu_mulai->isSameDay($item->waktu_selesai);
                                @endphp
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-5 py-4">
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $item->aset->nama_aset }}</p>
                                        <p class="mt-0.5 text-xs font-mono text-gray-400 dark:text-gray-500">{{ $item->aset->kode_aset }}</p>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($sameDay)
                                            <p class="text-gray-800 dark:text-gray-200">{{ $item->waktu_mulai->format('d M Y') }}</p>
                                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                {{ $item->waktu_mulai->format('H:i') }} – {{ $item->waktu_selesai->format('H:i') }}
                                            </p>
                                        @else
                                            <p class="text-gray-800 dark:text-gray-200">{{ $item->waktu_mulai->format('d M Y, H:i') }}</p>
                                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">s/d {{ $item->waktu_selesai->format('d M Y, H:i') }}</p>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 max-w-xs">
                                        <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2" title="{{ $item->tujuan_penggunaan }}">
                                            {{ $item->tujuan_penggunaan }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $status['badge'] }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                            {{ $item->status_pengajuan }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('peminjam.pengajuan.show', $item->id_peminjaman) }}"
                                           class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition">
                                            Detail Tiket
                                            <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-14">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500">
                                                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            </div>
                                            <p class="mt-3 text-sm font-medium text-gray-600 dark:text-gray-300">Belum ada riwayat peminjaman</p>
                                            <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Ajukan peminjaman pertama kamu untuk mulai.</p>
                                            <a href="{{ route('peminjam.pengajuan.create') }}" class="mt-4 text-xs font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                + Ajukan sekarang
                                            </a>
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