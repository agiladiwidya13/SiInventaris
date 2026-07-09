
<div class="bg-gradient-to-r from-emerald-500 via-emerald-600 to-emerald-700 rounded-2xl shadow-xl overflow-hidden text-white p-8 relative">
    <div class="absolute right-0 top-0 opacity-10 transform translate-x-12 -translate-y-8 pointer-events-none">
        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    </div>
    <div class="max-w-xl z-10 relative">
        <h3 class="text-3xl font-extrabold mb-2 tracking-tight">Halo, {{ Auth::user()->name }}!</h3>
        <p class="text-emerald-100 text-sm leading-relaxed mb-4">
            Selamat datang di panel Staff. Catat dan kelola peminjaman barang dari sini.
        </p>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('borrowings.create') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-200 backdrop-blur-sm">
                Catat Peminjaman Baru
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Peminjaman Aktif</p>
                <p class="text-3xl font-extrabold mt-2 text-gray-900">{{ $myActiveBorrowings ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Barang Tersedia</p>
                <p class="text-3xl font-extrabold mt-2 text-gray-900">{{ $availableProducts ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dikembalikan</p>
                <p class="text-3xl font-extrabold mt-2 text-gray-900">{{ $myReturnedBorrowings ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>
</div>

@if(isset($recentBorrowings) && $recentBorrowings->count() > 0)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900">5 Peminjaman Terakhir</h3>
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
