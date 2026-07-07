{{-- resources/views/warga/warga/create.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Lengkapi Data Warga - Sistem Informasi Posyandu')

@section('page-title', 'Lengkapi Data Warga')
@section('page-subtitle', 'Silakan lengkapi identitas Anda untuk menggunakan seluruh layanan Posyandu')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 font-sans">
    
    {{-- Status Banner --}}
    <div class="bg-[#f8f9fe] border border-blue-100 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between mb-8 shadow-sm">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <div class="bg-blue-100 text-[#0a358c] p-2.5 rounded-full flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900">Status Verifikasi Profil</h3>
                <p class="text-sm text-gray-600">Silakan lengkapi seluruh dokumen dan informasi yang diperlukan.</p>
            </div>
        </div>
        <div class="flex-shrink-0">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-[#e6eeff] text-[#0a358c] border border-blue-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Belum Lengkap
            </span>
        </div>
    </div>

    <form method="POST" action="{{ route('warga.warga.store') }}" 
          enctype="multipart/form-data"
          x-data="wargaForm()"
          x-ref="form"
          @submit.prevent="submitForm">
        @csrf

        <div class="flex flex-col md:flex-row gap-6">
            
            {{-- Left Sidebar Navigation --}}
            <div class="w-full md:w-72 flex-shrink-0">
                
                {{-- Steps --}}
                <div class="space-y-3">
                    <!-- Step 1 -->
                    <button type="button" @click="activeTab = 'identitas'" 
                            class="w-full text-left p-4 rounded-xl border-2 transition-all duration-200 flex items-center space-x-4"
                            :class="activeTab === 'identitas' ? 'border-[#0a358c] bg-white text-[#0a358c] shadow-sm' : 'border-gray-100 bg-white shadow-sm text-gray-600 hover:border-gray-300'">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider mb-0.5" :class="activeTab === 'identitas' ? 'text-[#0a358c]' : 'text-gray-400'">LANGKAH 1</p>
                            <p class="font-bold text-sm">Identitas</p>
                        </div>
                    </button>

                    <!-- Step 2 -->
                    <button type="button" @click="activeTab = 'alamat'" 
                            class="w-full text-left p-4 rounded-xl border-2 transition-all duration-200 flex items-center space-x-4"
                            :class="activeTab === 'alamat' ? 'border-[#0a358c] bg-white text-[#0a358c] shadow-sm' : 'border-gray-100 bg-white shadow-sm text-gray-600 hover:border-gray-300'">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider mb-0.5" :class="activeTab === 'alamat' ? 'text-[#0a358c]' : 'text-gray-400'">LANGKAH 2</p>
                            <p class="font-bold text-sm">Alamat</p>
                        </div>
                    </button>

                    <!-- Step 3 -->
                    <button type="button" @click="activeTab = 'administrasi'" 
                            class="w-full text-left p-4 rounded-xl border-2 transition-all duration-200 flex items-center space-x-4"
                            :class="activeTab === 'administrasi' ? 'border-[#0a358c] bg-white text-[#0a358c] shadow-sm' : 'border-gray-100 bg-white shadow-sm text-gray-600 hover:border-gray-300'">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider mb-0.5" :class="activeTab === 'administrasi' ? 'text-[#0a358c]' : 'text-gray-400'">LANGKAH 3</p>
                            <p class="font-bold text-sm">Administrasi</p>
                        </div>
                    </button>

                    <!-- Step 4 -->
                    <button type="button" @click="activeTab = 'dokumen'" 
                            class="w-full text-left p-4 rounded-xl border-2 transition-all duration-200 flex items-center space-x-4"
                            :class="activeTab === 'dokumen' ? 'border-[#0a358c] bg-white text-[#0a358c] shadow-sm' : 'border-gray-100 bg-white shadow-sm text-gray-600 hover:border-gray-300'">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider mb-0.5" :class="activeTab === 'dokumen' ? 'text-[#0a358c]' : 'text-gray-400'">LANGKAH 4</p>
                            <p class="font-bold text-sm">Dokumen</p>
                        </div>
                    </button>
                </div>

                {{-- Help Widget --}}
                <div class="bg-[#f4f6fa] rounded-xl p-5 border border-gray-100 shadow-sm mt-6">
                    <h4 class="font-bold text-[#0a358c] mb-2 text-sm">Butuh Bantuan?</h4>
                    <p class="text-xs text-gray-600 leading-relaxed mb-4">Hubungi Admin melalui WhatsApp jika mengalami kendala pengisian data.</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center text-sm font-bold text-[#0a358c] hover:text-[#06215b] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Chat Admin
                    </a>
                </div>
            </div>

            {{-- Main Form Container --}}
            <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 md:p-8">
                    
                    {{-- Tab 1: Identitas --}}
                    <div x-show="activeTab === 'identitas'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mb-6 pb-4 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-[#0a358c] mb-1">Data Identitas Diri</h2>
                            <p class="text-sm text-gray-500">Pastikan data sesuai dengan KTP asli Anda.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            {{-- NIK --}}
                            <div>
                                <label for="nik" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nik" id="nik" 
                                       placeholder="16 digit nomor NIK"
                                       maxlength="16"
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('nik') }}" required>
                                @error('nik')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nama Lengkap --}}
                            <div>
                                <label for="nama" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" id="nama" 
                                       placeholder="Sesuai KTP"
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('nama') }}" required>
                                @error('nama')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tempat Lahir --}}
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" 
                                       placeholder="Contoh: Jakarta"
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('tempat_lahir') }}" required>
                                @error('tempat_lahir')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-6 mt-2">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="L" 
                                               class="w-4 h-4 text-[#0a358c] focus:ring-[#0a358c] border-gray-300"
                                               {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                                        <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="P" 
                                               class="w-4 h-4 text-[#0a358c] focus:ring-[#0a358c] border-gray-300"
                                               {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} required>
                                        <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                                    </label>
                                </div>
                                @error('jenis_kelamin')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Golongan Darah --}}
                            <div>
                                <label for="golongan_darah" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Golongan Darah
                                </label>
                                <select name="golongan_darah" id="golongan_darah" 
                                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow">
                                    <option value="">Pilih...</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>

                            {{-- Other Tab 1 Items : nomor_kk, agama, status_pernikahan, pendidikan, pekerjaan, telepon, email --}}
                            
                            {{-- Nomor KK --}}
                            <div>
                                <label for="nomor_kk" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Nomor KK <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nomor_kk" id="nomor_kk" 
                                       placeholder="16 digit nomor KK"
                                       maxlength="16"
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('nomor_kk') }}" required>
                                @error('nomor_kk')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Telepon --}}
                            <div>
                                <label for="telepon" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="telepon" id="telepon" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('telepon') }}" required>
                                @error('telepon')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Agama --}}
                            <div>
                                <label for="agama" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Agama
                                </label>
                                <input type="text" name="agama" id="agama" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('agama') }}">
                            </div>

                            {{-- Status Pernikahan --}}
                            <div>
                                <label for="status_pernikahan" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Status Pernikahan
                                </label>
                                <input type="text" name="status_pernikahan" id="status_pernikahan" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('status_pernikahan') }}">
                            </div>

                            {{-- Pendidikan --}}
                            <div>
                                <label for="pendidikan" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Pendidikan Terakhir
                                </label>
                                <input type="text" name="pendidikan" id="pendidikan" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('pendidikan') }}">
                            </div>

                            {{-- Pekerjaan --}}
                            <div>
                                <label for="pekerjaan" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Pekerjaan
                                </label>
                                <input type="text" name="pekerjaan" id="pekerjaan" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('pekerjaan') }}">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Email
                                </label>
                                <input type="email" name="email" id="email" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('email') }}">
                                @error('email')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                            <button type="button" @click="activeTab = 'alamat'" 
                                    class="px-8 py-2.5 bg-[#0a358c] hover:bg-[#06215b] text-white font-semibold rounded-lg transition duration-200 flex items-center">
                                Selanjutnya
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Tab 2: Alamat --}}
                    <div x-show="activeTab === 'alamat'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mb-6 pb-4 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-[#0a358c] mb-1">Data Alamat</h2>
                            <p class="text-sm text-gray-500">Lengkapi data alamat tempat tinggal Anda saat ini.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            {{-- Alamat --}}
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat" id="alamat" rows="3" 
                                          class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                          required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- RT --}}
                            <div>
                                <label for="rt" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    RT
                                </label>
                                <input type="text" name="rt" id="rt" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('rt') }}">
                            </div>

                            {{-- RW --}}
                            <div>
                                <label for="rw" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    RW
                                </label>
                                <input type="text" name="rw" id="rw" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('rw') }}">
                            </div>

                            {{-- Dusun --}}
                            <div>
                                <label for="dusun" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Dusun/Lingkungan
                                </label>
                                <input type="text" name="dusun" id="dusun" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('dusun') }}">
                            </div>

                            {{-- Desa --}}
                            <div>
                                <label for="desa" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Kelurahan/Desa
                                </label>
                                <input type="text" name="desa" id="desa" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('desa') }}">
                            </div>

                            {{-- Kecamatan --}}
                            <div>
                                <label for="kecamatan" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Kecamatan
                                </label>
                                <input type="text" name="kecamatan" id="kecamatan" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('kecamatan') }}">
                            </div>

                            {{-- Kabupaten --}}
                            <div>
                                <label for="kabupaten" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Kabupaten/Kota
                                </label>
                                <input type="text" name="kabupaten" id="kabupaten" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('kabupaten') }}">
                            </div>

                            {{-- Provinsi --}}
                            <div>
                                <label for="provinsi" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Provinsi
                                </label>
                                <input type="text" name="provinsi" id="provinsi" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('provinsi') }}">
                            </div>

                            {{-- Kode Pos --}}
                            <div>
                                <label for="kode_pos" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Kode Pos
                                </label>
                                <input type="text" name="kode_pos" id="kode_pos" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('kode_pos') }}">
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between">
                            <button type="button" @click="activeTab = 'identitas'" 
                                    class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 font-semibold rounded-lg transition duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Sebelumnya
                            </button>
                            <button type="button" @click="activeTab = 'administrasi'" 
                                    class="px-8 py-2.5 bg-[#0a358c] hover:bg-[#06215b] text-white font-semibold rounded-lg transition duration-200 flex items-center">
                                Selanjutnya
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Tab 3: Administrasi --}}
                    <div x-show="activeTab === 'administrasi'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mb-6 pb-4 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-[#0a358c] mb-1">Data Administrasi</h2>
                            <p class="text-sm text-gray-500">Lengkapi data asuransi dan kependudukan Anda.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            {{-- Status Kependudukan --}}
                            <div>
                                <label for="status_kependudukan" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Status Kependudukan <span class="text-red-500">*</span>
                                </label>
                                <select name="status_kependudukan" id="status_kependudukan" 
                                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow">
                                    <option value="tetap" {{ old('status_kependudukan') == 'tetap' ? 'selected' : '' }}>Warga Tetap</option>
                                    <option value="pendatang" {{ old('status_kependudukan') == 'pendatang' ? 'selected' : '' }}>Pendatang</option>
                                </select>
                                @error('status_kependudukan')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Status Keaktifan --}}
                            <div>
                                <label for="status_keaktifan" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Status Keaktifan <span class="text-red-500">*</span>
                                </label>
                                <select name="status_keaktifan" id="status_keaktifan" 
                                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow">
                                    <option value="aktif" {{ old('status_keaktifan') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif" {{ old('status_keaktifan') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status_keaktifan')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- BPJS --}}
                            <div>
                                <label for="bpjs_number" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Nomor BPJS
                                </label>
                                <input type="text" name="bpjs_number" id="bpjs_number" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('bpjs_number') }}">
                            </div>

                            {{-- KIS --}}
                            <div>
                                <label for="kis_number" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Nomor KIS
                                </label>
                                <input type="text" name="kis_number" id="kis_number" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('kis_number') }}">
                            </div>

                            {{-- JKN --}}
                            <div>
                                <label for="jkn_number" class="block text-sm font-bold text-gray-700 mb-1.5">
                                    Nomor JKN
                                </label>
                                <input type="text" name="jkn_number" id="jkn_number" 
                                       class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 transition-shadow"
                                       value="{{ old('jkn_number') }}">
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between">
                            <button type="button" @click="activeTab = 'alamat'" 
                                    class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 font-semibold rounded-lg transition duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Sebelumnya
                            </button>
                            <button type="button" @click="activeTab = 'dokumen'" 
                                    class="px-8 py-2.5 bg-[#0a358c] hover:bg-[#06215b] text-white font-semibold rounded-lg transition duration-200 flex items-center">
                                Selanjutnya
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Tab 4: Dokumen --}}
                    <div x-show="activeTab === 'dokumen'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mb-6 pb-4 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-[#0a358c] mb-1">Unggah Dokumen</h2>
                            <p class="text-sm text-gray-500">Unggah foto KTP dan KK Anda untuk keperluan verifikasi administrasi.</p>
                        </div>

                        <div class="space-y-6">
                            {{-- Foto KTP --}}
                            <div>
                                <label for="ktp_path" class="block text-sm font-bold text-gray-700 mb-2">
                                    Foto KTP
                                </label>
                                <div class="flex items-center space-x-6 p-4 border border-dashed border-gray-300 rounded-xl bg-gray-50">
                                    <div class="flex-shrink-0">
                                        <div class="w-24 h-16 rounded-lg overflow-hidden bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                            <img id="ktpPreview" 
                                                 src="https://placehold.co/200x120/e2e8f0/64748b?text=KTP" 
                                                 alt="Preview KTP" 
                                                 class="max-w-full max-h-full object-contain">
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="ktp_path" id="ktp_path" 
                                               accept="image/jpeg,image/png,image/jpg,application/pdf"
                                               @change="previewFile($event, 'ktpPreview')"
                                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#e6eeff] file:text-[#0a358c] hover:file:bg-[#d0e0ff] transition-colors cursor-pointer">
                                        <p class="mt-1.5 text-xs text-gray-500">Format yang didukung: JPG, JPEG, PNG, PDF (Maks. 2MB)</p>
                                    </div>
                                </div>
                                @error('ktp_path')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Foto KK --}}
                            <div>
                                <label for="kk_path" class="block text-sm font-bold text-gray-700 mb-2">
                                    Foto Kartu Keluarga (KK)
                                </label>
                                <div class="flex items-center space-x-6 p-4 border border-dashed border-gray-300 rounded-xl bg-gray-50">
                                    <div class="flex-shrink-0">
                                        <div class="w-24 h-16 rounded-lg overflow-hidden bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                            <img id="kkPreview" 
                                                 src="https://placehold.co/200x120/e2e8f0/64748b?text=KK" 
                                                 alt="Preview KK" 
                                                 class="max-w-full max-h-full object-contain">
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="kk_path" id="kk_path" 
                                               accept="image/jpeg,image/png,image/jpg,application/pdf"
                                               @change="previewFile($event, 'kkPreview')"
                                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#e6eeff] file:text-[#0a358c] hover:file:bg-[#d0e0ff] transition-colors cursor-pointer">
                                        <p class="mt-1.5 text-xs text-gray-500">Format yang didukung: JPG, JPEG, PNG, PDF (Maks. 2MB)</p>
                                    </div>
                                </div>
                                @error('kk_path')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 mt-8 pt-6 border-t border-gray-200">
                            <div>
                                <button type="button" @click="activeTab = 'administrasi'" 
                                        class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 font-semibold rounded-lg transition duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Sebelumnya
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('warga.dashboard') }}" 
                                   class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition duration-150 text-center">
                                    Batal
                                </a>
                                <button type="submit" 
                                        id="submitButton"
                                        x-show="!loading"
                                        class="px-8 py-2.5 bg-[#0a358c] hover:bg-[#06215b] text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Kirim Data
                                </button>
                                <button type="button" 
                                        x-show="loading"
                                        disabled
                                        class="px-8 py-2.5 bg-blue-400 cursor-not-allowed text-white font-semibold rounded-lg flex items-center">
                                    <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Menyimpan...
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function wargaForm() {
        return {
            loading: false,
            activeTab: 'identitas',
            previewFile(event, previewId) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(previewId).src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },
            submitForm() {
                this.loading = true;
                this.$refs.form.submit();
            }
        }
    }
</script>
@endpush
@endsection