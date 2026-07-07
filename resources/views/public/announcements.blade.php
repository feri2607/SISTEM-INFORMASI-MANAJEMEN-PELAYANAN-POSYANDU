{{-- resources/views/public/announcements.blade.php --}}

@extends('layouts.public')

@section('title', 'Pengumuman Posyandu - Sistem Informasi Posyandu Digital')
@section('description', 'Dapatkan informasi terbaru mengenai jadwal imunisasi, kegiatan kesehatan bulanan, dan berita penting dari Posyandu di wilayah Anda.')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-teal-700 to-blue-800 pt-16 pb-32 lg:pb-36">
        {{-- Background pattern --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute top-0 right-0 w-full h-full" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="600" cy="200" r="300" fill="white" opacity="0.3"/>
                <circle cx="700" cy="500" r="200" fill="white" opacity="0.2"/>
                <circle cx="400" cy="700" r="250" fill="white" opacity="0.1"/>
            </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center text-[12px] text-blue-200 mb-6 font-medium" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition duration-150">Beranda</a>
                <svg class="w-3 h-3 mx-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-white">Pengumuman</span>
            </nav>

            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                    Pengumuman Posyandu
                </h1>
                <p class="text-base md:text-lg text-blue-100/90 leading-relaxed max-w-2xl">
                    Dapatkan informasi terbaru mengenai jadwal imunisasi, kegiatan kesehatan bulanan, dan berita penting dari Posyandu di wilayah Anda.
                </p>
            </div>
        </div>
    </section>

    {{-- Filter Search Bar (Overlapping Hero) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-16 z-20">
        <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100 p-6">
            <form method="GET" action="{{ route('public.announcements') }}" x-data="announcementFilter()" @submit.prevent="submitForm">
                <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr_1fr_1fr_auto] gap-4 items-end">
                    
                    {{-- Search --}}
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-widest mb-2">Cari Pengumuman</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" x-model="search" placeholder="Ketik kata kunci..." 
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white text-[13px] text-gray-900 outline-none focus:ring-2 focus:ring-[#0a256a]/20 focus:border-[#0a256a] transition-all">
                        </div>
                    </div>

                    {{-- Priority --}}
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-widest mb-2">Prioritas</label>
                        <select name="priority" x-model="priority" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-white text-[13px] text-gray-700 outline-none focus:ring-2 focus:ring-[#0a256a]/20 focus:border-[#0a256a] cursor-pointer appearance-none bg-no-repeat bg-[right_0.75rem_center] bg-[length:1em]" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%239CA3AF%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')">
                            <option value="">Semua</option>
                            <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="important" {{ request('priority') == 'important' ? 'selected' : '' }}>Penting</option>
                            <option value="very_important" {{ request('priority') == 'very_important' ? 'selected' : '' }}>Sangat Penting</option>
                        </select>
                    </div>

                    {{-- Bulan --}}
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-widest mb-2">Bulan</label>
                        <select name="bulan" x-model="bulan" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-white text-[13px] text-gray-700 outline-none focus:ring-2 focus:ring-[#0a256a]/20 focus:border-[#0a256a] cursor-pointer appearance-none bg-no-repeat bg-[right_0.75rem_center] bg-[length:1em]" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%239CA3AF%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')">
                            <option value="">Semua</option>
                            @foreach($months as $key => $month)
                                <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tahun --}}
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-widest mb-2">Tahun</label>
                        <select name="tahun" x-model="tahun" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-white text-[13px] text-gray-700 outline-none focus:ring-2 focus:ring-[#0a256a]/20 focus:border-[#0a256a] cursor-pointer appearance-none bg-no-repeat bg-[right_0.75rem_center] bg-[length:1em]" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%239CA3AF%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')">
                            <option value="">Semua</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Button --}}
                    <div>
                        <button type="submit" class="w-full h-[42px] px-6 bg-[#0a256a] hover:bg-[#071947] text-white text-[13px] font-bold rounded-xl transition shadow-md flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Saring
                        </button>
                    </div>

                    {{-- Hidden preserved inputs --}}
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </div>
            </form>
        </div>
    </div>

    <section class="py-12 bg-[#F9FAFF] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Important Announcements Area --}}
            @if($importantAnnouncements->count() > 0)
                <div class="mb-14">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2 mb-6 uppercase tracking-wider">
                        <svg class="w-4 h-4 text-[#cd1d27]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                        Informasi Sangat Penting
                    </h2>
                    
                    <div class="space-y-6">
                        @foreach($importantAnnouncements->take(1) as $important)
                            <div class="relative bg-white rounded-3xl shadow-[0_4px_25px_rgb(0,0,0,0.04)] border border-red-100 flex flex-col md:flex-row overflow-hidden border-l-8 border-l-[#cd1d27] group hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all">
                                
                                @if($important->attachment)
                                <div class="w-full md:w-[45%] shrink-0 h-56 md:h-auto relative overflow-hidden">
                                    <img src="{{ $important->attachment_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="{{ $important->title }}">
                                </div>
                                @endif
                                
                                <div class="p-6 md:p-10 flex-1 flex flex-col justify-center">
                                    <div class="flex gap-2.5 mb-4">
                                        <span class="bg-[#cd1d27] text-white px-3 py-1.5 text-[10px] uppercase font-bold rounded shadow-sm">Sangat Penting</span>
                                        <span class="bg-[#eef2fc] text-[#143d96] px-3 py-1.5 text-[10px] font-bold rounded">{{ $important->category->name }}</span>
                                    </div>
                                    <h2 class="text-2xl md:text-[28px] leading-tight font-extrabold mt-1 text-[#111827]">
                                        <a href="{{ route('public.announcement-detail', $important->slug) }}" class="hover:text-[#cd1d27] transition-colors">{{ $important->title }}</a>
                                    </h2>
                                    <p class="text-[14px] text-gray-600 mt-4 leading-relaxed line-clamp-3 md:line-clamp-2">
                                        {{ strip_tags($important->content) }}
                                    </p>
                                    <div class="mt-5 flex flex-wrap gap-4 text-[12px] font-semibold">
                                        <span class="flex items-center gap-1.5 text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> 
                                            Tayang: {{ $important->published_at ? $important->published_at->format('d M Y') : '-' }}
                                        </span>
                                        @if($important->end_date)
                                        <span class="flex items-center gap-1.5 text-[#cd1d27]">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Berakhir: {{ $important->end_date->format('d M Y') }}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="mt-8">
                                        <a href="{{ route('public.announcement-detail', $important->slug) }}" class="inline-flex bg-[#cd1d27] hover:bg-[#a71520] text-white px-6 py-3 rounded-xl text-[13px] font-bold shadow-sm transition-colors">
                                            Baca Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Main List --}}
            <div class="mb-12">
                <h2 class="text-sm font-bold text-[#111827] mb-6 uppercase tracking-wider">
                    Daftar Pengumuman
                </h2>

                @if($announcements->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
                        @foreach($announcements as $item)
                            <div class="bg-white rounded-[20px] overflow-hidden border border-gray-100 shadow-[0_4px_15px_rgb(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative flex flex-col group h-full">
                                
                                {{-- Image with Pin Badge --}}
                                @if($item->attachment)
                                <div class="relative h-48 shrink-0 overflow-hidden w-full">
                                    <img src="{{ $item->attachment_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                                    @php
                                        $prioBg = $item->priority == 'very_important' ? 'bg-[#cd1d27]' : ($item->priority == 'important' ? 'bg-[#f59e0b]' : 'bg-[#0a256a]');
                                        $prioText = $item->priority == 'very_important' ? 'Sangat Penting' : ($item->priority == 'important' ? 'Penting' : 'Normal');
                                    @endphp
                                    <span class="absolute top-4 left-4 {{ $prioBg }} text-white px-3 py-1 rounded-md text-[10px] uppercase font-bold shadow-md">
                                        {{ $prioText }}
                                    </span>
                                </div>
                                @endif
                                
                                {{-- Content --}}
                                <div class="p-6 flex flex-col flex-1">
                                    <span class="text-gray-400 text-[11px] font-bold mb-3 uppercase tracking-wider">{{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</span>
                                    
                                    <h3 class="text-[#111827] text-[17px] font-bold leading-[1.4] mb-3 line-clamp-2 group-hover:text-[#0a256a] transition-colors">
                                        <a href="{{ route('public.announcement-detail', $item->slug) }}">{{ $item->title }}</a>
                                    </h3>
                                    
                                    <p class="text-gray-500 text-[13px] leading-relaxed mt-1 mb-6 line-clamp-3">
                                        {{ strip_tags($item->content) }}
                                    </p>
                                    
                                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                        @if($item->end_date)
                                        <span class="text-gray-500 text-[11px] font-semibold flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> 
                                            Exp: {{ $item->end_date->format('d M') }}
                                        </span>
                                        @else
                                        <span class="text-gray-400 text-[11px] font-semibold flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> 
                                            Exp: Permanen
                                        </span>
                                        @endif
                                        
                                        <a href="{{ route('public.announcement-detail', $item->slug) }}" class="text-[#0a256a] text-[13px] font-bold flex items-center gap-1 hover:text-blue-800 transition-colors">
                                            Baca <svg class="w-3.5 h-3.5" fill="none" class="stroke-2" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination Customization --}}
                    <div class="mt-14 flex justify-center">
                        <style>
                            nav[role="navigation"] div.hidden { display: none !important; }
                            nav[role="navigation"] div.flex { justify-content: center; }
                            nav[role="navigation"] a, nav[role="navigation"] span.relative {
                                @apply w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 text-sm font-semibold mx-1 shadow-sm transition-colors;
                            }
                            nav[role="navigation"] span[aria-current="page"] span {
                                @apply w-full h-full flex items-center justify-center bg-[#0a256a] text-white rounded-lg border-[#0a256a];
                            }
                            nav[role="navigation"] a:hover {
                                @apply bg-gray-50 text-[#0a256a] border-gray-300;
                            }
                        </style>
                        <div class="bg-white rounded-xl shadow-[0_2px_10px_rgb(0,0,0,0.03)] border border-gray-100 p-2 inline-flex">
                            {{ $announcements->withQueryString()->links('pagination::tailwind') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pengumuman</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto">Sistem belum mencatat ada pengumuman yang sesuai saat ini.</p>
                    </div>
                @endif
            </div>
            
        </div>
    </section>

@push('scripts')
<script>
    function announcementFilter() {
        return {
            search: '{{ request('search') }}',
            priority: '{{ request('priority') }}',
            bulan: '{{ request('bulan') }}',
            tahun: '{{ request('tahun') }}',
            submitForm() {
                this.$refs.form.submit();
            }
        }
    }
</script>
@endpush
@endsection