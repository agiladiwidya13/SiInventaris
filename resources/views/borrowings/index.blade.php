<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Transaksi Peminjaman Barang') }}
            </h2>
            <div class="flex items-center space-x-2">
                
                @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                    <a href="{{ route('borrowings.export', ['status' => request('status'), 'search' => request('search')]) }}" class="px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 text-sm font-semibold rounded-xl shadow-sm hover:-translate-y-0.5 transition-all duration-150 flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Export CSV</span>
                    </a>
                @endif

                
                @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                    <a href="{{ route('borrowings.create') }}" class="px-5 py-2.5 bg-accent-500 hover:bg-accent-600 text-white text-sm font-semibold rounded-xl shadow-md shadow-accent hover:-translate-y-0.5 transition-all duration-150">
                        Catat Peminjaman
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 flex items-center space-x-3 text-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 flex items-center space-x-3 text-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('borrowings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    
                    <div class="md:col-span-2 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama peminjam atau barang..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150">
                    </div>

                    
                    <div>
                        <select name="status" class="w-full py-2 px-4 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150">
                            <option value="">Semua Status</option>
                            <option value="dipinjam" {{ $status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ $status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="terlambat" {{ $status == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>

                    
                    <div class="flex space-x-2">
                        <button type="submit" class="flex-grow py-2 bg-accent-500 hover:bg-accent-600 text-white rounded-xl text-sm font-semibold transition-all duration-150">
                            Filter
                        </button>
                        @if($search || $status)
                            <a href="{{ route('borrowings.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-semibold transition-all duration-150 flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">No Transaksi</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Peminjam</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Barang</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Tanggal Pinjam</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Tanggal Kembali</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Status</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($borrowings as $borrowing)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="p-4 text-sm font-semibold text-accent-600 font-mono">
                                        #TX-{{ str_pad($borrowing->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-gray-900">{{ $borrowing->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $borrowing->user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm text-gray-700 max-w-xs truncate">
                                        @foreach($borrowing->details as $detail)
                                            <div class="truncate">
                                                • {{ $detail->product->name }} <span class="font-bold">({{ $detail->quantity }}x)</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">
                                        {{ $borrowing->borrow_date->format('d M Y') }}
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">
                                        {{ $borrowing->return_date ? $borrowing->return_date->format('d M Y') : '-' }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        @if($borrowing->status === 'dikembalikan')
                                            <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-600 border border-emerald-100/50">
                                                Dikembalikan
                                            </span>
                                        @elseif($borrowing->status === 'terlambat')
                                            <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full bg-rose-500/10 text-rose-600 border border-rose-100/50">
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full bg-amber-500/10 text-amber-600 border border-amber-100/50">
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-right">
                                        <a href="{{ route('borrowings.show', $borrowing) }}" class="px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-xs font-semibold text-gray-700 rounded-lg transition-all duration-150">
                                            Detail & Aksi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <p class="text-sm font-medium">Tidak ada transaksi peminjaman ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                
                @if($borrowings->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $borrowings->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
