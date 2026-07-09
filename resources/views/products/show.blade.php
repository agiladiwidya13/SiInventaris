<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Detail Barang') }}
            </h2>
            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition duration-150">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="md:flex">
                    
                    <div class="md:w-1/3 bg-gray-50 p-8 flex items-center justify-center border-r border-gray-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-w-full h-auto object-contain rounded-2xl shadow-lg border border-gray-100">
                        @else
                            <div class="w-full aspect-square rounded-2xl bg-gray-150 flex flex-col items-center justify-center text-gray-400 p-6 border-2 border-dashed border-gray-200">
                                <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs">Tidak ada gambar</span>
                            </div>
                        @endif
                    </div>

                    
                    <div class="md:w-2/3 p-8 space-y-6">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100/50">
                                    {{ $product->category->name }}
                                </span>
                                @if($product->condition === 'baik')
                                    <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-600">
                                        Baik
                                    </span>
                                @elseif($product->condition === 'rusak_ringan')
                                    <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full bg-amber-500/10 text-amber-600">
                                        Rusak Ringan
                                    </span>
                                @else
                                    <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full bg-rose-500/10 text-rose-600">
                                        Rusak Berat
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mt-3">{{ $product->name }}</h3>
                            <span class="text-sm font-mono text-gray-500">{{ $product->code }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-6 pt-6 border-t border-gray-100">
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Stok Tersedia</span>
                                <p class="text-lg font-bold text-gray-900 mt-1">{{ $product->stock }} unit</p>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Lokasi Penyimpanan</span>
                                <p class="text-lg font-bold text-gray-900 mt-1">{{ $product->location }}</p>
                            </div>
                        </div>

                        @if(Auth::user()->isAdmin())
                            <div class="pt-6 border-t border-gray-100 flex space-x-3">
                                <a href="{{ route('products.edit', $product) }}" class="px-5 py-2.5 bg-accent-600 hover:bg-accent-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-accent transition duration-150">
                                    Ubah Informasi
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-rose-500/10 hover:shadow-rose-500/20 transition duration-150">
                                        Hapus Barang
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Peminjaman Barang</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="pb-3 text-xs font-bold uppercase text-gray-400 tracking-wider">Peminjam</th>
                                <th class="pb-3 text-xs font-bold uppercase text-gray-400 tracking-wider">Tanggal Pinjam</th>
                                <th class="pb-3 text-xs font-bold uppercase text-gray-400 tracking-wider">Tanggal Kembali</th>
                                <th class="pb-3 text-xs font-bold uppercase text-gray-400 tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $history = $product->borrowingDetails()->with('borrowing.user')->latest()->take(5)->get();
                            @endphp
                            @forelse($history as $histDetail)
                                <tr>
                                    <td class="py-3 text-sm font-semibold text-gray-900">
                                        {{ $histDetail->borrowing->user->name }}
                                    </td>
                                    <td class="py-3 text-sm text-gray-500">
                                        {{ $histDetail->borrowing->borrow_date->format('d M Y') }}
                                    </td>
                                    <td class="py-3 text-sm text-gray-500">
                                        {{ $histDetail->borrowing->return_date ? $histDetail->borrowing->return_date->format('d M Y') : '-' }}
                                    </td>
                                    <td class="py-3 text-sm">
                                        @if($histDetail->borrowing->status === 'dikembalikan')
                                            <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-600">
                                                Dikembalikan
                                            </span>
                                        @elseif($histDetail->borrowing->status === 'terlambat')
                                            <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-rose-500/10 text-rose-600">
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-amber-500/10 text-amber-600">
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-sm text-gray-400">
                                        Belum ada riwayat peminjaman untuk barang ini.
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
