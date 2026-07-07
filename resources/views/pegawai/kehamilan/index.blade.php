{{-- resources/views/pegawai/kehamilan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Ibu Hamil')
@section('page-title', 'Data Ibu Hamil 👥')
@section('page-subtitle', 'Kelola informasi identitas dan kehamilan warga.')

@section('content')
<div class="space-y-6">

    {{-- Filters --}}
    <form action="{{ route('pegawai.kehamilan.index') }}" method="GET" class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-4 mb-4">
        <div class="flex-1">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-pink-500">
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        <div class="w-full md:w-48">
            <select name="risiko" class="w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-pink-500">
                <option value="">Semua Risiko</option>
                <option value="tinggi" {{ request('risiko') === 'tinggi' ? 'selected' : '' }}>Risiko Tinggi</option>
                <option value="normal" {{ request('risiko') === 'normal' ? 'selected' : '' }}>Normal</option>
            </select>
        </div>
        <div class="w-full md:w-48">
            <select name="status" class="w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-pink-500">
                <option value="">Status Verifikasi</option>
                <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <div class="w-full md:w-auto flex gap-2">
            <button type="submit" class="flex-1 md:flex-none px-6 py-2.5 bg-gray-800 hover:bg-gray-900 text-white rounded-xl text-sm font-medium transition">
                Filter
            </button>
            <a href="{{ route('pegawai.kehamilan.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-medium transition">Reset</a>
        </div>
    </form>

    {{-- Data Table --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Ibu Hamil</th>
                        <th class="px-6 py-4 font-semibold">Usia K. / HPL</th>
                        <th class="px-6 py-4 font-semibold">Info Risiko</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($list as $k)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                         <img src="{{ $k->foto_url }}" class="w-10 h-10 rounded-full object-cover shadow-sm bg-gray-100">
                                         @if(!$k->is_verified)
                                             <span class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 border-2 border-white rounded-full"></span>
                                         @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $k->nama }}</div>
                                        <div class="text-xs text-gray-500 flex gap-2"><span>{{ $k->umur }} thn</span>•<span>Ke-{{ $k->kehamilan_ke }}</span></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs bg-pink-50 text-pink-700 rounded px-2 py-1 inline-block mb-1 border border-pink-100 font-semibold">
                                    Mgg ke-{{ $k->usia_kehamilan_in_minggu ?? '0' }}
                                </div>
                                <div class="text-gray-500 text-xs mt-1"><span class="font-medium text-gray-700">HPL:</span> {{ $k->hpl_formatted }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-lg {{ $k->status_risiko_badge }} border">
                                    {{ $k->status_risiko_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($k->is_verified)
                                    <span class="text-xs font-medium text-emerald-600 flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Verified</span>
                                @else
                                    <span class="text-xs font-medium text-yellow-600 flex items-center gap-1"><svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg> Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('pegawai.kehamilan.show', $k) }}" 
                                   class="inline-flex items-center gap-2 py-1.5 px-4 rounded-xl text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                    Lihat Detail & ANC
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                                <div class="text-4xl mb-3">📁</div>
                                <h4 class="text-lg font-bold">Data Kosong</h4>
                                <p class="text-sm mt-1">Tidak ada ibu hamil yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($list->hasPages())
           <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
               {{ $list->links() }}
           </div>
        @endif
    </div>
</div>
@endsection
