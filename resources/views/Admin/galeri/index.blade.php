@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Galeri Foto</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola foto galeri yang ditampilkan di halaman publik.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-teal-600 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Pengaturan
            </a>
            <a href="{{ route('admin.galeri.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#036672] text-white text-sm font-medium rounded-lg hover:bg-[#036672] transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Foto
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl text-green-800 dark:text-green-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid Galeri --}}
    @if($galeris->isEmpty())
        <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-400 dark:text-gray-500">Belum ada foto galeri. Tambahkan foto pertama.</p>
            <a href="{{ route('admin.galeri.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-[#036672] text-white text-sm rounded-lg hover:bg-[#036672]">Tambah Foto</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($galeris as $item)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden group">
                <div class="relative aspect-video">
                    @if($item->foto)
                        <img src="{{ asset('storage/galeri/' . $item->foto) }}" alt="{{ $item->judul }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/></svg>
                        </div>
                    @endif
                    <div class="absolute top-2 right-2">
                        <span class="inline-block px-2 py-0.5 text-xs rounded-full {{ $item->is_active ? 'bg-[#036672] text-white' : 'bg-gray-400 text-white' }}">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>

                <div class="p-3">
                    <p class="font-semibold text-sm text-gray-900 dark:text-white truncate">{{ $item->judul }}</p>
                    @if($item->kategori)
                        <p class="text-xs text-teal-600 dark:text-teal-400 mt-0.5">{{ $item->kategori }}</p>
                    @endif

                    <div class="flex items-center gap-2 mt-3">
                        <a href="{{ route('admin.galeri.edit', $item) }}"
                           class="flex-1 text-center py-1.5 text-xs font-medium rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.galeri.destroy', $item) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-1.5 text-xs font-medium rounded-lg bg-red-50 text-red-700 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
