<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Detail Peminjaman') }}
            </h2>
            <a href="{{ route('borrowings.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition duration-150">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-xs font-bold text-indigo-600 font-mono tracking-wider">KODE TRANSAKSI</span>
                        <h3 class="text-2xl font-bold text-gray-900 font-mono mt-1">#TX-{{ str_pad($borrowing->id, 5, '0', STR_PAD_LEFT) }}</h3>
                    </div>
                    <div>
                        @if($borrowing->status === 'dikembalikan')
                            <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-600 border border-emerald-100/50">
                                Dikembalikan
                            </span>
                        @elseif($borrowing->status === 'terlambat')
                            <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-rose-500/10 text-rose-600 border border-rose-100/50">
                                Terlambat
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-amber-500/10 text-amber-600 border border-amber-100/50">
                                Dipinjam
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-100">
                    <div>
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Nama Peminjam</span>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $borrowing->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $borrowing->user->email }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tanggal Peminjaman</span>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $borrowing->borrow_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tanggal Pengembalian</span>
                        <p class="text-sm font-semibold text-gray-900 mt-1">
                            {{ $borrowing->return_date ? $borrowing->return_date->format('d M Y') : 'Belum dikembalikan' }}
                        </p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Barang yang Dipinjam</h3>
                </div>

                
                @php
                    $isFormActive = in_array($borrowing->status, ['dipinjam', 'terlambat']) && (Auth::user()->isAdmin() || Auth::user()->isStaff());
                @endphp

                @if($isFormActive)
                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST">
                        @csrf
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/30">
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Kode Barang</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Nama Barang</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Kuantitas</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">
                                    {{ $isFormActive ? 'Kondisi Saat Dikembalikan' : 'Kondisi Setelah Peminjaman' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($borrowing->details as $detail)
                                <tr>
                                    <td class="p-4 text-sm font-mono font-semibold text-indigo-600">
                                        {{ $detail->product->code }}
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-900">
                                        {{ $detail->product->name }}
                                    </td>
                                    <td class="p-4 text-sm font-bold text-gray-900">
                                        {{ $detail->quantity }} unit
                                    </td>
                                    <td class="p-4 text-sm">
                                        @if($isFormActive)
                                            
                                            <select name="conditions[{{ $detail->id }}]" required class="px-3 py-1.5 bg-gray-50 border-gray-200 text-xs font-semibold rounded-lg">
                                                <option value="baik">Baik</option>
                                                <option value="rusak_ringan">Rusak Ringan</option>
                                                <option value="rusak_berat">Rusak Berat</option>
                                            </select>
                                        @else
                                            
                                            @if($borrowing->status === 'dikembalikan')
                                                @php
                                                    $cond = $detail->condition_after ?? 'baik';
                                                @endphp
                                                @if($cond === 'baik')
                                                    <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-600">Baik</span>
                                                @elseif($cond === 'rusak_ringan')
                                                    <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-amber-500/10 text-amber-600">Rusak Ringan</span>
                                                @else
                                                    <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-rose-500/10 text-rose-600">Rusak Berat</span>
                                                @endif
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($isFormActive)
                        
                        <div class="p-6 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                * Dengan memproses ini, stok fisik barang akan otomatis dikembalikan ke inventaris.
                            </div>
                            <button type="submit" class="px-5 py-2.5 bg-accent-600 hover:bg-accent-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-accent transition duration-150">
                                Proses Pengembalian Barang
                            </button>
                        </div>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
