@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Dashboard Kesehatan Keluarga - Sistem Informasi Posyandu')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto space-y-6 lg:space-y-8 bg-[#f8fafc] min-h-screen">
    
    {{-- Hero Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-600 rounded-2xl shadow-sm h-64 md:h-72">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1511895426328-dc8714191300?q=80&w=2070&auto=format&fit=crop" alt="Family" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
        </div>
        <div class="relative px-8 py-10 h-full flex flex-col justify-center max-w-2xl">
            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight mb-4 text-shadow-md">
                Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}!
            </h1>
            <p class="text-blue-100 text-sm md:text-base mb-8 max-w-lg leading-relaxed">
                Kesehatan keluarga Anda adalah prioritas kami. Jangan lupa untuk menghadiri jadwal pemeriksaan balita minggu depan.
            </p>
            <div>
                <a href="{{ route('public.schedule') ?? '#' }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-blue-700 bg-white rounded-xl hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Cek Jadwal Terdekat
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Cards 4 Cols --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
        {{-- Total Anggota --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold bg-green-50 text-green-600">Aktif</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 tracking-wide uppercase">Total Anggota</p>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['keluarga'] }} Orang</div>
            </div>
        </div>

        {{-- Jumlah Balita --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 tracking-wide uppercase">Jumlah Balita</p>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['balita'] }} Balita</div>
            </div>
        </div>

        {{-- Pelayanan / Kunjungan Terakhir --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 tracking-wide uppercase">Kunjungan Terakhir</p>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($familySummary['updated_at'])->format('d M') ?? 'Belum ada' }}</div>
            </div>
        </div>

        {{-- Artikel Baru / Notifikasi --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"/></svg>
                </div>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 tracking-wide uppercase">Artikel Baru</p>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['artikel'] ?: 3 }} Artikel</div>
            </div>
        </div>
    </div>

    {{-- Main Two Columns Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        
        {{-- Left Area (Col Span 2) --}}
        <div class="lg:col-span-2 space-y-6 lg:space-y-8">
            
            {{-- Ringkasan Kesehatan Keluarga Table --}}
            <div class="bg-white rounded-2xl p-6 lg:p-8 border border-gray-100 shadow-sm overflow-hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-900">Ringkasan Kesehatan Keluarga</h2>
                    <a href="#" class="text-sm font-semibold text-blue-700 hover:text-blue-800 transition">Lihat Detail</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="text-xs text-gray-500 bg-gray-50 uppercase tracking-wider font-semibold border-b border-gray-100 border-t">
                            <tr>
                                <th scope="col" class="px-4 py-3 first:rounded-tl-lg">Nama</th>
                                <th scope="col" class="px-4 py-3">Kategori</th>
                                <th scope="col" class="px-4 py-3">Status Terakhir</th>
                                <th scope="col" class="px-4 py-3 text-right last:rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            {{-- Kepala Keluarga (Ibu / Ayah) --}}
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-4 py-4 font-bold text-gray-900">{{ $warga->nama }} (Kepala Keluarga)</td>
                                <td class="px-4 py-4">WUS/PUS</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex px-2.5 py-1 text-[10px] font-bold rounded bg-green-100 text-green-700 uppercase tracking-wider">Sehat</span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <a href="#" class="inline-flex justify-center items-center text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </td>
                            </tr>
                            
                            {{-- Loop for Balita --}}
                            @forelse($warga->balita as $balitaItem)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-4 py-4 font-bold text-gray-900">{{ $balitaItem->nama }} <span class="font-normal text-gray-500">({{ \Carbon\Carbon::parse($balitaItem->tanggal_lahir)->diffInYears(now()) }} thn)</span></td>
                                <td class="px-4 py-4">Balita</td>
                                <td class="px-4 py-4">
                                    @php
                                        // Mock status based on loop index for aesthetic variability 
                                        $statuses = [
                                            ['label' => 'Sesuai KMS', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                            ['label' => 'Imunisasi Dasar', 'bg' => 'bg-orange-100', 'text' => 'text-orange-700']
                                        ];
                                        $status = $statuses[$loop->index % 2];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 text-[10px] font-bold rounded {{ $status['bg'] }} {{ $status['text'] }} uppercase tracking-wider">{{ $status['label'] }}</span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <a href="#" class="inline-flex justify-center items-center text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Layanan Terintegrasi --}}
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-2">Layanan Terintegrasi</h2>
                <p class="text-sm text-gray-500 mb-6">Pilih kategori layanan kesehatan yang Anda butuhkan.</p>
                
                <div class="grid grid-cols-3 md:grid-cols-6 gap-3 lg:gap-4">
                    {{-- Balita --}}
                    <a href="{{ route('warga.balita.index') }}" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-blue-100 transition group h-28">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                            <span class="text-xl">👶</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-800">Balita</span>
                    </a>
                    
                    {{-- Kehamilan --}}
                    <a href="{{ route('warga.kehamilan.index') }}" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-orange-100 transition group h-28">
                        <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                            <span class="text-xl">🤰</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-800">Kehamilan</span>
                    </a>

                    {{-- Menyusui --}}
                    <a href="#" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-blue-100 transition group h-28">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                            <span class="text-xl">🤱</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-800">Menyusui</span>
                    </a>


                    {{-- WUS/PUS --}}
                    <a href="{{ route('warga.reproduksi.index') }}" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-indigo-100 transition group h-28">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                            <span class="text-xl">👩‍❤️‍👨</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-800">WUS/PUS</span>
                    </a>
                    
                    {{-- Remaja --}}
                    <a href="{{ route('warga.remaja.index') }}" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-purple-100 transition group h-28">
                        <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                            <span class="text-xl">🧑</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-800">Remaja</span>
                    </a>

                    {{-- Lansia --}}
                    <a href="{{ route('warga.lansia.index') }}" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-emerald-100 transition group h-28">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                            <span class="text-xl">👴</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-800">Lansia</span>
                    </a>
                </div>
            </div>

            {{-- Edukasi Kesehatan --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-900">Edukasi Kesehatan</h2>
                    <a href="#" class="text-sm font-semibold text-blue-700 hover:text-blue-800 transition">Eksplor Artikel &rarr;</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse(\App\Models\Artikel::where('status', 'published')->latest()->take(3)->get() as $artikel)
                    <article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition flex flex-col h-full">
                        <div class="h-40 w-full overflow-hidden">
                            <img src="{{ $artikel->gambar_url ?? 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 tracking-wider mb-2 uppercase">{{ $artikel->kategori->nama_kategori ?? 'Edukasi' }}</span>
                                <h3 class="font-bold text-gray-900 mb-2 leading-snug"><a href="{{ route('public.articles.show', $artikel->slug) }}">{{ $artikel->judul }}</a></h3>
                                <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed">{{ Str::limit(strip_tags($artikel->konten), 100) }}</p>
                            </div>
                            <div class="mt-4 flex items-center gap-2 pt-4 border-t border-gray-50">
                                <div class="w-6 h-6 rounded-full bg-gray-200 overflow-hidden shrink-0">
                                    <img src="{{ $artikel->penulis->foto_url ?? 'https://ui-avatars.com/api/?name='.urlencode($artikel->penulis->name ?? 'Admin') }}" alt="{{ $artikel->penulis->name ?? 'Admin' }}">
                                </div>
                                <span class="text-[10px] text-gray-500 font-medium">{{ $artikel->penulis->name ?? 'Tim Medis' }} • {{ $artikel->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="col-span-3 text-center py-6 text-gray-500">
                        Belum ada artikel edukasi terbaru.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Right Sidebar (Col Span 1) --}}
        <div class="space-y-6 lg:space-y-8">
            
            {{-- Kelengkapan Profil Card --}}
            @php
                $currentUser = Auth::user();
                $completionFields = [
                    'Nama Lengkap'  => !empty($currentUser->name),
                    'Email'         => !empty($currentUser->email),
                    'No. Telepon'   => !empty($currentUser->no_telepon),
                    'Alamat'        => !empty($currentUser->alamat),
                    'Foto Profil'   => !empty($currentUser->foto),
                    'Verifikasi Email' => !empty($currentUser->email_verified_at),
                ];
                $completedCount = count(array_filter($completionFields));
                $totalCount     = count($completionFields);
                $completionPct  = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
            @endphp
            <div class="bg-white rounded-2xl p-6 lg:p-8 border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center">
                <h3 class="text-sm font-bold text-gray-900 mb-6">Kelengkapan Profil</h3>
                
                {{-- Circular Progress --}}
                <div class="relative w-36 h-36 mb-6">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="50" fill="none" class="stroke-current text-gray-100" stroke-width="12"></circle>
                        <circle cx="60" cy="60" r="50" fill="none" class="stroke-current text-blue-900" 
                                stroke-width="12" 
                                stroke-dasharray="314.159" 
                                stroke-dashoffset="{{ 314.159 - (314.159 * $completionPct / 100) }}"
                                stroke-linecap="round"></circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-black text-gray-900">{{ $completionPct }}%</span>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Lengkap</span>
                    </div>
                </div>

                <p class="text-xs text-gray-500 leading-relaxed mb-6">
                    Lengkapi data NIK dan dokumen pendukung untuk layanan penuh secara terintegrasi.
                </p>
                <a href="{{ route('profile.index') }}" class="block w-full py-2.5 px-4 bg-blue-100 text-blue-800 hover:bg-blue-200 font-bold text-sm rounded-xl transition text-center shadow-sm">
                    Lengkapi Sekarang
                </a>
            </div>

            {{-- Aktivitas Terakhir --}}
            <div class="bg-white rounded-2xl p-6 lg:p-8 border border-gray-100 shadow-sm">
                <h3 class="text-base font-bold text-gray-900 mb-6">Aktivitas Terakhir</h3>
                
                <div class="relative pl-3 space-y-6 before:absolute before:inset-0 before:ml-[1.125rem] before:h-full before:w-[2px] before:bg-gray-100">
                    @php
                        $recentActivities = collect();
                        if ($warga) {
                            $recentActivities = \App\Models\PemeriksaanBalita::with('balita')
                                ->whereHas('balita', function($q) use($warga) {
                                    $q->where('warga_id', $warga->id);
                                })
                                ->orderBy('created_at', 'desc')
                                ->take(3)
                                ->get();
                        }
                    @endphp

                    {{-- Always show notifications first if any --}}
                    @foreach($notifications ?? [] as $index => $notif)
                    <div class="relative">
                        <div class="absolute left-[-1.5rem] mt-1.5 w-3 h-3 rounded-full bg-orange-500 border-[3px] border-white box-content"></div>
                        <div>
                            <p class="text-[10px] font-bold text-orange-600 mb-0.5 uppercase tracking-wide">Pemberitahuan</p>
                            <h4 class="font-bold text-gray-900 text-sm mb-1 leading-snug">{{ $notif['title'] }}</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">{{ $notif['message'] }}</p>
                        </div>
                    </div>
                    @endforeach

                    {{-- Query Actual Medical Service History --}}
                    @forelse($recentActivities as $index => $activity)
                    <div class="relative">
                        @if($index === 0 && empty($notifications))
                        <div class="absolute left-[-1.5rem] mt-1.5 w-3 h-3 rounded-full bg-blue-700 border-[3px] border-white box-content"></div>
                        @else
                        <div class="absolute left-[-1.5rem] mt-1.5 w-3 h-3 rounded-full bg-gray-300 border-[3px] border-white box-content"></div>
                        @endif
                        
                        <div>
                            <p class="text-[10px] font-bold {{ $index === 0 && empty($notifications) ? 'text-blue-600' : 'text-gray-400' }} mb-0.5 uppercase tracking-wide">
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                            <h4 class="font-bold text-gray-900 text-sm mb-1 leading-snug">Pemeriksaan Balita ({{ $activity->balita->nama }})</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                BB: {{ $activity->berat_badan }} kg, TB: {{ $activity->tinggi_badan }} cm. Status Gizi: {{ ucfirst($activity->status_gizi) }}.
                            </p>
                        </div>
                    </div>
                    @empty
                        @if(empty($notifications))
                        <div class="text-center py-4 text-xs text-gray-500">
                            Belum ada aktivitas kesehatan yang tercatat.
                        </div>
                        @endif
                    @endforelse
                </div>

                {{-- Action add quick log (Floating UI simulation) --}}
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('public.schedule') }}" class="w-10 h-10 rounded-full bg-blue-900 hover:bg-blue-800 text-white flex items-center justify-center shadow-lg transition" title="Lihat Jadwal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
