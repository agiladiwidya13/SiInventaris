<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Daftar Kategori') }}
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('categories.create') }}" class="px-5 py-2.5 bg-accent-600 hover:bg-accent-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-accent hover:-translate-y-0.5 transition-all duration-150">
                    + Tambah Kategori
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

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <form action="{{ route('categories.index') }}" method="GET" class="flex items-center space-x-2">
                    <div class="relative flex-grow">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama kategori..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border-gray-200 focus:border-accent-500 focus:ring focus:ring-accent-500/20 rounded-xl text-sm transition-all duration-150">
                    </div>
                    <button type="submit" class="px-5 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-xl text-sm font-semibold transition-all duration-150">
                        Cari
                    </button>
                    @if($search)
                        <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-semibold transition-all duration-150">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider w-16">No</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Nama Kategori</th>
                                <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider w-40 text-center">Jumlah Barang</th>
                                @if(Auth::user()->isAdmin())
                                    <th class="p-4 text-xs font-bold uppercase text-gray-500 tracking-wider w-48 text-right">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($categories as $index => $category)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="p-4 text-sm font-medium text-gray-500">
                                        {{ $categories->firstItem() + $index }}
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-900">
                                        {{ $category->name }}
                                    </td>
                                    <td class="p-4 text-sm text-center">
                                        <span class="inline-flex px-2.5 py-1 text-xs font-bold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100/50">
                                            {{ $category->products_count }} unit
                                        </span>
                                    </td>
                                    @if(Auth::user()->isAdmin())
                                        <td class="p-4 text-sm text-right space-x-2">
                                            <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-900">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->isAdmin() ? 4 : 3 }}" class="p-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                            <p class="text-sm font-medium">Tidak ada kategori ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                
                @if($categories->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
