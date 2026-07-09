<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Tambah Barang Baru') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-semibold text-gray-900">Formulir Identifikasi Barang</h3>
                    <p class="text-xs text-gray-500">Pastikan informasi yang Anda masukkan sudah benar dan sesuai dengan fisik barang.</p>
                </div>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="code" class="block text-sm font-bold text-gray-700 mb-2">Kode Barang</label>
                            <input type="text" name="code" id="code" value="{{ old('code') }}" required placeholder="Contoh: BRG-001" class="w-full px-4 py-2.5 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150 @error('code') border-rose-500 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            @error('code')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Barang</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Laptop ASUS ROG" class="w-full px-4 py-2.5 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150 @error('name') border-rose-500 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            @error('name')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="category_id" id="category_id" required class="w-full px-4 py-2.5 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150 @error('category_id') border-rose-500 focus:border-rose-500 focus:ring-rose-200 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">Jumlah Stok</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" required min="0" class="w-full px-4 py-2.5 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150 @error('stock') border-rose-500 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            @error('stock')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Lokasi Penyimpanan</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" required placeholder="Contoh: Gudang A - Rak 2" class="w-full px-4 py-2.5 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150 @error('location') border-rose-500 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            @error('location')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="condition" class="block text-sm font-bold text-gray-700 mb-2">Kondisi Barang</label>
                            <select name="condition" id="condition" required class="w-full px-4 py-2.5 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150 @error('condition') border-rose-500 focus:border-rose-500 focus:ring-rose-200 @enderror">
                                <option value="baik" {{ old('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak_ringan" {{ old('condition') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak_berat" {{ old('condition') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            @error('condition')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    
                    <div>
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Gambar Barang (Opsional)</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full px-4 py-2 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring rounded-xl text-sm transition-all duration-150 @error('image') border-rose-500 @enderror">
                        <p class="text-xs text-gray-400 mt-1">Maksimal ukuran file: 2MB. Format: jpeg, png, jpg, webp.</p>
                        @error('image')
                            <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition duration-150">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-accent-600 hover:bg-accent-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-accent transition duration-150">
                            Simpan Barang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
