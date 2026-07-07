{{-- resources/views/warga/kehamilan/create.blade.php --}}
@extends('layouts.public')

@section('hide-footer', true)

@section('title', 'Tambah Data Kehamilan')
@section('page-title', 'Tambah Data Kehamilan 🤰')
@section('page-subtitle', 'Masukkan informasi kehamilan Anda.')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <div class="p-6 bg-gradient-to-r from-pink-500 to-rose-500">
            <h3 class="text-lg font-bold text-white">Form Input Data Kehamilan</h3>
            <p class="text-pink-100 text-sm mt-1">Pastikan data yang diisi sesuai dengan buku KIA (Kesehatan Ibu dan Anak).</p>
        </div>

        <form action="{{ route('warga.kehamilan.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Data Pribadi --}}
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white border-b pb-2 mb-4">Informasi Identitas</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap Ibu <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', auth()->user()->name) }}" required
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIK <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Domisili</label>
                        <textarea name="alamat" rows="2"
                                  class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Data Kehamilan --}}
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white border-b pb-2 mb-4">Informasi Kehamilan</h4>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kehamilan Ke- <span class="text-red-500">*</span></label>
                            <input type="number" name="kehamilan_ke" value="{{ old('kehamilan_ke', 1) }}" min="1" required
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('kehamilan_ke') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Golongan Darah</label>
                            <select name="golongan_darah" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Pilih</option>
                                @foreach(['A', 'B', 'AB', 'O'] as $goldar)
                                    <option value="{{ $goldar }}" {{ old('golongan_darah') == $goldar ? 'selected' : '' }}>{{ $goldar }}</option>
                                @endforeach
                            </select>
                            @error('golongan_darah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">HPHT (Hari Pertama Haid Terakhir) <span class="text-red-500">*</span></label>
                        <input type="date" name="hpht" value="{{ old('hpht') }}" required max="{{ date('Y-m-d') }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <p class="text-xs text-gray-500 mt-1">HPL akan dihitung otomatis dari HPHT.</p>
                        @error('hpht') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Riwayat Penyakit</label>
                        <textarea name="riwayat_penyakit" rows="2" placeholder="Kosongkan jika tidak ada"
                                  class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('riwayat_penyakit') }}</textarea>
                        @error('riwayat_penyakit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Riwayat Alergi</label>
                        <textarea name="riwayat_alergi" rows="2" placeholder="Kosongkan jika tidak ada"
                                  class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('riwayat_alergi') }}</textarea>
                        @error('riwayat_alergi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Profil Kehamilan</label>
                        <input type="file" name="foto" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 dark:file:bg-gray-700 dark:file:text-white">
                        @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                <a href="{{ route('warga.kehamilan.index') }}"
                   class="px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-[#036672] hover:bg-[#036672] text-white rounded-xl font-medium shadow-sm transition">
                    💾 Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
