{{-- resources/views/warga/lansia/edit.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Edit Data Lansia - Sistem Informasi Posyandu')
@section('page-title', '✏️ Edit Data Lansia')
@section('page-subtitle', 'Perbarui data identitas lansia sebelum diverifikasi.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="p-6">
            <form method="POST" action="{{ route('warga.lansia.update', $lansia) }}"
                  enctype="multipart/form-data"
                  x-data="lansiaEditForm()"
                  x-ref="form"
                  @submit.prevent="submitForm">
                @csrf
                @method('PUT')

                <div class="space-y-5">

                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white transition"
                               value="{{ old('nama', $lansia->nama) }}" required>
                        @error('nama')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            NIK <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nik" id="nik"
                               maxlength="16"
                               x-model="nik"
                               @input="validateNIK()"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white transition"
                               value="{{ old('nik', $lansia->nik) }}" required>
                        <p x-show="nikError" class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="nikError"></p>
                        @error('nik')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                               x-model="tanggalLahir"
                               @change="calculateAge()"
                               :max="maxDate"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white transition"
                               value="{{ old('tanggal_lahir', $lansia->tanggal_lahir?->format('Y-m-d')) }}" required>
                        <p x-show="usia" class="mt-1 text-sm text-gray-500 dark:text-gray-400">Usia: <span class="font-semibold" x-text="usia"></span></p>
                        @error('tanggal_lahir')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white transition" required>
                            <option value="L" {{ old('jenis_kelamin', $lansia->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $lansia->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat" id="alamat" rows="3"
                                  class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white transition">{{ old('alamat', $lansia->alamat) }}</textarea>
                        @error('alamat')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Golongan Darah --}}
                    <div>
                        <label for="golongan_darah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Golongan Darah</label>
                        <select name="golongan_darah" id="golongan_darah"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white transition">
                            <option value="">Pilih...</option>
                            @foreach(['A','B','AB','O'] as $gd)
                                <option value="{{ $gd }}" {{ old('golongan_darah', $lansia->golongan_darah) == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nomor HP --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nomor HP</label>
                        <input type="text" name="no_hp" id="no_hp"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white transition"
                               value="{{ old('no_hp', $lansia->no_hp) }}">
                    </div>

                    {{-- Riwayat Penyakit --}}
                    <div>
                        <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Riwayat Penyakit</label>
                        <textarea name="riwayat_penyakit" id="riwayat_penyakit" rows="3"
                                  class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white transition">{{ old('riwayat_penyakit', $lansia->riwayat_penyakit) }}</textarea>
                    </div>

                    {{-- Upload Foto --}}
                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Upload Foto</label>
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 flex-shrink-0">
                                <img id="fotoPreview" src="{{ $lansia->foto_url }}" alt="{{ $lansia->nama }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <input type="file" name="foto" id="foto"
                                       accept="image/jpeg,image/png,image/jpg,image/webp"
                                       @change="previewFoto($event)"
                                       class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah foto. Format: JPG, PNG, WebP (Maks. 2 MB)</p>
                            </div>
                        </div>
                        @error('foto')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>

                </div>

                <div class="flex items-center justify-between gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('warga.lansia.index') }}"
                       class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition">
                        ← Kembali
                    </a>
                    <button type="submit" x-show="!loading"
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <button type="button" x-show="loading" disabled
                            class="px-8 py-2.5 bg-teal-400 cursor-not-allowed text-white font-medium rounded-lg flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Menyimpan...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function lansiaEditForm() {
    return {
        loading: false,
        nik: '{{ old('nik', $lansia->nik) }}',
        tanggalLahir: '{{ old('tanggal_lahir', $lansia->tanggal_lahir?->format('Y-m-d')) }}',
        nikError: null,
        usia: null,
        maxDate: (() => {
            const d = new Date();
            d.setFullYear(d.getFullYear() - 60);
            return d.toISOString().split('T')[0];
        })(),

        init() { this.calculateAge(); },

        validateNIK() {
            if (!this.nik) { this.nikError = null; return; }
            if (!/^\d+$/.test(this.nik)) this.nikError = 'NIK hanya boleh angka.';
            else if (this.nik.length !== 16) this.nikError = 'NIK harus tepat 16 digit.';
            else this.nikError = null;
        },

        calculateAge() {
            if (!this.tanggalLahir) { this.usia = null; return; }
            const birth = new Date(this.tanggalLahir);
            const today = new Date();
            let y = today.getFullYear() - birth.getFullYear();
            let m = today.getMonth() - birth.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) { y--; m += 12; }
            this.usia = `${y} tahun ${m} bulan`;
        },

        previewFoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('fotoPreview').src = e.target.result;
                reader.readAsDataURL(file);
            }
        },

        submitForm() { this.loading = true; this.$refs.form.submit(); }
    };
}
</script>
@endpush
@endsection
