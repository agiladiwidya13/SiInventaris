<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Daftar Barang Inventaris') }}
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('products.create') }}" class="px-5 py-2.5 bg-accent-500 hover:bg-accent-600 text-white text-sm font-semibold rounded-xl shadow-md shadow-accent hover:-translate-y-0.5 transition-all duration-150">
                    + Tambah Barang
                </a>
            @endif
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
                <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    
                    <div class="md:col-span-2 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, kode, lokasi barang..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150">
                    </div>

                    
                    <div>
                        <select name="category_id" class="w-full py-2 px-4 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    
                    <div class="flex space-x-2">
                        <button type="submit" class="flex-grow py-2 bg-accent-500 hover:bg-accent-600 text-white rounded-xl text-sm font-semibold transition-all duration-150">
                            Filter
                        </button>
                        @if($search || $categoryId)
                            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-semibold transition-all duration-150 flex items-center justify-center">
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
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Gambar</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Kode</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Nama Barang</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Kategori</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Stok</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Kondisi</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Lokasi</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="p-4 text-sm">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-xl shadow-sm border border-gray-100">
                                        @else
                                            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm font-mono font-semibold text-accent-600">
                                        {{ $product->code }}
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-900">
                                        {{ $product->name }}
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">
                                        {{ $product->category->name }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        <span class="font-bold text-gray-900 {{ $product->stock < 5 ? 'text-rose-600 font-extrabold' : '' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm">
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
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">
                                        {{ $product->location }}
                                    </td>
                                    <td class="p-4 text-sm text-right space-x-2">
                                        <a href="{{ route('products.show', $product) }}" class="inline-flex items-center text-xs font-semibold text-gray-600 hover:text-gray-900">
                                            Detail
                                        </a>
                                        @if(Auth::user()->isAdmin())
                                            <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center text-xs font-semibold text-accent-600 hover:text-accent-700">
                                                Edit
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-900">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                            <p class="text-sm font-medium">Tidak ada barang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                
                @if($products->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
