<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Si Inventaris Telkom — Manajemen Inventaris Mudah & Simpel</title>

        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 transition-colors duration-300">
        
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="min-h-screen flex flex-col justify-between relative overflow-hidden">
            
            <header class="w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center z-10">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-orange-550 to-orange-500 flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-orange-500/20">
                        Si
                    </div>
                    <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        Si Inventaris Telkom
                    </span>
                </div>
                
                <div class="flex items-center space-x-4">
                    

                    @if (Route::has('login'))
                        <div class="flex items-center space-x-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-orange-500 hover:bg-orange-650 text-white rounded-xl text-sm font-semibold shadow-md shadow-orange-500/10 transition-all duration-150">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-orange-500 transition duration-150">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-semibold transition-all duration-150">
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </header>

            
            <main class="w-full max-w-7xl mx-auto px-6 py-12 md:py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center z-10 flex-grow">
                <div class="space-y-8 max-w-2xl">
                    <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-600 text-xs font-semibold uppercase tracking-wider">
                        <span>🏢 Telkomsel Corporate Domain Enforced</span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-none text-gray-900">
                        Sistem Inventaris <span class="bg-gradient-to-r from-orange-550 via-orange-500 to-amber-500 bg-clip-text text-transparent">Simpel & Santai</span> Untuk Telkom.
                    </h1>
                    
                    <p class="text-base text-gray-500 leading-relaxed">
                        Kelola data barang operasional Telkom dengan cara yang ringkas, ramah pengguna, dan cepat layaknya berbelanja online. Akses dibatasi khusus bagi pemegang email dengan domain resmi <strong>@telkomsel.id</strong>.
                    </p>

                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold shadow-lg shadow-orange-500/25 transition-all text-center">
                                Buka Dasbor Si Inventaris
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold shadow-lg shadow-orange-500/25 transition-all text-center">
                                Log In Karyawan
                            </a>
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl font-bold transition-all text-center">
                                Daftar Akun Baru
                            </a>
                        @endauth
                    </div>

                    
                    <div class="grid grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                        <div>
                            <span class="block text-xl font-extrabold text-gray-900">@telkomsel.id</span>
                            <span class="text-xs text-gray-400">Verifikasi Domain</span>
                        </div>
                        <div>
                            <span class="block text-xl font-extrabold text-gray-900">Mudah & Santai</span>
                            <span class="text-xs text-gray-400">Gaya Belanja Simpel</span>
                        </div>
                        <div>
                            <span class="block text-xl font-extrabold text-gray-900">Hak Akses</span>
                            <span class="text-xs text-gray-400">Keyword Nama Akun</span>
                        </div>
                    </div>
                </div>

                
                <div class="relative lg:ml-12">
                    <div class="absolute -inset-1 bg-gradient-to-tr from-orange-500 to-amber-500 rounded-2xl blur-lg opacity-30 animate-pulse"></div>
                    <div class="relative bg-white border border-gray-150 rounded-2xl shadow-2xl p-6 overflow-hidden">
                        
                        <div class="flex items-center space-x-2 mb-6 border-b border-gray-100 pb-3">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-xs text-gray-450 font-mono ml-4 select-none">si-inventaris-telkom.app</span>
                        </div>

                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <span class="text-xs text-gray-450 font-semibold block mb-1">Total Unit Barang</span>
                                    <span class="text-xl font-extrabold text-orange-600">100 unit</span>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <span class="text-xs text-gray-450 font-semibold block mb-1">User Aktif</span>
                                    <span class="text-xl font-extrabold text-orange-600">3 Akun Resmi</span>
                                </div>
                            </div>

                            
                            <div class="p-3.5 bg-orange-500/5 border border-orange-500/10 rounded-xl flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></div>
                                    <div>
                                        <h4 class="text-xs font-bold">staff.telkomsel@telkomsel.id</h4>
                                        <p class="text-[10px] text-gray-450">Hak Akses: Staff (Sesuai nama)</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-orange-600 bg-orange-500/10 px-2 py-0.5 rounded-full">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            
            <footer class="w-full max-w-7xl mx-auto px-6 py-8 border-t border-gray-150 flex flex-col md:flex-row justify-between items-center gap-4 z-10">
                <p class="text-xs text-gray-500">
                    &copy; 2026 Si Inventaris Telkom. Hak Cipta Dilindungi Undang-Undang.
                </p>
                <div class="flex space-x-6 text-xs text-gray-500">
                    <span>Telkomsel Domain</span>
                    <span>Admin • Staff • Manager</span>
                </div>
            </footer>
        </div>

        
    </body>
</html>
