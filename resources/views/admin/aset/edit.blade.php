<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md text-xs font-mono font-bold bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/60">
                        {{ $aset->kode_aset }}
                    </span>
                    <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                        {{ __('Edit Data Aset') }}
                    </h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Perbarui informasi rincian, kondisi fisik, atau status operasional aset.
                </p>
            </div>
            <a href="{{ route('admin.aset.index') }}"
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
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                
                <div class="p-6 sm:p-7 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-gray-100">
                            Pembaruan Master Aset
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Menyunting aset: <strong class="text-gray-800 dark:text-gray-200">{{ $aset->nama_aset }}</strong>
                        </p>
                    </div>
                </div>

                <form action="{{ route('admin.aset.update', $aset->id_aset) }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    @method('PUT')

                    <div class="p-6 sm:p-7 space-y-5">

                        <!-- Kode Aset -->
                        <div>
                            <label for="kode_aset" class="{{ $labelCls }}">Kode Aset / Kode Inventaris</label>
                            <input type="text" id="kode_aset" name="kode_aset" value="{{ old('kode_aset', $aset->kode_aset) }}" 
                                   placeholder="Contoh: AST-INV-004 / RUA-402" 
                                   class="{{ $inputBase }} {{ $errors->has('kode_aset') ? $inputErr : $inputOk }}" required>
                            @error('kode_aset')
                                <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-red-600 dark:text-red-400">
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Nama Aset -->
                        <div>
                            <label for="nama_aset" class="{{ $labelCls }}">Nama Aset / Fasilitas</label>
                            <input type="text" id="nama_aset" name="nama_aset" value="{{ old('nama_aset', $aset->nama_aset) }}" 
                                   placeholder="Contoh: Kamera Canon EOS 80D / Lab Komputer 2" 
                                   class="{{ $inputBase }} {{ $errors->has('nama_aset') ? $inputErr : $inputOk }}" required>
                            @error('nama_aset')
                                <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-red-600 dark:text-red-400">
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Kategori & Kondisi Saat Ini (2 Kolom Grid) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="kategori" class="{{ $labelCls }}">Kategori Aset</label>
                                <select id="kategori" name="kategori" class="{{ $inputBase }} {{ $errors->has('kategori') ? $inputErr : $inputOk }} cursor-pointer" required>
                                    <option value="Fasilitas" {{ old('kategori', $aset->kategori) == 'Fasilitas' ? 'selected' : '' }}>Fasilitas (Ruangan / Lapangan / GOR)</option>
                                    <option value="Barang" {{ old('kategori', $aset->kategori) == 'Barang' ? 'selected' : '' }}>Barang Inventaris (Elektronik / Alat)</option>
                                </select>
                                @error('kategori')
                                    <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kondisi_saat_ini" class="{{ $labelCls }}">Kondisi Terkini</label>
                                <select id="kondisi_saat_ini" name="kondisi_saat_ini" class="{{ $inputBase }} {{ $errors->has('kondisi_saat_ini') ? $inputErr : $inputOk }} cursor-pointer" required>
                                    <option value="Baik" {{ old('kondisi_saat_ini', $aset->kondisi_saat_ini) == 'Baik' ? 'selected' : '' }}>Baik (Siap Pakai)</option>
                                    <option value="Rusak Ringan" {{ old('kondisi_saat_ini', $aset->kondisi_saat_ini) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi_saat_ini', $aset->kondisi_saat_ini) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi_saat_ini')
                                    <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Operasional / Status Aktif -->
                        <div>
                            <label for="status_aktif" class="{{ $labelCls }}">Status Operasional Peminjaman</label>
                            @php
                                $valStatus = old('status_aktif', $aset->status_aktif ?? $aset->is_active ?? 1);
                            @endphp
                            <select id="status_aktif" name="status_aktif" class="{{ $inputBase }} {{ $errors->has('status_aktif') ? $inputErr : $inputOk }} cursor-pointer" required>
                                <option value="1" {{ $valStatus == 1 ? 'selected' : '' }}>Aktif (Dapat Dipinjam oleh Peminjam)</option>
                                <option value="0" {{ $valStatus == 0 ? 'selected' : '' }}>Nonaktif (Disembunyikan dari Form Pengajuan)</option>
                            </select>
                            @error('status_aktif')
                                <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Action Footer -->
                    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4 bg-gray-50/80 dark:bg-gray-900/60 border-t border-gray-100 dark:border-gray-700/80">
                        <a href="{{ route('admin.aset.index') }}" 
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
                            <span x-text="loading ? 'Memperbarui...' : 'Perbarui Data Aset'">Perbarui Data Aset</span>
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>