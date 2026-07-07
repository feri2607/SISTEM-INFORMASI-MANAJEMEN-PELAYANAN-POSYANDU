@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Struktur Organisasi</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola data pengurus dan kader yang ditampilkan di halaman Tentang Kami.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-teal-600 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Pengaturan
            </a>
            <a href="{{ route('admin.struktur-organisasi.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#036672] text-white text-sm font-medium rounded-lg hover:bg-[#036672] transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengurus
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl text-green-800 dark:text-green-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        @if($strukturs->isEmpty())
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                </svg>
                <p class="text-gray-400 dark:text-gray-500">Belum ada data pengurus. Tambahkan pengurus pertama.</p>
                <a href="{{ route('admin.struktur-organisasi.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-[#036672] text-white text-sm rounded-lg hover:bg-[#036672]">Tambah Pengurus</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Foto</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Nama & Jabatan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Urutan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($strukturs as $i => $s)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                @if($s->foto)
                                    <img src="{{ asset('storage/struktur/' . $s->foto) }}" alt="{{ $s->nama }}"
                                         class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama) }}&color=7F9CF5&background=EBF4FF&size=60"
                                         alt="{{ $s->nama }}" class="w-10 h-10 rounded-full">
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $s->nama }}</p>
                                <p class="text-xs text-teal-600 dark:text-teal-400">{{ $s->jabatan }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $s->urutan }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $s->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                    {{ $s->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.struktur-organisasi.edit', $s) }}"
                                       class="px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.struktur-organisasi.destroy', $s) }}" method="POST"
                                          onsubmit="return confirm('Hapus pengurus ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-red-50 text-red-700 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
