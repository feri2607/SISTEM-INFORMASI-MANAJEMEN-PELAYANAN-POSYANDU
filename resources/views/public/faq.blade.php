{{-- resources/views/public/faq.blade.php --}}

@extends('layouts.public')

@section('title', 'Pusat Bantuan Posyandu - Sistem Informasi Posyandu Digital')
@section('description', 'Temukan jawaban atas pertanyaan yang paling sering diajukan mengenai layanan Posyandu.')

@section('content')
<div class="bg-gray-50 min-h-screen pb-16 font-sans text-gray-800">
    {{-- Header / Hero Section --}}
    <section class="pt-16 pb-12 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <span class="inline-block py-1 px-4 rounded-full bg-teal-100 text-[#036672] text-xs font-bold tracking-widest mb-6 uppercase">Pusat Bantuan</span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Pusat Bantuan & FAQ</h1>
        <p class="text-gray-600 mb-10 max-w-xl mx-auto text-sm md:text-base">Temukan jawaban cepat untuk pertanyaan umum mengenai layanan dan sistem Posyandu Digital secara mandiri.</p>
        
        {{-- Search Bar --}}
        <div class="relative max-w-2xl mx-auto">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" 
                   id="faqSearch"
                   placeholder="Cari bantuan atau pertanyaan..." 
                   class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl bg-white text-gray-900 focus:ring-2 focus:ring-[#036672] focus:border-transparent outline-none shadow-sm transition"
                   x-data="faqSearch()"
                   @input.debounce="searchFaqs()">
        </div>
    </section>

    {{-- 4 Highlight Cards --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            {{-- Card 1 --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 mx-auto bg-teal-50 rounded-xl flex items-center justify-center mb-4 text-[#036672]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Pendaftaran</h3>
                <p class="text-[11px] md:text-xs text-gray-500">Panduan akun baru</p>
            </div>
            {{-- Card 2 --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 mx-auto bg-teal-50 rounded-xl flex items-center justify-center mb-4 text-[#036672]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Layanan Balita</h3>
                <p class="text-[11px] md:text-xs text-gray-500">Imunisasi & Tumbuh kembang</p>
            </div>
            {{-- Card 3 --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 mx-auto bg-teal-50 rounded-xl flex items-center justify-center mb-4 text-[#036672]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Kesehatan Reproduksi</h3>
                <p class="text-[11px] md:text-xs text-gray-500">Layanan KB & Konsultasi</p>
            </div>
            {{-- Card 4 --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 mx-auto bg-teal-50 rounded-xl flex items-center justify-center mb-4 text-[#036672]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Keamanan Akun</h3>
                <p class="text-[11px] md:text-xs text-gray-500">Privasi & Verifikasi data</p>
            </div>
        </div>
    </section>

    {{-- Main Content: Sidebar + FAQ List --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-16" id="faqContainer" x-data="faqAccordion()" x-init="initFaqs({{ Js::from($faqs) }})">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            
            {{-- Category Sidebar --}}
            <div class="lg:w-1/4 flex-shrink-0">
                <h4 class="text-[10px] font-bold text-[#036672] uppercase tracking-widest mb-4 ml-2">Kategori</h4>
                <div class="space-y-1">
                    <button @click="categoryFilter = ''; filterFaqs()" 
                            :class="{'bg-[#036672]/10 text-[#036672] font-semibold': categoryFilter === '', 'text-gray-600 hover:bg-gray-100': categoryFilter !== ''}"
                            class="w-full text-left px-4 py-2.5 text-sm rounded-xl transition-colors">
                        Semua Kategori
                    </button>
                    @foreach($categories as $key => $label)
                    <button @click="categoryFilter = '{{ $key }}'; filterFaqs()" 
                            :class="{'bg-[#036672]/10 text-[#036672] font-semibold': categoryFilter === '{{ $key }}', 'text-gray-600 hover:bg-gray-100': categoryFilter !== '{{ $key }}'}"
                            class="w-full text-left px-4 py-2.5 text-sm rounded-xl transition-colors">
                        {{ $label }}
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- FAQ Accordion List --}}
            <div class="lg:w-3/4">
                <div x-show="filteredFaqs.length === 0" class="text-center py-12">
                    <p class="text-gray-500">Tidak ada pertanyaan yang sesuai dengan pencarian Anda.</p>
                </div>

                <div x-show="filteredFaqs.length > 0" class="space-y-3">
                    <template x-for="(faq, index) in filteredFaqs" :key="faq.id">
                        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden hover:border-teal-200 transition-colors shadow-sm">
                            <button @click="toggleFaq(index)" class="w-full text-left px-6 py-4 flex items-center justify-between focus:outline-none group">
                                <span class="font-medium text-gray-800 text-sm md:text-base group-hover:text-[#036672] transition-colors" x-html="highlightText(faq.question)"></span>
                                <svg class="w-5 h-5 text-gray-400 transform transition-transform group-hover:text-[#036672]" 
                                     :class="{'rotate-180': activeIndex === index}" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="activeIndex === index"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="px-6 pb-5">
                                <div class="pt-2 border-t border-gray-100">
                                    <div class="text-gray-500 text-sm leading-relaxed" x-html="highlightText(faq.answer)"></div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Box (Bottom) --}}
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-gradient-to-br from-teal-50 to-blue-50 rounded-2xl p-8 lg:p-10 text-center border border-teal-100/50">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Tidak menemukan jawaban?</h2>
            <p class="text-gray-500 mb-8 text-sm max-w-lg mx-auto">Tim dukungan kami siap membantu Anda 24/7 untuk segala pertanyaan teknis maupun medis.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-[#036672] text-white text-sm font-semibold rounded-xl hover:bg-teal-800 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Hubungi Kami
                </a>
                <a href="mailto:support@posyandu.id" class="inline-flex items-center justify-center px-6 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Kirim Email
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    function faqAccordion() {
        return {
            faqs: [],
            filteredFaqs: [],
            activeIndex: null,
            searchTerm: '',
            categoryFilter: '',
            
            initFaqs(faqs) {
                this.faqs = faqs;
                this.filteredFaqs = faqs;
                
                const params = new URLSearchParams(window.location.search);
                const search = params.get('search');
                const category = params.get('category');
                
                if (search) {
                    this.searchTerm = search;
                    const el = document.getElementById('faqSearch');
                    if(el) el.value = search;
                }
                if (category) {
                    this.categoryFilter = category;
                }
                
                this.filterFaqs();
                
                if (search && this.filteredFaqs.length > 0) {
                    this.activeIndex = 0;
                }
            },
            
            toggleFaq(index) {
                this.activeIndex = this.activeIndex === index ? null : index;
            },
            
            filterFaqs() {
                this.filteredFaqs = this.faqs.filter(faq => {
                    let match = true;
                    
                    if (this.searchTerm) {
                        const term = this.searchTerm.toLowerCase();
                        match = match && (
                            faq.question.toLowerCase().includes(term) ||
                            faq.answer.toLowerCase().includes(term) ||
                            (faq.category_label && faq.category_label.toLowerCase().includes(term))
                        );
                    }
                    
                    if (this.categoryFilter) {
                        match = match && faq.category === this.categoryFilter;
                    }
                    
                    return match;
                });
                
                this.activeIndex = null;
            },
            
            highlightText(text) {
                if (!this.searchTerm || !text) return text;
                const term = this.searchTerm.toLowerCase();
                const regex = new RegExp(`(${term})`, 'gi');
                return text.replace(regex, '<mark class="bg-yellow-100 text-[#036672] px-1 rounded">$1</mark>');
            }
        }
    }
    
    function faqSearch() {
        return {
            searchFaqs() {
                const search = document.getElementById('faqSearch').value;
                const container = document.getElementById('faqContainer');
                
                if (container && container._x_dataStack) {
                    const data = container._x_dataStack[0];
                    if (data) {
                        data.searchTerm = search;
                        data.filterFaqs();
                        
                        const params = new URLSearchParams(window.location.search);
                        if (search) {
                            params.set('search', search);
                        } else {
                            params.delete('search');
                        }
                        window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
                    }
                }
            }
        }
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const container = document.getElementById('faqContainer');
            if (container && container._x_dataStack) {
                const data = container._x_dataStack[0];
                if (data) {
                    data.activeIndex = null;
                }
            }
        }
    });
</script>
@endpush