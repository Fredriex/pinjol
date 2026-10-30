<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md text-xs font-mono font-bold bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/60">
                        #PMJ-{{ str_pad($peminjaman->id_peminjaman, 5, '0', STR_PAD_LEFT) }}
                    </span>
                    <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                        {{ __('Inspeksi & Serah Terima Gudang') }}
                    </h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Unggah bukti fisik dan lakukan penilaian kondisi barang secara jujur dan transparan.
                </p>
            </div>
            <a href="{{ route('petugas.dashboard') }}"
               class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 bg-white dark:bg-gray-800 px-3.5 py-2 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Batal
            </a>
        </div>
    </x-slot>

    @php
        $inputBase = 'block w-full rounded-xl text-sm bg-gray-50 dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 focus:bg-white dark:focus:bg-gray-900 focus:ring-2 py-2.5 px-3.5';
        $inputOk   = 'border-gray-200 dark:border-gray-700/80 focus:border-indigo-500 focus:ring-indigo-500/20';
        $inputErr  = 'border-red-400 dark:border-red-500/80 focus:border-red-500 focus:ring-red-500/20 bg-red-50/30 dark:bg-red-950/10';
        $labelCls  = 'block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5';
        
        $isPengembalian = ($peminjaman->status_pengajuan == 'Dipinjam');
    @endphp

    <div class="py-8 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Ringkasan Tiket Card -->
            <div class="p-6 rounded-2xl bg-white dark:bg-gray-800/95 border border-gray-200/80 dark:border-gray-700/80 shadow-xl shadow-gray-200/40 dark:shadow-none space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100 dark:border-gray-700/60">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Tahap Layanan</span>
                        <h4 class="text-base font-extrabold text-gray-900 dark:text-gray-100">
                            {{ $isPengembalian ? 'Inspeksi Pengembalian Barang' : 'Penyerahan Awal Barang' }}
                        </h4>
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $isPengembalian ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200' : 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200' }}">
                            {{ $isPengembalian ? 'Tahap 2: Pengembalian' : 'Tahap 1: Serah Terima' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 uppercase font-bold block">Peminjam:</span>
                        <p class="font-bold text-gray-800 dark:text-gray-200 text-sm">{{ $peminjaman->user->nama_lengkap }}</p>
                        <p class="text-gray-500 font-mono">NIM/NIP: {{ $peminjaman->user->identitas }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 uppercase font-bold block">Aset / Fasilitas:</span>
                        <p class="font-bold text-gray-800 dark:text-gray-200 text-sm">{{ $peminjaman->aset->nama_aset }}</p>
                        <p class="text-gray-500 font-mono">Kode: {{ $peminjaman->aset->kode_aset }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Inspeksi -->
            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                
                <form action="{{ route('petugas.inspeksi.store', $peminjaman->id_peminjaman) }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      x-data="{ loading: false, photoPreview: null }" 
                      @submit="loading = true">
                    @csrf

                    <div class="p-6 sm:p-7 space-y-6">

                        <!-- Dropzone Preview Upload Foto -->
                        <div>
                            <label class="{{ $labelCls }}">
                                {{ $isPengembalian ? 'Unggah Foto Kondisi Akhir (Pengembalian)' : 'Unggah Foto Kondisi Awal (Baseline Serah Terima)' }}
                            </label>

                            <div class="mt-2 flex justify-center rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700 px-6 py-8 transition hover:border-indigo-500 dark:hover:border-indigo-400 bg-gray-50/50 dark:bg-gray-900/50">
                                <div class="text-center space-y-3">
                                    
                                    <!-- Dynamic Preview / Default Placeholder -->
                                    <template x-if="!photoPreview">
                                        <div class="flex flex-col items-center">
                                            <div class="h-12 w-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-2">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M68 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex text-xs text-gray-600 dark:text-gray-400">
                                                <label for="foto_inspeksi" class="relative cursor-pointer rounded-md font-bold text-indigo-600 dark:text-indigo-400 hover:underline focus-within:outline-none">
                                                    <span>Pilih foto kamera/galeri</span>
                                                    <input id="foto_inspeksi" 
                                                           name="{{ $isPengembalian ? 'foto_akhir' : 'foto_baseline' }}" 
                                                           type="file" 
                                                           accept="image/*" 
                                                           class="sr-only" 
                                                           required
                                                           x-on:change="
                                                                const file = $event.target.files[0];
                                                                if (file) {
                                                                    const reader = new FileReader();
                                                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                                                    reader.readAsDataURL(file);
                                                                }
                                                           ">
                                                </label>
                                                <p class="pl-1">atau tarik file ke sini</p>
                                            </div>
                                            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">PNG, JPG, JPEG hingga 5MB</p>
                                        </div>
                                    </template>

                                    <!-- Image Preview State -->
                                    <template x-if="photoPreview">
                                        <div class="flex flex-col items-center space-y-3">
                                            <img :src="photoPreview" class="h-44 w-auto rounded-xl object-cover border border-gray-200 dark:border-gray-700 shadow-md">
                                            <button type="button" 
                                                    x-on:click="photoPreview = null; document.getElementById('foto_inspeksi').value = ''" 
                                                    class="text-xs font-bold text-rose-600 dark:text-rose-400 hover:underline">
                                                Ganti Foto Inspeksi
                                            </button>
                                        </div>
                                    </template>

                                </div>
                            </div>
                            @error($isPengembalian ? 'foto_akhir' : 'foto_baseline')
                                <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kondisi Fisik -->
                        <div>
                            <label for="kondisi_fisik" class="{{ $labelCls }}">Penilaian Kondisi Fisik Aset</label>
                            <select id="kondisi_fisik" 
                                    name="{{ $isPengembalian ? 'kondisi_akhir' : 'kondisi_baseline' }}" 
                                    class="{{ $inputBase }} {{ $errors->has('kondisi_fisik') ? $inputErr : $inputOk }} cursor-pointer" 
                                    required>
                                <option value="Baik" selected>Baik (Sesuai Standar Operasional)</option>
                                <option value="Rusak Ringan">Rusak Ringan (Ada goresan/cacat fungsi minor)</option>
                                <option value="Rusak Berat">Rusak Berat (Tidak berfungsi / komponen patah)</option>
                            </select>
                        </div>

                        <!-- Catatan / Keterangan Inspeksi -->
                        <div>
                            <label for="catatan_inspeksi" class="{{ $labelCls }}">Catatan Tambahan Petugas Gudang</label>
                            <textarea id="catatan_inspeksi" 
                                      name="catatan_inspeksi" 
                                      rows="3" 
                                      placeholder="Tuliskan kelengkapan aksesoris (misal: charger, kabel HDMI, tas) atau indikasi kerusakan jika ada..."
                                      class="{{ $inputBase }} resize-y {{ $errors->has('catatan_inspeksi') ? $inputErr : $inputOk }}"></textarea>
                        </div>

                    </div>

                    <!-- Action Footer -->
                    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4 bg-gray-50/80 dark:bg-gray-900/60 border-t border-gray-100 dark:border-gray-700/80">
                        <a href="{{ route('petugas.dashboard') }}" 
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
                            <span x-text="loading ? 'Menyimpan Hasil Inspeksi...' : 'Simpan Inspeksi & Selesaikan'">
                                Simpan Inspeksi & Selesaikan
                            </span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>