<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                    {{ __('Manajemen Pengguna & Otoritas') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Kelola akun peminjam, pimpinan, petugas gudang, serta penanganan pemblokiran (*banned*).
                </p>
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

            <!-- Metric Cards (Overview User) -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 sm:gap-5">
                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-gray-200/80 dark:border-gray-700/80 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Pengguna</p>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $users->count() }} <span class="text-xs font-normal text-gray-400">Akun</span>
                        </h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center border border-indigo-100 dark:border-indigo-800/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 1912-7 7-7M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-gray-200/80 dark:border-gray-700/80 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Peminjam Aktif</p>
                        <h3 class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">
                            {{ $users->where('role', 'Peminjam')->where('is_banned', false)->count() }} <span class="text-xs font-normal text-gray-400">User</span>
                        </h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-emerald-800/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-gray-200/80 dark:border-gray-700/80 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Petugas & Sarpras</p>
                        <h3 class="text-2xl font-extrabold text-blue-600 dark:text-blue-400 mt-1">
                            {{ $users->whereIn('role', ['Admin', 'Petugas'])->count() }} <span class="text-xs font-normal text-gray-400">Staf</span>
                        </h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center border border-blue-100 dark:border-blue-800/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800/95 border border-rose-200/80 dark:border-rose-900/50 shadow-xl shadow-gray-200/40 dark:shadow-none flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400">Akun Diblokir</p>
                        <h3 class="text-2xl font-extrabold text-rose-600 dark:text-rose-400 mt-1">
                            {{ $users->where('is_banned', true)->count() }} <span class="text-xs font-normal text-gray-400">Banned</span>
                        </h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center border border-rose-100 dark:border-rose-800/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table Card Container -->
            <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-colors">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-gray-100">Daftar Pengguna Terdaftar</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Seluruh akun terdaftar beserta hak akses dan unit organisasinya.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50/80 dark:bg-gray-700/50 border-b border-gray-200/80 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4">IDENTITAS / NAMA</th>
                                <th class="px-6 py-4">UNIT ORGANISASI</th>
                                <th class="px-6 py-4">ROLE HAK AKSES</th>
                                <th class="px-6 py-4">STATUS AKSES</th>
                                <th class="px-6 py-4 text-center">TINDAKAN OTORITAS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                                        <div class="flex flex-col">
                                            <span>{{ $user->nama_lengkap }}</span>
                                            <span class="text-[11px] font-mono text-gray-400 dark:text-gray-500 font-normal">
                                                NIM/NIP: {{ $user->identitas }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-700 dark:text-gray-300">
                                        {{ $user->unit_organisasi ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->role == 'Admin')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                                Admin Sarpras
                                            </span>
                                        @elseif($user->role == 'Petugas')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                                Petugas Gudang
                                            </span>
                                        @elseif($user->role == 'Pimpinan')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                                Pimpinan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                                Peminjam
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->is_banned)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-700 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/60 px-3 py-1 rounded-full border border-rose-200 dark:border-rose-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Diblokir (Banned)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-3 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @if(Auth::id() !== $user->id_user)
                                            <form action="{{ route('admin.users.toggleBanned', $user->id_user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                @if($user->is_banned)
                                                    <button type="submit" 
                                                            class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold py-1.5 px-3 rounded-xl shadow-md shadow-emerald-600/20 transition-all">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                        </svg>
                                                        Unban User
                                                    </button>
                                                @else
                                                    <button type="submit" 
                                                            onclick="return confirm('Apakah Anda yakin ingin memblokir akses pengguna ini?')"
                                                            class="inline-flex items-center gap-1 bg-rose-600 hover:bg-rose-700 active:scale-95 text-white text-xs font-bold py-1.5 px-3 rounded-xl shadow-md shadow-rose-600/20 transition-all">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                        </svg>
                                                        Banned User
                                                    </button>
                                                @endif
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500 font-italic">(Akun Anda)</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500">
                                        Tidak ada pengguna terdaftar di dalam sistem.
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