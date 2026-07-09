<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Catat Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-semibold text-gray-900">Formulir Peminjaman</h3>
                    <p class="text-xs text-gray-500">Silakan pilih peminjam dan daftarkan barang-barang yang akan dipinjam.</p>
                </div>

                @if(session('error'))
                    <div class="m-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 flex items-center space-x-3 text-sm">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('borrowings.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="user_id" class="block text-sm font-bold text-gray-700 mb-2">Nama Peminjam</label>
                            <select name="user_id" id="user_id" required class="w-full px-4 py-2.5 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150 @error('user_id') border-rose-500 @enderror">
                                <option value="">Pilih Peminjam (Staff/User)</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ ucfirst($user->role->name ?? 'User') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="borrow_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pinjam</label>
                            <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', now()->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150 @error('borrow_date') border-rose-500 @enderror">
                            @error('borrow_date')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    
                    <div x-data="{ items: {{ old('items') ? json_encode(old('items')) : '[{product_id: \'\', quantity: 1}]' }} }" class="space-y-4 pt-6 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-700">Daftar Barang yang Dipinjam</span>
                            <button type="button" @click="items.push({product_id: '', quantity: 1})" class="text-xs font-semibold text-indigo-600 hover:text-indigo-900 flex items-center space-x-1">
                                <span>+ Tambah Item Barang</span>
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 items-end md:items-center bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                    
                                    <div class="w-full md:flex-grow">
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Barang</label>
                                        <select x-model="item.product_id" :name="'items['+index+'][product_id]'" required class="w-full px-3 py-2 bg-white border-gray-200 rounded-xl text-sm focus:border-accent-500 focus:ring-opacity-50">
                                            <option value="">Pilih Barang</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->name }} (Kode: {{ $product->code }}, Stok: {{ $product->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    
                                    <div class="w-full md:w-32">
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah</label>
                                        <input type="number" x-model="item.quantity" :name="'items['+index+'][quantity]'" min="1" required class="w-full px-3 py-2 bg-white border-gray-200 rounded-xl text-sm focus:border-accent-500 focus:ring-opacity-50">
                                    </div>

                                    
                                    <div class="shrink-0">
                                        <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="text-xs font-semibold text-rose-600 hover:text-rose-900 md:mb-2 py-2 px-1">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        @error('items')
                            <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('borrowings.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition duration-150">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-accent-600 hover:bg-accent-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-accent transition duration-150">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
