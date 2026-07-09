<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Sistem Manajemen Inventaris Telkom - Platform premium untuk pengelolaan data barang dan transaksi peminjaman.">
        <meta name="author" content="Telkom Indonesia">

        <title>{{ isset($title) ? $title . ' - Si Inventaris Telkom' : 'Si Inventaris Telkom' }}</title>

        
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    </head>
    <body class="font-sans antialiased" data-role="{{ Auth::user()->role->name ?? 'admin' }}">
        
        @php
            $alertTypes = ['success', 'error', 'warning', 'info'];
            $colors = [
                'success' => 'bg-white border-emerald-100 text-emerald-800 shadow-emerald-500/5',
                'error' => 'bg-white border-rose-100 text-rose-800 shadow-rose-500/5',
                'warning' => 'bg-white border-amber-100 text-amber-800 shadow-amber-500/5',
                'info' => 'bg-white border-blue-100 text-blue-800 shadow-blue-500/5',
            ];
            $icons = [
                'success' => '<svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                'error' => '<svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                'warning' => '<svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
                'info' => '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            ];
        @endphp

        <div class="fixed top-4 right-4 z-50 space-y-3 pointer-events-none max-w-sm w-full">
            @foreach ($alertTypes as $type)
                @if (session($type))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 5000)"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="transform translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                         x-transition:enter-end="transform translate-y-0 opacity-100 sm:translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="pointer-events-auto flex items-center p-4 rounded-xl border border-gray-100 {{ $colors[$type] }} shadow-lg transition-all duration-300" 
                         role="alert">
                        <div class="shrink-0 mr-3">
                            {!! $icons[$type] !!}
                        </div>
                        <div class="flex-1 text-sm font-semibold text-gray-700">
                            {{ session($type) }}
                        </div>
                        <button @click="show = false" class="ml-3 shrink-0 text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
            @endforeach
        </div>

        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-50 flex">

            
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"
                 style="display: none;"></div>

            
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 z-50 w-[260px] bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col">

                
                <div class="flex items-center justify-between h-16 px-5 border-b border-gray-100 shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5">
                        <x-application-logo class="block h-8 w-auto" />
                        <span class="text-base font-bold tracking-tight text-gray-900">Si Inventaris</span>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                
                <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                    <p class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Menu Utama</p>

                    
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
                        Dashboard
                    </x-sidebar-link>

                    
                    <x-sidebar-link :href="route('products.index')" :active="request()->routeIs('products.index') || request()->routeIs('products.show')" icon="products">
                        Daftar Barang
                    </x-sidebar-link>

                    
                    @if(Auth::user()->isAdmin())
                        <x-sidebar-link :href="route('products.create')" :active="request()->routeIs('products.create')" icon="add">
                            Tambah Barang
                        </x-sidebar-link>
                    @endif

                    
                    @if(Auth::user()->isAdmin())
                        <x-sidebar-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" icon="categories">
                            Kategori
                        </x-sidebar-link>
                    @endif

                    <p class="px-3 mt-6 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Transaksi</p>

                    
                    <x-sidebar-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.index') || request()->routeIs('borrowings.show')" icon="borrowings">
                        Peminjaman
                    </x-sidebar-link>

                    
                    @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                        <x-sidebar-link :href="route('borrowings.create')" :active="request()->routeIs('borrowings.create')" icon="record">
                            Catat Peminjaman
                        </x-sidebar-link>
                    @endif

                    
                    @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                        <p class="px-3 mt-6 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Laporan</p>
                        <x-sidebar-link :href="route('borrowings.export')" :active="false" icon="export">
                            Ekspor Laporan
                        </x-sidebar-link>
                    @endif
                </nav>

                
                <div class="shrink-0 border-t border-gray-100 p-3">
                    <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" icon="profile">
                        Profil Saya
                    </x-sidebar-link>
                </div>
            </aside>

            
            <div class="flex-1 flex flex-col min-w-0">
                
                <header class="sticky top-0 z-30 h-16 bg-white/80 backdrop-blur-xl border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 shrink-0">
                    
                    <div class="flex items-center space-x-3">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                    </div>

                    
                    <div class="flex items-center space-x-3">
                        
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-gray-100 transition duration-150">
                                <div class="w-8 h-8 rounded-lg bg-accent-500/20 flex items-center justify-center">
                                    <span class="text-sm font-bold text-accent-600">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                                <div class="hidden sm:flex flex-col items-start">
                                    <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                                </div>
                                
                                @if(Auth::user()->isAdmin())
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-indigo-50 text-indigo-600">ADMIN</span>
                                @elseif(Auth::user()->isStaff())
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-600">STAFF</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-50 text-amber-600">MANAGER</span>
                                @endif
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            
                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50"
                                 style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                
                <main class="flex-1 overflow-y-auto">
                    
                    @isset($header)
                        <div class="bg-white border-b border-gray-100">
                            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </div>
                    @endisset

                    {{ $slot }}
                </main>

                
                <footer class="shrink-0 border-t border-gray-100 bg-white py-4 px-6">
                    <p class="text-center text-xs text-gray-400">&copy; 2026 Si Inventaris Telkom. All rights reserved.</p>
                </footer>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Global Delete Confirmation with SweetAlert2
                document.addEventListener('submit', (e) => {
                    const form = e.target;
                    
                    const methodInput = form.querySelector('input[name="_method"]');
                    const isDelete = methodInput && methodInput.value.toUpperCase() === 'DELETE';
                    
                    if (isDelete && !form.dataset.confirmed) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        
                        let itemName = '';
                        const row = form.closest('tr');
                        if (row) {
                            // First try td with class truncate or semibold, or fallback to 3rd column
                            const nameEl = row.querySelector('td.font-semibold') || row.querySelector('td:nth-child(3)') || row.querySelector('td:nth-child(2)');
                            if (nameEl) itemName = nameEl.innerText.trim();
                        } else {
                            const h3 = document.querySelector('h3');
                            if (h3) itemName = h3.innerText.trim();
                        }
                        
                        const itemDisplay = itemName ? ` "${itemName}"` : '';
                        
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: `Data${itemDisplay} yang dihapus tidak dapat dikembalikan!`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#9ca3af',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            background: '#ffffff',
                            color: '#1f2937',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.dataset.confirmed = 'true';
                                form.submit();
                            }
                        });
                    }
                });

                // Global Form Submit Loading Indicator
                document.addEventListener('submit', (e) => {
                    const form = e.target;
                    if (form.checkValidity && !form.checkValidity()) return;
                    
                    const buttons = form.querySelectorAll('button[type="submit"]');
                    buttons.forEach(button => {
                        button.disabled = true;
                        button.classList.add('opacity-75', 'cursor-not-allowed');
                        
                        const hasSpinner = !button.querySelector('.animate-spin');
                        if (hasSpinner && button.innerText.trim().length > 0) {
                            button.innerHTML = `
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline-block align-text-bottom" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>${button.innerText}</span>
                            `;
                        }
                    });
                });
            });
        </script>
    </body>

</html>
