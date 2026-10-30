<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Pengajuan Peminjaman Aset / Fasilitas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                
                <!-- Informatif SLA Admin -->
                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 rounded text-xs text-blue-700 dark:text-blue-300">
                    <p class="font-bold">Informasi SLA Persetujuan:</p>
                    <p class="mt-1">Setiap pengajuan peminjaman akan diverifikasi oleh Admin Sarpras dengan batas waktu (SLA) maksimal <strong>24 jam</strong> sejak formulir ini dikirimkan.</p>
                </div>

                <form action="{{ route('peminjam.pengajuan.store') }}" method="POST">
                    @csrf

                    <!-- Pilih Aset / Fasilitas -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Pilih Aset / Fasilitas</label>
                        <select name="id_aset" class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Fasilitas / Barang Inventaris --</option>
                            @foreach($asets as $aset)
                                <option value="{{ $aset->id_aset }}" {{ old('id_aset', request('id_aset')) == $aset->id_aset ? 'selected' : '' }}>
                                    [{{ $aset->kode_aset }}] {{ $aset->nama_aset }} ({{ $aset->kategori }}) - Kondisi: {{ $aset->kondisi_saat_ini }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_aset') 
                            <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Waktu Mulai Peminjaman -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Waktu Mulai Penggunaan</label>
                        <input type="datetime-local" name="waktu_mulai" value="{{ old('waktu_mulai') }}" class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('waktu_mulai') 
                            <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Waktu Selesai Peminjaman -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Waktu Selesai Penggunaan</label>
                        <input type="datetime-local" name="waktu_selesai" value="{{ old('waktu_selesai') }}" class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('waktu_selesai') 
                            <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Tujuan Penggunaan -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Tujuan / Alasan Kegiatan</label>
                        <textarea name="tujuan_penggunaan" rows="4" placeholder="Jelaskan secara singkat kegiatan yang akan dilaksanakan (contoh: Praktikum Mata Kuliah Pemrograman Web / Rapat Himpunan)..." class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('tujuan_penggunaan') }}</textarea>
                        @error('tujuan_penggunaan') 
                            <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center pt-2">
                        <a href="{{ route('peminjam.dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                            ← Batal
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg text-sm shadow transition duration-150">
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>