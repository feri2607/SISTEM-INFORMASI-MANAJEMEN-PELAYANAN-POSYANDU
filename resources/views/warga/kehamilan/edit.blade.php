{{-- resources/views/warga/kehamilan/edit.blade.php --}}
@extends('layouts.public')

@section('hide-footer', true)

@section('title', 'Edit Data Kehamilan')
@section('page-title', 'Edit Data Kehamilan ✏️')
@section('page-subtitle', 'Ubah informasi kehamilan Anda ')

@section('content')
<div class="max-w-3xl mx-auto">
    
    @if($kehamilan->is_verified)
        <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl border border-yellow-200 dark:border-yellow-700 flex items-start gap-4">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div>
                <h4 class="font-bold text-yellow-800 dark:text-yellow-400">Data Telah Diverifikasi</h4>
                <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">Anda tidak dapat mengubah data administrasi karena telah diverifikasi oleh Pegawai Posyandu. Silakan hubungi petugas jika ada perubahan data penting.</p>
                <div class="mt-3">
                    <a href="{{ route('warga.kehamilan.index') }}" class="px-4 py-2 bg-white dark:bg-gray-800 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            
            <div class="p-6 bg-gradient-to-r from-pink-500 to-rose-500">
                <h3 class="text-lg font-bold text-white">Form Edit Data Kehamilan</h3>
            </div>

            <form action="{{ route('warga.kehamilan.update', $kehamilan) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
                {{-- Form fields (identical to create but with pre-filled data) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Data Pribadi --}}
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white border-b pb-2 mb-4">Informasi Identitas</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap Ibu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $kehamilan->nama) }}" required
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" value="{{ old('nik', $kehamilan->nik) }}" required maxlength="16"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $kehamilan->tanggal_lahir?->format('Y-m-d')) }}" required
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $kehamilan->no_hp) }}"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Domisili</label>
                            <textarea name="alamat" rows="2"
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('alamat', $kehamilan->alamat) }}</textarea>
                        </div>
                    </div>

                    {{-- Data Kehamilan --}}
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white border-b pb-2 mb-4">Informasi Kehamilan</h4>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kehamilan Ke- <span class="text-red-500">*</span></label>
                                <input type="number" name="kehamilan_ke" value="{{ old('kehamilan_ke', $kehamilan->kehamilan_ke) }}" min="1" required
                                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Golongan Darah</label>
                                <select name="golongan_darah" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Pilih</option>
                                    @foreach(['A', 'B', 'AB', 'O'] as $goldar)
                                        <option value="{{ $goldar }}" {{ old('golongan_darah', $kehamilan->golongan_darah) == $goldar ? 'selected' : '' }}>{{ $goldar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">HPHT (Hari Pertama Haid Terakhir) <span class="text-red-500">*</span></label>
                            <input type="date" name="hpht" value="{{ old('hpht', $kehamilan->hpht?->format('Y-m-d')) }}" required max="{{ date('Y-m-d') }}"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <p class="text-xs text-gray-500 mt-1">HPL akan dihitung ulang secara otomatis.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Riwayat Penyakit</label>
                            <textarea name="riwayat_penyakit" rows="2"
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('riwayat_penyakit', $kehamilan->riwayat_penyakit) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Riwayat Alergi</label>
                            <textarea name="riwayat_alergi" rows="2"
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('riwayat_alergi', $kehamilan->riwayat_alergi) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Profil Kehamilan</label>
                            <div class="flex items-center gap-4 mb-2">
                                <img src="{{ $kehamilan->foto_url }}" class="w-12 h-12 rounded-full object-cover">
                                <input type="file" name="foto" accept="image/*"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                    <a href="{{ route('warga.kehamilan.index') }}"
                       class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 font-medium transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-[#036672] hover:bg-[#036672] text-white rounded-xl font-medium shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection

