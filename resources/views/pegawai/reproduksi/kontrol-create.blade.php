{{-- resources/views/pegawai/reproduksi/kontrol-create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tambah Jadwal Kontrol - Pegawai')

@section('page-title', '📅 Tambah Jadwal Kontrol KB/Reproduksi')
@section('page-subtitle', 'Tambahkan jadwal kontrol lanjutan untuk WUS: ' . $wus->nama)

@section('content')
<div class="grid lg:grid-cols-3 gap-6 mt-2">
    <!-- Left Column (Form) -->
    <div class="lg:col-span-2">
        <form action="{{ route('pegawai.reproduksi.kontrol.store', $wus) }}" method="POST">
            @csrf

            <!-- Informasi Kontrol Card -->
            <div class="bg-white border text-sm border-slate-200 rounded-xl mb-6">
                <!-- Header -->
                <div class="border-b border-slate-200 px-6 py-4 flex justify-between items-center bg-white rounded-t-xl">
                    <h6 class="font-bold text-slate-800 flex items-center text-[15px]">
                        <i class="far fa-calendar-alt text-blue-600 mr-2 text-lg"></i> 
                        Informasi Kontrol
                    </h6>
                    <!-- Adding ID Sesi button here to match image's layout if header isn't used, but image has it aligned with title. I will just leave it if it's already in the header, or provide a standalone here if needed. Since the page title is outside `content`, we will leave it as is or add it to page-subtitle slot. Actually, let's keep it clean. -->
                </div>
                
                <!-- Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="tanggal" class="block text-sm font-semibold text-slate-600 mb-2">Tanggal Kontrol <span class="text-red-500">*</span></label>
                            <input type="date" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-colors @error('tanggal') border-red-500 @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                            @error('tanggal')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="jam" class="block text-sm font-semibold text-slate-600 mb-2">Jam Kontrol <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="time" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-colors @error('jam') border-red-500 @enderror" id="jam" name="jam" value="{{ old('jam') }}" required>
                            </div>
                            @error('jam')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="lokasi" class="block text-sm font-semibold text-slate-600 mb-2">Lokasi Kontrol <span class="text-red-500">*</span></label>
                        <div class="flex">
                            <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-slate-200 bg-slate-50 text-slate-400">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <input type="text" class="flex-1 min-w-0 bg-slate-50 border border-slate-200 rounded-r-lg px-3 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-colors @error('lokasi') border-red-500 @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', 'Posyandu') }}" required placeholder="Posyandu">
                        </div>
                        @error('lokasi')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan Card -->
            <div class="bg-white border border-slate-200 text-sm rounded-xl mb-6">
                <!-- Header -->
                <div class="border-b border-slate-200 px-6 py-4 bg-white rounded-t-xl">
                    <h6 class="font-bold text-slate-800 flex items-center text-[15px]">
                        <i class="far fa-file-alt text-blue-600 mr-2 text-lg"></i> 
                        Informasi Tambahan
                    </h6>
                </div>
                <!-- Body -->
                <div class="p-6">
                    <div>
                        <label for="catatan" class="block text-sm font-semibold text-slate-600 mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-colors @error('catatan') border-red-500 @enderror" id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan tambahan di sini...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-[#0b3486] hover:bg-[#072460] text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                    <i class="far fa-save mr-2"></i> Simpan Jadwal Kontrol
                </button>
                <a href="{{ route('pegawai.reproduksi.wus.show', $wus) }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg transition-colors shadow-sm">
                    <i class="fas fa-times mr-2 text-slate-400"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Right Column (Info & Banner) -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Ringkasan Data Card -->
        <div class="bg-white border text-sm border-slate-200 rounded-xl">
            <!-- Header -->
            <div class="border-b border-slate-200 px-6 py-4 bg-white rounded-t-xl">
                <h6 class="font-bold text-slate-800 flex items-center text-[15px]">
                    <span class="inline-flex justify-center items-center mr-3 w-8 h-8 rounded-full bg-slate-100 text-slate-500">
                        <i class="far fa-user text-sm"></i>
                    </span>
                    Ringkasan Data
                </h6>
            </div>
            <!-- Body -->
            <div class="p-6">
                <div class="mb-5">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">NAMA WUS</p>
                    <p class="text-lg font-bold text-slate-900">{{ $wus->nama }}</p>
                </div>
                <div class="mb-6">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NIK</p>
                    <div class="block px-4 py-3 border border-slate-200 rounded-lg text-slate-700 text-sm bg-white">
                        {{ $wus->nik }}
                    </div>
                </div>
                
                <hr class="border-slate-200 my-6">
                
                <div>
                    <p class="text-[13px] font-semibold text-blue-700 flex items-center mb-3">
                        <i class="far fa-info-circle mr-2 text-base"></i> Status Kepesertaan
                    </p>
                    <div class="p-4 border border-slate-200 rounded-lg bg-slate-50 text-slate-600 text-[13px] leading-relaxed">
                        Pasien terdaftar aktif untuk program Kesehatan Reproduksi. Pastikan jadwal yang dipilih tidak berbenturan dengan agenda imunisasi bulanan.
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Card -->
        <div class="relative bg-gradient-to-br from-[#3763c7] to-[#173680] rounded-xl overflow-hidden min-h-[260px] flex flex-col justify-end p-6 border-0 shadow-sm text-sm">
            <div class="absolute top-4 right-5 z-10 w-full text-right">
                <span class="text-[11px] font-light text-white/70 tracking-wide">Tambah Jadwal Kontrol - Modern Concept</span>
            </div>
            
            <div class="absolute inset-0 flex justify-center items-center opacity-15 pointer-events-none">
                <i class="far fa-calendar-alt text-[12rem] text-white"></i>
            </div>

            <div class="relative z-10 mt-auto">
                <h5 class="text-xl font-bold text-white mb-2">Pantau Rutin</h5>
                <p class="text-[13px] font-light text-white/90 leading-relaxed">
                    Kedisiplinan jadwal kontrol<br>
                    membantu pencegahan dini<br>
                    risiko kesehatan reproduksi.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
