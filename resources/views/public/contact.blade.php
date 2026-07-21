{{-- resources/views/public/contact.blade.php --}}

@extends('layouts.public')

@section('title', 'Kontak Posyandu - Sistem Informasi Posyandu Digital')
@section('description', 'Hubungi Posyandu untuk informasi pelayanan kesehatan ibu dan anak.')

@section('content')
    {{-- Hero Section --}}
    <section class="bg-[#fafbfc] pt-20 pb-16 lg:pt-28 lg:pb-20 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="max-w-xl">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-[#036672] mb-6 tracking-tight">
                        Hubungi Kami
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Kami siap membantu Anda mendapatkan informasi mengenai pelayanan Posyandu. Sampaikan pertanyaan, saran, atau keluhan Anda melalui kanal komunikasi kami.
                    </p>
                    <a href="#form-section" class="inline-flex items-center px-8 py-3.5 bg-[#036672] hover:bg-[#036672] text-white rounded-full font-semibold transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Konsultasi Sekarang
                    </a>
                </div>
                <div class="hidden lg:block relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-100 to-transparent rounded-3xl transform translate-x-4 translate-y-4"></div>
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAGAn60xbV2_RoHzhsACZekDtvaETfjk1ecZa_LEDrZTPF41jEr3htDgEPC199tg1Npx6EIaVXbuhmNZbhA4yx2_z4qilS9KSDfcBUuf_a-9A0ntevxFKHkNncNxnS2KTXSPtYQztOACBCdyifvpcT_83s6dRy1_juwK2zs8xLbtqOeWWPzmzB-vgg7Ve4e71W4-ZAvHN5b1B0lsOgz4_mk4TeR4mN50x1XQfCGECTlsxihZwPiX4896TEwq4n2PtlEO4Iwj9H6r6Y" alt="Layanan Posyandu" class="relative rounded-3xl shadow-xl w-full object-cover z-10 border-4 border-white">
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Cards Section --}}
    <section class="py-12 bg-white relative z-20 -mt-12 sm:-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Alamat Card -->
                <div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col h-full hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-6 text-blue-700">
                        <svg class="w-5 h-5 outline-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">Alamat Kantor</h3>
                    <p class="text-gray-900 text-sm leading-relaxed mb-6 flex-grow">
                        {{ setting('posyandu_address', 'Jl. Kesehatan No. 123') }}{{ setting('posyandu_city') ? ', ' . setting('posyandu_city') : '' }}
                    </p>
                    <a href="{{ setting('location_url') ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode(setting('posyandu_address') . ' ' . setting('posyandu_city')) }}" target="_blank" rel="noopener noreferrer" class="text-[#143d96] font-semibold text-sm hover:text-blue-800 flex items-center mt-auto transition-colors">
                        Buka di Google Maps
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- Jam Operasional Card -->
                <div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col h-full hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-6 text-blue-700">
                        <svg class="w-5 h-5 outline-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">Jam Operasional</h3>
                    <div class="text-gray-900 text-sm leading-relaxed flex-grow">
                        <p class="mb-1">{{ setting('posyandu_service_days', 'Senin - Jumat') }}: {{ setting('posyandu_hours', '08:00 - 16:00') }}</p>
                        @if(setting('posyandu_service_notes'))
                            <p class="text-xs text-gray-500 mt-2">{{ setting('posyandu_service_notes') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Kontak Langsung Card -->
                <div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col h-full hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-6 text-blue-700">
                        <svg class="w-5 h-5 outline-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">Kontak Langsung</h3>
                    <div class="text-gray-900 text-sm leading-relaxed flex-grow">
                        @if(setting('contact_wa'))
                            <p class="mb-1">WhatsApp: 
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', setting('contact_wa')) }}" target="_blank" class="text-gray-900 hover:text-blue-600 transition-colors">{{ setting('contact_wa') }}</a>
                            </p>
                        @endif
                        @if(setting('contact_email'))
                            <p class="mb-1">Email: 
                                <a href="mailto:{{ setting('contact_email') }}" class="text-gray-900 hover:text-blue-600 transition-colors">{{ setting('contact_email') }}</a>
                            </p>
                        @endif
                        @if(setting('contact_phone'))
                            <p class="mb-1">Telepon: 
                                <a href="tel:{{ setting('contact_phone') }}" class="text-gray-900 hover:text-blue-600 transition-colors">{{ setting('contact_phone') }}</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Form and Info Section --}}
    <section id="form-section" class="py-16 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-start">
                
                {{-- Form Box --}}
                <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-[0_8px_40px_rgb(0,0,0,0.06)] border border-gray-100 relative overflow-hidden">
                    {{-- Decorative blur --}}
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-blue-50 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
                    
                    <form method="POST" action="{{ route('contact.send') }}" x-data="contactForm()" @submit="submitForm($event)" class="relative z-10">
                        @csrf
                        
                        <h3 class="text-xl font-bold text-slate-800 mb-8 hidden">Kirim Pesan</h3>
                        
                        @if(session('success'))
                            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl text-sm border border-green-200">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl text-sm border border-red-200">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-[13px] font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" id="name" x-model="form.name" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-400 text-sm text-gray-900 outline-none transition-all placeholder:text-gray-400" placeholder="Masukkan nama..." required>
                                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-[13px] font-semibold text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" id="email" x-model="form.email" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-400 text-sm text-gray-900 outline-none transition-all placeholder:text-gray-400" placeholder="contoh@gmail.com" required>
                                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="phone" class="block text-[13px] font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-400 text-sm text-gray-900 outline-none transition-all placeholder:text-gray-400" placeholder="+62..." value="{{ old('phone') }}">
                                @error('phone')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="subject" class="block text-[13px] font-semibold text-gray-700 mb-2">Subjek</label>
                                <div class="relative">
                                    <input type="text" name="subject" id="subject" x-model="form.subject" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-400 text-sm text-gray-900 outline-none transition-all placeholder:text-gray-400" placeholder="Topik pesan..." required>
                                    @error('subject')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label for="message" class="block text-[13px] font-semibold text-gray-700 mb-2">Pesan</label>
                            <textarea name="message" id="message" rows="5" x-model="form.message" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-400 text-sm text-gray-900 outline-none transition-all resize-none placeholder:text-gray-400" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                            @error('message')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" id="submitButton" x-show="!loading" class="w-full py-3.5 bg-[#036672] hover:bg-[#036672] text-white text-sm font-semibold rounded-xl transition-colors duration-200 shadow-sm shadow-blue-900/20">
                            Kirim Pesan Sekarang
                        </button>
                        <button type="button" x-show="loading" disabled class="w-full py-3.5 bg-[#143d96]/70 text-white text-sm font-semibold rounded-xl cursor-not-allowed flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 mr-3 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                            Mengirim...
                        </button>
                    </form>
                </div>

                {{-- Why Contact Us & Socials --}}
                <div class="flex flex-col py-0 lg:py-6 pl-0 lg:pl-6">
                    <h2 class="text-[17px] font-semibold text-[#036672] mb-8">Mengapa Menghubungi Kami?</h2>
                    
                    <div class="space-y-8 mb-12">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-4 text-[#143d96] mt-0.5">
                                <svg class="w-5 h-5 bg-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 mb-1">Informasi Terpercaya</h4>
                                <p class="text-[13px] text-gray-500 leading-relaxed max-w-sm">Dapatkan data kesehatan dan jadwal imunisasi resmi langsung dari sumbernya.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-4 text-[#143d96] mt-0.5">
                                <svg class="w-5 h-5 bg-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 mb-1">Bantuan Cepat</h4>
                                <p class="text-[13px] text-gray-500 leading-relaxed max-w-sm">Tim kader dan admin kami siap merespons pertanyaan Anda dalam waktu kurang dari 24 jam.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-4 text-[#143d96] mt-0.5">
                                <svg class="w-5 h-5 bg-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 mb-1">Privasi Terjamin</h4>
                                <p class="text-[13px] text-gray-500 leading-relaxed max-w-sm">Data pribadi yang Anda kirimkan melalui formulir ini akan dijaga kerahasiaannya.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">IKUTI KAMI</h4>
                        <div class="flex gap-4">
                            @if(setting('social_facebook'))
                                <a href="{{ setting('social_facebook') }}" target="_blank" class="w-10 h-10 bg-[#f8fafc] hover:bg-[#eff6ff] text-[#143d96] rounded-full flex items-center justify-center transition-colors border border-gray-100">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if(setting('social_instagram'))
                                <a href="{{ setting('social_instagram') }}" target="_blank" class="w-10 h-10 bg-[#f8fafc] hover:bg-[#eff6ff] text-[#143d96] rounded-full flex items-center justify-center transition-colors border border-gray-100">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                </a>
                            @endif
                            @if(setting('social_youtube'))
                                <a href="{{ setting('social_youtube') }}" target="_blank" class="w-10 h-10 bg-[#f8fafc] hover:bg-[#eff6ff] text-[#143d96] rounded-full flex items-center justify-center transition-colors border border-gray-100">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                            <a href="#" class="w-10 h-10 bg-[#f8fafc] hover:bg-[#eff6ff] text-[#143d96] rounded-full flex items-center justify-center transition-colors border border-gray-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Google Maps Section --}}
    @if(setting('location_embed_html'))
    <section id="maps-section" class="py-12 bg-white relative">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 relative bg-gray-100">
                <div class="h-96 md:h-[450px] w-full *:w-full *:h-full">
                    {!! setting('location_embed_html') !!}
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- FAQ Section --}}
    @if($faqs->count() > 0)
    <section class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-lg font-semibold text-[#143d96]">Pertanyaan Sering Diajukan</h2>
            </div>

            <div x-data="{ active: null }" class="space-y-4">
                @foreach($faqs as $index => $faq)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="active = active === {{ $index }} ? null : {{ $index }}"
                                class="w-full px-6 py-5 text-left flex items-center justify-between outline-none hover:bg-slate-50 transition-colors">
                            <span class="font-normal text-[15px] text-gray-800 pr-6">{{ $faq->question }}</span>
                            <span class="flex-shrink-0 text-blue-600 transition-transform duration-300"
                                  :class="{ 'rotate-180': active === {{ $index }} }">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </span>
                        </button>
                        <div x-show="active === {{ $index }}" 
                             x-collapse
                             class="px-6 pb-5 text-[14px] text-gray-500 leading-relaxed pt-2"
                             style="display: none;">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Call to Action component (preserved as per instructions) --}}
    <x-public.cta />

@push('scripts')
<script>
    function contactForm() {
        return {
            loading: false,
            form: {
                name: '{{ old('name') }}',
                email: '{{ old('email') }}',
                subject: '{{ old('subject') }}',
                message: '{{ old('message') }}'
            },
            submitForm(event) {
                this.loading = true;
                // Let the native form submit proceed
            }
        }
    }
</script>
@endpush
@endsection