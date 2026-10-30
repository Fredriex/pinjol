<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md text-xs font-mono font-bold bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800/60">
                        SERAH TERIMA BARANG
                    </span>
                    <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                        #PMJ-{{ str_pad($peminjaman->id_peminjaman, 5, '0', STR_PAD_LEFT) }}
                    </h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Verifikasi identitas peminjam dan dokumentasikan kondisi fisik awal (*baseline*) sebelum barang dibawa.
                </p>
            </div>
            <a href="{{ route('petugas.dashboard') }}"
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

            <!-- Card Informasi Peminjam & Barang -->
            <div class="p-6 rounded-2xl bg-white dark:bg-gray-800/95 border border-gray-200/80 dark:border-gray-700/80 shadow-xl shadow-gray-200/40 dark:shadow-none space-y-4 transition-colors">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700/60">
                    <h3 class="font-bold text-base text-gray-900 dark:text-gray-100">
                        Rincian Tiket Peminjaman
                    </h3>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        Disetujui Admin
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/60 space-y-1">
                        <span class="text-gray-400 uppercase font-bold block">Peminjam:</span>
                        <p class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ $peminjaman->user->nama_lengkap }}</p>
                        <p class="text-gray-500 font-mono">NIM/NIP: {{ $peminjaman->user->identitas }}</p>
                        <p class="text-gray-500">Unit: {{ $peminjaman->user->unit_organisasi ?? '-' }}</p>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/60 space-y-1">
                        <span class="text-gray-400 uppercase font-bold block">Aset / Barang:</span>
                        <p class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ $peminjaman->aset->nama_aset }}</p>
                        <p class="text-gray-500 font-mono">Kode: {{ $peminjaman->aset->kode_aset }}</p>
                        <p class="text-gray-500">Kategori: {{ $peminjaman->aset->kategori }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Serah Terima -->
            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                <form action="{{ route('petugas.serah_terima.process', $peminjaman->id_peminjaman) }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      x-data="{ loading: false, photoPreview: null }" 
                      @submit="loading = true">
                    @csrf

                    <div class="p-6 sm:p-7 space-y-6">

                        <!-- Kondisi Baseline -->
                        <div>
                            <label for="kondisi_baseline" class="{{ $labelCls }}">Kondisi Fisik Barang Saat Penyerahan</label>
                            <select id="kondisi_baseline" name="kondisi_baseline" class="{{ $inputBase }} {{ $errors->has('kondisi_baseline') ? $inputErr : $inputOk }} cursor-pointer" required>
                                <option value="Baik" {{ old('kondisi_baseline') == 'Baik' ? 'selected' : '' }}>Baik (Siap Digunakan)</option>
                                <option value="Rusak Ringan" {{ old('kondisi_baseline') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan (Ada cacat visual minor)</option>
                                <option value="Rusak Berat" {{ old('kondisi_baseline') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            @error('kondisi_baseline')
                                <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Foto Baseline -->
                        <div>
                            <label class="{{ $labelCls }}">Unggah Foto Bukti Fisik Awal (Baseline)</label>
                            
                            <div class="mt-2 flex justify-center rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700 px-6 py-8 transition hover:border-indigo-500 dark:hover:border-indigo-400 bg-gray-50/50 dark:bg-gray-900/50">
                                <div class="text-center space-y-3">
                                    
                                    <!-- Hidden Input File (Tetap di DOM, tidak ikut dihapus Alpine) -->
                                    <input id="foto_baseline" 
                                           name="foto_baseline" 
                                           type="file" 
                                           accept="image/jpeg,image/png,image/jpg" 
                                           class="hidden" 
                                           required
                                           x-on:change="
                                                const file = $event.target.files[0];
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                                    reader.readAsDataURL(file);
                                                }
                                           ">

                                    <!-- Tampilan 1: Belum Ada Foto (Pakai x-show) -->
                                    <div x-show="!photoPreview" class="flex flex-col items-center">
                                        <div class="h-12 w-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-2">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M68 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex text-xs text-gray-600 dark:text-gray-400">
                                            <label for="foto_baseline" class="cursor-pointer rounded-md font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                                                <span>Ambil Foto / Pilih File</span>
                                            </label>
                                        </div>
                                        <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">Format JPG, JPEG, PNG (Maksimal 2MB)</p>
                                    </div>

                                    <!-- Tampilan 2: Preview Foto (Pakai x-show) -->
                                    <div x-show="photoPreview" x-cloak class="flex flex-col items-center space-y-3">
                                        <img :src="photoPreview" class="h-44 w-auto rounded-xl object-cover border border-gray-200 dark:border-gray-700 shadow-md">
                                        <label for="foto_baseline" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline cursor-pointer">
                                            Ganti Foto
                                        </label>
                                    </div>

                                </div>
                            </div>
                            @error('foto_baseline')
                                <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Footer Action -->
                    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4 bg-gray-50/80 dark:bg-gray-900/60 border-t border-gray-100 dark:border-gray-700/80">
                        <a href="{{ route('petugas.dashboard') }}" 
                           class="inline-flex items-center justify-center gap-1.5 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition py-2 px-3 rounded-lg">
                            Batal
                        </a>

                        <button type="submit" :disabled="loading"
                                class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold py-2.5 px-6 rounded-xl text-sm shadow-md shadow-emerald-600/25 transition-all">
                            <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span x-text="loading ? 'Memproses Serah Terima...' : 'Konfirmasi Serah Terima Barang'">
                                Konfirmasi Serah Terima Barang
                            </span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>