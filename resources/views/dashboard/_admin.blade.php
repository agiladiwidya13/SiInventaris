
<div class="bg-gradient-to-r from-indigo-500 via-indigo-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden text-white p-8 relative">
    <div class="absolute right-0 top-0 opacity-10 transform translate-x-12 -translate-y-8 pointer-events-none">
        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
    </div>
    <div class="max-w-xl z-10 relative">
        <h3 class="text-3xl font-extrabold mb-2 tracking-tight">Halo, {{ Auth::user()->name }}!</h3>
        <p class="text-indigo-100 text-sm leading-relaxed mb-4">
            Selamat datang di panel Admin. Kelola seluruh inventaris, peminjaman, dan pengguna dari sini.
        </p>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('products.create') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-200 backdrop-blur-sm">
                + Tambah Barang
            </a>
            <a href="{{ route('borrowings.create') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-200 backdrop-blur-sm">
                Catat Peminjaman
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Barang</p>
                <p class="text-3xl font-extrabold mt-2 text-gray-900">{{ $totalProducts }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Peminjaman Aktif</p>
                <p class="text-3xl font-extrabold mt-2 text-gray-900">{{ $activeBorrowingsCount }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Users</p>
                <p class="text-3xl font-extrabold mt-2 text-gray-900">{{ $totalUsers }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Stok Rendah</p>
                <p class="text-3xl font-extrabold mt-2 text-gray-900">{{ $lowStockProducts->count() }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-500/10 flex items-center justify-center text-rose-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Aktivitas Peminjaman</h3>
            <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">6 Bulan Terakhir</span>
        </div>
        <div class="h-80 w-full">
            <canvas id="borrowingsChart"></canvas>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Peringatan Stok</h3>
            <p class="text-xs text-gray-500">Barang dengan stok menipis (< 5 unit)</p>
        </div>

        <div class="space-y-4 max-h-[200px] overflow-y-auto">
            @forelse($lowStockProducts as $prod)
                <div class="flex items-center justify-between p-3 rounded-xl bg-rose-500/5 border border-rose-500/10">
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-900">{{ $prod->name }}</span>
                        <span class="text-xs text-gray-500">{{ $prod->code }}</span>
                    </div>
                    <span class="inline-block px-2.5 py-1 text-xs font-bold rounded-lg bg-rose-100 text-rose-800">
                        Stok: {{ $prod->stock }}
                    </span>
                </div>
            @empty
                <div class="text-center py-6 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm">Semua stok aman.</p>
                </div>
            @endforelse
        </div>

        
        <div class="pt-4 border-t border-gray-100">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi Cepat</span>
            <div class="grid grid-cols-2 gap-2 mt-2">
                <a href="{{ route('products.index') }}" class="py-2.5 px-3 bg-gray-50 hover:bg-gray-100 rounded-xl text-center text-xs font-semibold text-gray-700 transition duration-150">
                    Lihat Barang
                </a>
                <a href="{{ route('borrowings.index') }}" class="py-2.5 px-3 bg-gray-50 hover:bg-gray-100 rounded-xl text-center text-xs font-semibold text-gray-700 transition duration-150">
                    Transaksi
                </a>
            </div>
        </div>
    </div>
</div>

@if(isset($recentBorrowings) && $recentBorrowings->count() > 0)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900">5 Transaksi Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Peminjam</th>
                    <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Barang</th>
                    <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Tanggal</th>
                    <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($recentBorrowings as $borrowing)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="p-4 text-sm font-semibold text-gray-900">{{ $borrowing->user->name }}</td>
                    <td class="p-4 text-sm text-gray-500">
                        @foreach($borrowing->details as $detail)
                            <span>{{ $detail->product->name }} ({{ $detail->quantity }}x)</span>@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td class="p-4 text-sm text-gray-500">{{ $borrowing->borrow_date->format('d M Y') }}</td>
                    <td class="p-4 text-sm">
                        @if($borrowing->status === 'dikembalikan')
                            <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-600">Dikembalikan</span>
                        @elseif($borrowing->status === 'terlambat')
                            <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full bg-rose-500/10 text-rose-600">Terlambat</span>
                        @else
                            <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full bg-amber-500/10 text-amber-600">Dipinjam</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
