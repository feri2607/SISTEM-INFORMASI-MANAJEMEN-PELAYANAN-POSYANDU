@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">⚙️ Pengaturan Sistem</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Kelola seluruh konfigurasi website Posyandu. Seluruh informasi website publik dan dashboard dikelola dari halaman ini.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $tabs = [
                'profil' => 'Profil Posyandu',
                'landing' => 'Landing Page',
                'about' => 'Tentang Kami',
                'vision' => 'Visi & Misi',
                'organization' => 'Struktur Organisasi',
                'gallery' => 'Galeri',
                'contact' => 'Kontak',
                'location' => 'Lokasi',
                'social' => 'Media Sosial',
                'identity' => 'Logo & Identitas',
                'seo' => 'SEO Website',
                'email' => 'Email Sistem',
                'notification' => 'Notifikasi',
                'security' => 'Keamanan',
                'backup' => 'Backup Database',
                'logs' => 'Log Aktivitas',
                'general' => 'Pengaturan Umum',
            ];
        @endphp

        <div x-data="{ activeTab: '{{ session('active_tab', 'profil') }}' }" class="flex flex-col lg:flex-row gap-8">
            
            {{-- Tabs/Sidebar --}}
            <div class="w-full lg:w-1/4 shrink-0">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-24">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori Pengaturan</h3>
                    </div>
                    <nav class="p-2 space-y-1 max-h-[70vh] overflow-y-auto">
                        @foreach($tabs as $key => $label)
                            <button @click="activeTab = '{{ $key }}'"
                                    :class="activeTab === '{{ $key }}' ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50'"
                                    class="w-full text-left px-4 py-2.5 rounded-lg text-sm transition-colors duration-150 flex items-center justify-between group">
                                {{ $loop->iteration }}. {{ $label }}
                                <svg x-show="activeTab === '{{ $key }}'" class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>

            {{-- Tab Contents --}}
            <div class="w-full lg:w-3/4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 min-h-[500px]">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Hidden input to maintain active tab after submit --}}
                        <input type="hidden" name="active_tab" :value="activeTab">

                        <div class="p-6 sm:p-8">
                            
                            {{-- Tab 1: Profil Posyandu --}}
                            @include('admin.settings.tabs.profil')
                            
                            {{-- Tab 2: Landing Page --}}
                            @include('admin.settings.tabs.landing')

                            {{-- Tab 3: Tentang Kami --}}
                            @include('admin.settings.tabs.about')
                            
                            {{-- Tab 4: Visi & Misi --}}
                            @include('admin.settings.tabs.vision')

                            {{-- Tab 7: Kontak --}}
                            @include('admin.settings.tabs.contact')
                            
                            {{-- Tab 8: Lokasi --}}
                            @include('admin.settings.tabs.location')

                            {{-- Tab 9: Media Sosial --}}
                            @include('admin.settings.tabs.social')

                            {{-- Tab 10: Identitas --}}
                            @include('admin.settings.tabs.identity')

                            {{-- Tab 11: SEO --}}
                            @include('admin.settings.tabs.seo')
                            
                            {{-- Tab 12: Email --}}
                            @include('admin.settings.tabs.email')

                            {{-- Tab 13: Notifikasi --}}
                            @include('admin.settings.tabs.notification')

                            {{-- Tab 14: Keamanan --}}
                            @include('admin.settings.tabs.security')

                            {{-- Tab 15: Backup --}}
                            @include('admin.settings.tabs.backup')
                            
                            {{-- Tab 16: Log Aktivitas --}}
                            @include('admin.settings.tabs.logs')

                            {{-- Tab 17: Pengaturan Umum --}}
                            @include('admin.settings.tabs.general')

                            {{-- Tab 5: Struktur Organisasi --}}
                            @include('admin.settings.tabs.organization')

                            {{-- Tab 6: Galeri --}}
                            @include('admin.settings.tabs.gallery')



                        </div>

                        {{-- Footer Actions --}}
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700 flex items-center justify-end space-x-3">
                            <button type="reset" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-[#036672] border border-transparent rounded-lg shadow-sm hover:bg-[#036672] focus:outline-none focus:ring-2 focus:ring-teal-500">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
