<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 transition-colors duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links (DESKTOP) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->hasRole('Admin'))
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="dark:text-gray-300 dark:hover:text-white">
                        {{ __('Persetujuan Peminjaman') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.aset.index')" :active="request()->routeIs('admin.aset.*')" class="dark:text-gray-300 dark:hover:text-white">
                        {{ __('Kelola Aset') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="dark:text-gray-300 dark:hover:text-white">
                        {{ __('Kelola User') }}
                    </x-nav-link>
                    @endif

                    @if(auth()->user()->hasRole('Petugas'))
                    <x-nav-link :href="route('petugas.dashboard')" :active="request()->routeIs('petugas.*')" class="dark:text-gray-300 dark:hover:text-white">
                        {{ __('Serah Terima Barang') }}
                    </x-nav-link>
                    @endif

                    @if(auth()->user()->hasRole('Peminjam'))
                    <x-nav-link :href="route('peminjam.dashboard')" :active="request()->routeIs('peminjam.dashboard')" class="dark:text-gray-300 dark:hover:text-white">
                        {{ __('Pengajuan Peminjaman') }}
                    </x-nav-link>
                    <x-nav-link :href="route('peminjam.pelanggaran')" :active="request()->routeIs('peminjam.pelanggaran')" class="dark:text-gray-300 dark:hover:text-white">
                        {{ __('Pelanggaran Saya') }}
                    </x-nav-link>
                    @endif

                    @if(auth()->user()->hasRole('Pimpinan'))
                    <x-nav-link :href="route('pimpinan.dashboard')" :active="request()->routeIs('pimpinan.*')" class="dark:text-gray-300 dark:hover:text-white">
                        {{ __('Laporan Utilisasi') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Header Controls: Notifikasi, Dark Mode Toggle, Profile -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3">

                <!-- Notification Dropdown -->
                <div class="relative">
                    <x-dropdown align="right" width="150">
                        <x-slot name="trigger">
                            <button class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @php
                            $notifications = Auth::user()->notifications()->latest()->take(10)->get();
                            $unreadCount = Auth::user()->unreadNotifications()->count();
                            @endphp

                            {{-- Header --}}
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Notifikasi</h3>
                                    @if($unreadCount > 0)
                                    <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 rounded-full bg-indigo-600 text-white text-[10px] font-bold">
                                        {{ $unreadCount }}
                                    </span>
                                    @endif
                                </div>

                                @if($unreadCount > 0)
                                <form action="{{ route('notifications.markAllRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition">
                                        Tandai semua dibaca
                                    </button>
                                </form>
                                @endif
                            </div>

                            {{-- List --}}
                            <div class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700/70">
                                @forelse($notifications as $notification)
                                @php $isUnread = is_null($notification->read_at); @endphp

                                <a href="{{ route('notifications.read', $notification->id) }}"
                                    class="group flex items-start gap-3 px-4 py-3 transition
                      {{ $isUnread
                            ? 'bg-indigo-50/60 dark:bg-indigo-500/10 hover:bg-indigo-50 dark:hover:bg-indigo-500/20'
                            : 'hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">

                                    {{-- Ikon --}}
                                    <div class="shrink-0 mt-0.5 flex h-8 w-8 items-center justify-center rounded-full
                            {{ $isUnread
                                ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-300'
                                : 'bg-gray-100 text-gray-400 dark:bg-gray-700 dark:text-gray-500' }}">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                        </svg>
                                    </div>

                                    {{-- Teks --}}
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm leading-snug break-words
                              {{ $isUnread
                                    ? 'font-semibold text-gray-900 dark:text-gray-100'
                                    : 'font-normal text-gray-600 dark:text-gray-400' }}">
                                            {{ $notification->data['pesan'] ?? 'Notifikasi baru' }}
                                        </p>
                                        <p class="mt-1 text-[11px] text-gray-400 dark:text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                    {{-- Titik belum dibaca --}}
                                    @if($isUnread)
                                    <span class="shrink-0 mt-2 h-2 w-2 rounded-full bg-indigo-500"></span>
                                    @endif
                                </a>
                                @empty
                                <div class="flex flex-col items-center justify-center px-4 py-10 text-center">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                        </svg>
                                    </div>
                                    <p class="mt-3 text-sm font-medium text-gray-600 dark:text-gray-300">Belum ada notifikasi</p>
                                    <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Semua kabar terbaru akan muncul di sini.</p>
                                </div>
                                @endforelse
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Tombol Sakelar Dark Mode -->
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2 transition">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-white focus:outline-none transition duration-150">
                            <div>{{ Auth::user()->nama_lengkap }} ({{ Auth::user()->role }})</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="dark:text-gray-300 dark:hover:bg-gray-700">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="dark:text-gray-300 dark:hover:bg-gray-700">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>

<script>
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    var themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn.addEventListener('click', function() {
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    });
</script>