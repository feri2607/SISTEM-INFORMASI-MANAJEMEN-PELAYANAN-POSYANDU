{{-- resources/views/warga/remaja/index.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Posyandu Remaja - Sistem Informasi Posyandu')

@section('content')
<div class="bg-[#F8F9FA] min-h-screen pb-12 pt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
            <div>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[11px] font-bold bg-[#A8F3CD] text-[#006B4D] uppercase tracking-wider mb-4 border border-[#8FE0BA]">
                    <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Wellness Dashboard
                </span>
                <h1 class="text-[32px] md:text-[40px] font-black text-gray-900 leading-tight mb-3">Posyandu Remaja</h1>
                <p class="text-gray-600 text-[15px] max-w-xl leading-relaxed">Pantau perkembangan kesehatan fisik dan mental remaja secara berkala untuk masa depan yang lebih cerah.</p>
            </div>
            
            <a href="{{ route('warga.remaja.create') }}" class="inline-flex items-center px-7 py-3.5 bg-[#036672] hover:bg-[#036672] text-white text-[15px] font-semibold rounded-full shadow-[0_8px_16px_rgba(0,107,77,0.2)] transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2 stroke-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Profil Remaja
            </a>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-8 w-full bg-[#E5F9F1] border border-[#B3E8D4] text-[#006B4D] px-6 py-4 rounded-[16px] flex items-center shadow-sm">
                <div class="bg-white rounded-full p-1 mr-4 border border-[#B3E8D4]">
                    <svg class="w-5 h-5 text-[#006B4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-[14px] font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-8 w-full bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-4 rounded-[16px] flex items-center shadow-sm">
                <div class="bg-white rounded-full p-1 mr-4 border border-yellow-200">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <p class="text-[14px] font-medium">{{ session('warning') }}</p>
            </div>
        @endif

        @if($remaja->count() > 0)
            @php $item = $remaja->first(); @endphp
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- LEFT COLUMN: Profile & Notifications --}}
                <div class="lg:col-span-4 space-y-6">
                    
                    {{-- Profile Card --}}
                    <div class="bg-white rounded-[32px] p-8 shadow-[0_12px_40px_rgba(0,0,0,0.04)] border border-gray-100 flex flex-col relative overflow-hidden">
                        {{-- Subtle background decoration --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-0 opacity-50"></div>
                        
                        <div class="relative z-10 flex flex-col items-center mb-8">
                            <div class="relative mb-5">
                                <div class="w-28 h-28 rounded-[24px] overflow-hidden shadow-md ring-4 ring-white">
                                    <img src="{{ $item->foto_url ?? 'https://ui-avatars.com/api/?name='.$item->nama.'&background=E5F9F1&color=006B4D' }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-2 -right-2 bg-yellow-400 text-white rounded-full p-1.5 ring-4 ring-white shadow-sm" title="Profil Menunggu Verifikasi">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM11 19.93C7.05 19.43 4.07 16.27 4.07 12.27C4.07 12 4.07 11.75 4.1 11.5L8.5 15.9V16.5C8.5 17.33 9.17 18 10 18V19.93ZM17.9 17.39C17.65 16.29 16.79 15.5 15.5 15.5H14.5V13.5C14.5 12.95 14.05 12.5 13.5 12.5H9.5V11.5H11.5C12.05 11.5 12.5 11.05 12.5 10.5V9.5H15.5C16.33 9.5 17 8.83 17 8V7.3C18.8 8.87 20 11.19 20 13.77C20 15.17 19.34 16.35 17.9 17.39Z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-[26px] font-bold text-gray-900 tracking-tight">{{ $item->nama }}</h2>
                            <p class="text-gray-500 font-medium tracking-widest text-[11px] mt-1">{{ $item->nik }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-y-6 gap-x-4 mb-6">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Umur</p>
                                <p class="text-[15px] font-bold text-gray-800">{{ $item->umur }} Tahun</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Jenis Kelamin</p>
                                <p class="text-[15px] font-bold text-gray-800">{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Gol. Darah</p>
                                <div class="flex items-center">
                                    <span class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-[11px] font-bold mr-2">{{ $item->golongan_darah ?? '-' }}</span>
                                    <p class="text-[14px] font-bold text-gray-800">Golongan {{ $item->golongan_darah ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Status</p>
                                @if($item->is_verified)
                                    <span class="inline-flex px-2 py-0.5 rounded-[6px] bg-green-100 text-green-700 text-[11px] font-bold">VERIFIED</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-[6px] bg-yellow-100 text-yellow-700 text-[10px] font-bold tracking-wider">PENDING</span>
                                @endif
                            </div>
                        </div>

                        <hr class="border-gray-100 mb-5">

                        <div class="mb-5">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Pendidikan</p>
                            <p class="text-[15px] font-bold text-gray-800">{{ $item->sekolah ?? '-' }}</p>
                        </div>

                        <div class="mb-8">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Alamat Domisili</p>
                            <p class="text-[14px] font-medium text-gray-600 leading-relaxed">{{ $item->alamat ?? '-' }}</p>
                        </div>

                        <a href="{{ route('warga.remaja.show', $item) }}" class="mt-auto w-full flex items-center justify-center py-3.5 bg-[#036672] hover:bg-[#036672] text-[#fff] text-[14px] font-bold rounded-xl transition-colors">
                            Kelola Profil Lengkap
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </a>
                    </div>

                    {{-- Notification Card --}}
                    <div class="bg-[#F3F8F8] rounded-[24px] overflow-hidden p-6 shadow-sm border border-emerald-50">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-[#006B4D] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <h3 class="font-bold text-gray-900 text-[16px]">Notifikasi</h3>
                            </div>
                            <span class="bg-[#006B4D] text-white text-[10px] font-bold px-2.5 py-1 rounded-full">{{ count($notifications) }} Baru</span>
                        </div>
                        @if(count($notifications) > 0)
                            <div class="space-y-3">
                                @foreach($notifications as $notif)
                                <div class="bg-white rounded-xl p-4 shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
                                    <p class="text-[12px] font-bold text-gray-900 mb-1">{{ $notif['title'] }}</p>
                                    <p class="text-[11px] font-medium text-gray-500">{{ $notif['message'] }}</p>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white rounded-xl p-4 text-center">
                                <p class="text-[12px] text-gray-500 font-medium">Tidak ada notifikasi baru.</p>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- RIGHT COLUMN: Biometrics & Schedule --}}
                <div class="lg:col-span-8 flex flex-col gap-6">
                    
                    {{-- Biometrics Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        {{-- Top Wide Card: Biometrik Utama --}}
                        <div class="md:col-span-2 bg-white rounded-[24px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-[12px] font-bold text-gray-500 tracking-widest uppercase">Biometrik Utama</h3>
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                            </div>
                            <div class="flex items-center justify-around pb-2">
                                <div class="text-center flex-1 border-r border-gray-100">
                                    <p class="text-[32px] font-black text-[#006B4D] leading-none mb-1">{{ $stats['berat_badan'] }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">Berat (KG)</p>
                                </div>
                                <div class="text-center flex-1">
                                    <p class="text-[32px] font-black text-[#006B4D] leading-none mb-1">{{ $stats['tinggi_badan'] }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">Tinggi (CM)</p>
                                </div>
                            </div>
                        </div>

                        {{-- Sub Card: BMI --}}
                        <div class="bg-white rounded-[24px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 rounded-full bg-[#E0F7FA] flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-[#00ACC1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                <h3 class="text-[12px] font-bold text-gray-500 tracking-widest uppercase">Body Mass Index</h3>
                            </div>
                            <div class="px-2">
                                <div class="flex items-baseline gap-1 mb-4">
                                    <span class="text-[28px] font-black text-gray-900">{{ $stats['bmi'] }}</span>
                                    <span class="text-[12px] font-bold text-gray-400">kg/m²</span>
                                </div>
                                @if($stats['bmi'] == '-')
                                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden mb-2"></div>
                                    <p class="text-[11px] text-gray-400 font-medium">Belum ada perhitungan aktif</p>
                                @else
                                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden mb-2">
                                        <div class="h-full bg-blue-500 w-1/2"></div>
                                    </div>
                                    <p class="text-[11px] text-blue-500 font-bold">Kategori tersimpan</p>
                                @endif
                            </div>
                        </div>

                        {{-- Sub Card: Kadar Hemoglobin --}}
                        <div class="bg-white rounded-[24px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 rounded-full bg-[#FFEBEE] flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-[#E53935]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                                    </svg>
                                </div>
                                <h3 class="text-[12px] font-bold text-gray-500 tracking-widest uppercase">Kadar Hemoglobin</h3>
                            </div>
                            <div class="px-2">
                                <div class="flex items-baseline gap-1 mb-4">
                                    <span class="text-[28px] font-black text-gray-900">{{ $stats['status_hb'] }}</span>
                                    <span class="text-[12px] font-bold text-gray-400">g/dL</span>
                                </div>
                                <span class="inline-flex px-2 py-1 rounded-[6px] bg-[#E8F0FE] text-[#1967D2] text-[10px] font-bold tracking-wider">STATUS: N/A</span>
                            </div>
                        </div>

                        {{-- Sub Card: Status Gizi --}}
                        <div class="bg-white rounded-[24px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col justify-between">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 rounded-full bg-[#E8F5E9] flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-[#43A047]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/>
                                    </svg>
                                </div>
                                <h3 class="text-[12px] font-bold text-gray-500 tracking-widest uppercase">Status Gizi</h3>
                            </div>
                            @if($stats['status_gizi'] == 'Belum ada data')
                            <div class="bg-[#F8F9FA] rounded-[16px] p-3 text-center border border-dashed border-gray-300">
                                <p class="text-[12px] font-semibold text-gray-500">Belum ada data tersedia</p>
                            </div>
                            @else
                            <div class="bg-green-50 rounded-[16px] p-3 text-center border border-green-200">
                                <p class="text-[15px] font-bold text-green-700">{{ $stats['status_gizi'] }}</p>
                            </div>
                            @endif
                        </div>

                        {{-- Sub Card: Terakhir Periksa --}}
                        <div class="bg-white rounded-[24px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col justify-between">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 rounded-full bg-[#E3F2FD] flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-[#1E88E5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-[12px] font-bold text-gray-500 tracking-widest uppercase">Terakhir Periksa</h3>
                            </div>
                            <div class="px-2">
                                <p class="text-[18px] font-black text-gray-900 mb-2">{{ $stats['pemeriksaan_terakhir'] }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $stats['pemeriksaan_terakhir'] != '-' ? 'Selesai diverifikasi' : 'Selesaikan Verifikasi Profil' }}</p>
                            </div>
                        </div>

                    </div>

                    {{-- Schedule Section --}}
                    <div class="mt-4 flex items-center justify-between px-2 mb-2">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-[#006B4D] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <h2 class="text-[18px] font-bold text-gray-900">Jadwal Terdekat</h2>
                        </div>
                        <a href="{{ route('public.schedule') }}" class="text-[12px] font-bold text-[#006B4D] hover:text-[#005139] underline-offset-4 hover:underline transition-all">Lihat Semua Kalender</a>
                    </div>
                    
                    @if($jadwal->count() > 0)
                        <div class="space-y-3">
                            @foreach($jadwal as $jadwalItem)
                            <div class="bg-white rounded-[20px] p-5 shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center transition-all hover:shadow-md">
                                <div class="w-14 h-14 rounded-full bg-[#F2FAF6] flex flex-col items-center justify-center mr-5 border border-[#8FE0BA] shrink-0">
                                    <p class="text-[10px] font-bold text-[#006B4D] uppercase tracking-wider mb-0.5">{{ $jadwalItem->tanggal->format('M') }}</p>
                                    <p class="text-[18px] font-black text-[#006B4D] leading-none">{{ $jadwalItem->tanggal->format('d') }}</p>
                                </div>
                                <div>
                                    <h4 class="text-[15px] font-bold text-gray-900 mb-1.5">{{ $jadwalItem->nama_kegiatan }}</h4>
                                    <div class="flex items-center text-[12px] text-gray-500 font-medium">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="mr-3">{{ $jadwalItem->lokasi }}</span>
                                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                                        <span class="text-[#006B4D] font-bold tracking-wider uppercase text-[10px]">{{ $jadwalItem->jenis ?? 'UMUM' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-[20px] p-8 text-center shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-gray-100">
                            <p class="text-[14px] text-gray-500 font-medium">Belum ada jadwal posyandu terdekat.</p>
                        </div>
                    @endif

                </div>
            </div>
            
            {{-- Artikel Section remains below if needed, optionally styled --}}
            @if($artikel->count() > 0)
            <div class="mt-12">
                <div class="flex items-center mb-6">
                    <h2 class="text-[20px] font-bold text-gray-900">Edukasi Remaja</h2>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($artikel as $artikelItem)
                        <a href="{{ route('public.article-detail', $artikelItem->slug) }}" class="group bg-white rounded-[20px] overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-gray-100 transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.06)] hover:-translate-y-1 block">
                            <div class="h-36 overflow-hidden">
                                <img src="{{ $artikelItem->thumbnail_url }}" alt="{{ $artikelItem->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 text-[14px] line-clamp-2 mb-2 group-hover:text-[#006B4D] transition-colors">{{ $artikelItem->title }}</h3>
                                <p class="text-[12px] text-gray-500 line-clamp-2 leading-relaxed">{{ $artikelItem->excerpt }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

        @else
            {{-- Empty State (If no Remaja is registered yet) --}}
            <div class="bg-white rounded-[32px] p-16 text-center shadow-[0_12px_40px_rgba(0,0,0,0.04)] border border-gray-100 max-w-3xl mx-auto mt-12 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-transparent -z-10"></div>
                <div class="w-24 h-24 bg-[#E5F9F1] text-[#006B4D] rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner relative z-10">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-[24px] font-black text-gray-900 mb-3 relative z-10">Belum Ada Profil Remaja Tersimpan</h3>
                <p class="text-[15px] font-medium text-gray-500 mb-8 max-w-md mx-auto relative z-10 leading-relaxed">Mulai pantau kesehatan remaja Anda secara komprehensif dengan menambahkan profil sekarang juga.</p>
                
                <a href="{{ route('warga.remaja.create') }}" class="inline-flex items-center px-8 py-4 bg-[#006B4D] hover:bg-[#005139] text-white text-[15px] font-bold rounded-full shadow-[0_12px_24px_rgba(0,107,77,0.25)] transition-all duration-200 hover:-translate-y-1 relative z-10">
                    <svg class="w-5 h-5 mr-3 pr-2 border-r border-[#009b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Profil Remaja Pertama Anda
                </a>
            </div>
        @endif
    </div>
</div>
@endsection