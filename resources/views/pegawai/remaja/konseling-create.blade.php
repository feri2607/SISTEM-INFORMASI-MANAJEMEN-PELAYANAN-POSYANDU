{{-- resources/views/pegawai/remaja/konseling-create.blade.php --}}
@extends('layouts.app')

@section('title', 'Form Konseling - ' . $remaja->nama)
@section('page-title', '💬 Form Konseling')
@section('page-subtitle', $remaja->nama)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 px-6 py-5">
            <div class="flex items-center gap-4">
                <img src="{{ $remaja->foto_url }}" alt="{{ $remaja->nama }}"
                     class="w-14 h-14 rounded-full object-cover ring-3 ring-white/30">
                <div>
                    <h3 class="text-lg font-bold text-white">{{ $remaja->nama }}</h3>
                    <p class="text-purple-200 text-sm">{{ $remaja->umur }} tahun • {{ $remaja->jenis_kelamin_label }}</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('pegawai.remaja.konseling.store') }}"
              x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <input type="hidden" name="remaja_id" value="{{ $remaja->id }}">

            <div class="p-6 space-y-5">
                @if($errors->any())
                    <div class="p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg">
                        <ul class="text-sm text-red-700 dark:text-red-400 space-y-1">
                            @foreach($errors->all() as $err)
                                <li>• {{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Tanggal Konseling <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                           required max="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                {{-- Topik --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Topik Konseling <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $topiks = [
                                'Bullying' => '🛡️',
                                'Narkoba' => '🚫',
                                'Kesehatan Mental' => '🧠',
                                'Merokok' => '🚬',
                                'Gizi' => '🥗',
                                'Lainnya' => '📝',
                            ];
                        @endphp
                        @foreach($topiks as $topik => $icon)
                            <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-purple-50 dark:hover:bg-purple-900/20 transition
                                {{ old('topik') === $topik ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20' : 'border-gray-300 dark:border-gray-600' }}">
                                <input type="radio" name="topik" value="{{ $topik }}"
                                       {{ old('topik') === $topik ? 'checked' : '' }}
                                       class="text-purple-600 focus:ring-purple-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $icon }} {{ $topik }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('topik')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Catatan / Rekomendasi
                    </label>
                    <textarea name="catatan" rows="4"
                              placeholder="Isi catatan hasil konseling, saran, dan tindak lanjut..."
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none">{{ old('catatan') }}</textarea>
                </div>

                {{-- Pegawai --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Konselor</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <a href="{{ route('pegawai.remaja.show', $remaja) }}"
                   class="px-5 py-2.5 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" :disabled="loading"
                        class="px-6 py-2.5 bg-[#036672] hover:bg-[#036672] disabled:opacity-50 text-white rounded-xl text-sm font-semibold transition flex items-center gap-2">
                    <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span x-text="loading ? 'Menyimpan...' : '💾 Simpan Konseling'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
