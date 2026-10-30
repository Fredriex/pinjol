<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                    {{ __('Form Pengajuan Peminjaman') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Lengkapi Rincian Fasilitas & Jadwal Penggunaan di Bawah Ini.
                </p>
            </div>
            <a href="{{ route('peminjam.dashboard') }}"
               class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 bg-white dark:bg-gray-800 px-3.5 py-2 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    @php
        $inputBase = 'block w-full rounded-xl text-sm bg-gray-50 dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 focus:bg-white dark:focus:bg-gray-900 focus:ring-2 py-2.5 px-3.5';
        $inputOk   = 'border-gray-200 dark:border-gray-700/80 focus:border-indigo-500 focus:ring-indigo-500/20';
        $inputErr  = 'border-red-400 dark:border-red-500/80 focus:border-red-500 focus:ring-red-500/20 bg-red-50/30 dark:bg-red-950/10';
        $labelCls  = 'block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5';
    @endphp

    <div class="py-8 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Info SLA Banner --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-500/10 via-blue-500/5 to-transparent dark:from-indigo-500/15 dark:via-blue-500/10 dark:to-transparent border border-indigo-100 dark:border-indigo-900/50 p-4 sm:p-5 shadow-sm">
                <div class="flex items-start gap-3.5">
                    <div class="shrink-0 flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-600/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-900 dark:text-indigo-300">
                            Jaminan Layanan Verifikasi (SLA)
                        </h4>
                        <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-300 mt-0.5">
                            Setiap pengajuan diproses langsung oleh Admin Sarpras dalam waktu maksimal <strong class="text-indigo-700 dark:text-indigo-300 font-semibold">24 Jam Kerja</strong>. Lakukan pengecekan status secara berkala.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                <form action="{{ route('peminjam.pengajuan.store') }}" method="POST"
                      x-data="{ loading: false, count: {{ mb_strlen(old('tujuan_penggunaan', '')) }} }"
                      @submit="loading = true">
                    @csrf

                    {{-- Section 1: Aset --}}
                    <div class="p-6 sm:p-7 space-y-4">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 text-xs font-extrabold border border-indigo-100 dark:border-indigo-800/60">
                                01
                            </span>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                Pilih Fasilitas / Barang Inventaris
                            </h3>
                        </div>

                        <div>
                            <label for="id_aset" class="{{ $labelCls }}">Aset Yang Ingin Dipinjam</label>
                            <div class="relative">
                                <select id="id_aset" name="id_aset" required
                                        class="{{ $inputBase }} {{ $errors->has('id_aset') ? $inputErr : $inputOk }} cursor-pointer">
                                    <option value="">-- Klik untuk memilih dari daftar aset --</option>
                                    @foreach($asets as $aset)
                                        <option value="{{ $aset->id_aset }}" {{ old('id_aset', request('id_aset')) == $aset->id_aset ? 'selected' : '' }}>
                                            [{{ $aset->kode_aset }}] {{ $aset->nama_aset }} ({{ $aset->kategori }}) — Kondisi: {{ $aset->kondisi_saat_ini }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_aset')
                                <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-red-600 dark:text-red-400">
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-700/60"></div>

                    {{-- Section 2: Waktu --}}
                    <div class="p-6 sm:p-7 space-y-4">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 text-xs font-extrabold border border-indigo-100 dark:border-indigo-800/60">
                                02
                            </span>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                Waktu & Durasi Peminjaman
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label for="waktu_mulai" class="{{ $labelCls }}">Waktu Mulai Pinjam</label>
                                <input id="waktu_mulai" type="datetime-local" name="waktu_mulai"
                                       value="{{ old('waktu_mulai') }}" required
                                       class="{{ $inputBase }} {{ $errors->has('waktu_mulai') ? $inputErr : $inputOk }}">
                                @error('waktu_mulai')
                                    <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="waktu_selesai" class="{{ $labelCls }}">Waktu Pengembalian</label>
                                <input id="waktu_selesai" type="datetime-local" name="waktu_selesai"
                                       value="{{ old('waktu_selesai') }}" required
                                       class="{{ $inputBase }} {{ $errors->has('waktu_selesai') ? $inputErr : $inputOk }}">
                                @error('waktu_selesai')
                                    <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-700/60"></div>

                    {{-- Section 3: Tujuan --}}
                    <div class="p-6 sm:p-7 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 text-xs font-extrabold border border-indigo-100 dark:border-indigo-800/60">
                                    03
                                </span>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    Tujuan & Deskripsi Kegiatan
                                </h3>
                            </div>
                            <span class="text-[11px] font-mono px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-700/60 text-gray-500 dark:text-gray-400"
                                  x-text="count + ' karakter'"></span>
                        </div>

                        <div>
                            <textarea id="tujuan_penggunaan" name="tujuan_penggunaan" rows="4" required
                                      x-on:input="count = $event.target.value.length"
                                      placeholder="Tuliskan alasan peminjaman secara jelas (misal: Kegiatan Seminar Himpunan / Praktikum Lab / Rapat Organisasi)..."
                                      class="{{ $inputBase }} resize-y {{ $errors->has('tujuan_penggunaan') ? $inputErr : $inputOk }}"></textarea>
                            <p class="mt-1.5 text-[11px] text-gray-500 dark:text-gray-400">
                                * Berikan penjelasan yang singkat dan padat untuk memudahkan proses approval dari Admin.
                            </p>
                            @error('tujuan_penggunaan')
                                <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Action Footer --}}
                    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4 bg-gray-50/80 dark:bg-gray-900/60 border-t border-gray-100 dark:border-gray-700/80">
                        <a href="{{ route('peminjam.dashboard') }}"
                           class="inline-flex items-center justify-center gap-1.5 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition py-2 px-3 rounded-lg">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </a>

                        <button type="submit" :disabled="loading"
                                class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold py-2.5 px-6 rounded-xl text-sm shadow-md shadow-indigo-600/25 transition-all duration-200 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span x-text="loading ? 'Memproses Pengajuan...' : 'Kirim Pengajuan Peminjaman'">Kirim Pengajuan Peminjaman</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>