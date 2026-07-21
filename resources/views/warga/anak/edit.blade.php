@extends('layouts.public')
@section('title', 'Edit Data Anak - ' . $anak->nama)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Profil Saya
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Data Anak</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui data anak: <strong>{{ $anak->nama }}</strong></p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
        <form action="{{ route('profile.anak.update', $anak) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">

                {{-- Nama Anak --}}
                <div>
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Anak <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $anak->nama) }}"
                           class="w-full px-4 py-2.5 border @error('nama') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="Nama lengkap anak">
                    @error('nama')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIK Anak --}}
                <div>
                    <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        NIK Anak <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik', $anak->nik) }}" maxlength="16"
                           class="w-full px-4 py-2.5 border @error('nik') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="16 digit NIK">
                    @error('nik')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                           value="{{ old('tanggal_lahir', $anak->tanggal_lahir->toDateString()) }}"
                           max="{{ now()->toDateString() }}"
                           class="w-full px-4 py-2.5 border @error('tanggal_lahir') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    @error('tanggal_lahir')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-400">Umur saat ini: <strong>{{ $anak->umur_label }}</strong>
                        @if($anak->is_balita) — <span class="text-blue-600 font-semibold">termasuk Balita</span>@endif
                    </p>
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="L"
                                   {{ old('jenis_kelamin', $anak->jenis_kelamin) === 'L' ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="P"
                                   {{ old('jenis_kelamin', $anak->jenis_kelamin) === 'P' ? 'checked' : '' }}
                                   class="w-4 h-4 text-pink-500 border-gray-300 focus:ring-pink-500">
                            <span class="text-sm text-gray-700">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Anak --}}
                <div>
                    <label for="status_anak" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Status Anak
                    </label>
                    <select id="status_anak" name="status_anak"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                        <option value="aktif" {{ old('status_anak', $anak->status_anak) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status_anak', $anak->status_anak) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

            </div>

            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('profile.index') }}"
                   class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
