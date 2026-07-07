{{-- resources/views/pegawai/remaja/konseling-edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Konseling - ' . $konseling->remaja->nama)
@section('page-title', '✏️ Edit Konseling')
@section('page-subtitle', $konseling->remaja->nama . ' — ' . $konseling->tanggal->format('d M Y'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 px-6 py-5">
            <div class="flex items-center gap-4">
                <img src="{{ $konseling->remaja->foto_url }}" alt="{{ $konseling->remaja->nama }}"
                     class="w-14 h-14 rounded-full object-cover ring-3 ring-white/30">
                <div>
                    <h3 class="text-lg font-bold text-white">{{ $konseling->remaja->nama }}</h3>
                    <p class="text-purple-200 text-sm">Edit konseling tanggal {{ $konseling->tanggal->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('pegawai.remaja.konseling.update', $konseling) }}">
            @csrf @method('PUT')
            <input type="hidden" name="remaja_id" value="{{ $konseling->remaja_id }}">

            <div class="p-6 space-y-5">
                @if($errors->any())
                    <div class="p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg">
                        <ul class="text-sm text-red-700 dark:text-red-400 space-y-1">
                            @foreach($errors->all() as $err) <li>• {{ $err }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" required max="{{ date('Y-m-d') }}"
                           value="{{ old('tanggal', $konseling->tanggal->format('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Topik <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $topiks = ['Bullying' => '🛡️', 'Narkoba' => '🚫', 'Kesehatan Mental' => '🧠', 'Merokok' => '🚬', 'Gizi' => '🥗', 'Lainnya' => '📝'];
                        @endphp
                        @foreach($topiks as $topik => $icon)
                            <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-purple-50 dark:hover:bg-purple-900/20 transition
                                {{ old('topik', $konseling->topik) === $topik ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20' : 'border-gray-300 dark:border-gray-600' }}">
                                <input type="radio" name="topik" value="{{ $topik }}"
                                       {{ old('topik', $konseling->topik) === $topik ? 'checked' : '' }}
                                       class="text-purple-600 focus:ring-purple-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $icon }} {{ $topik }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('topik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Catatan / Rekomendasi</label>
                    <textarea name="catatan" rows="4"
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none">{{ old('catatan', $konseling->catatan) }}</textarea>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <a href="{{ route('pegawai.remaja.show', $konseling->remaja) }}"
                   class="px-5 py-2.5 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-[#036672] hover:bg-[#036672] text-white rounded-xl text-sm font-semibold transition">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
