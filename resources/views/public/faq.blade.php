{{-- resources/views/public/faq.blade.php --}}

@extends('layouts.public')

@section('title', 'Pusat Bantuan Posyandu - Sistem Informasi Posyandu Digital')
@section('description', 'Temukan jawaban atas pertanyaan yang paling sering diajukan mengenai layanan Posyandu.')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-teal-700 to-blue-800 py-16 lg:py-20">
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute top-0 right-0 w-full h-full" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="600" cy="200" r="300" fill="white" opacity="0.3"/>
                <circle cx="700" cy="500" r="200" fill="white" opacity="0.2"/>
                <circle cx="400" cy="700" r="250" fill="white" opacity="0.1"/>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center text-sm text-purple-100 mb-4" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition duration-150">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    Beranda
                </a>
                <span class="mx-2 text-purple-300">/</span>
                <span class="text-white font-medium">FAQ</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4">
                        Pusat Bantuan Posyandu
                    </h1>
                    <p class="text-lg text-purple-100 leading-relaxed">
                        Temukan jawaban atas pertanyaan yang paling sering diajukan mengenai layanan Posyandu.
                    </p>
                </div>
                <div class="hidden lg:flex justify-center">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-white/10 rounded-full blur-3xl"></div>
                        <svg class="relative w-48 h-48 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Search & Filter --}}
    <section class="py-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-16 z-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-3">
                {{-- Search --}}
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="faqSearch"
                               placeholder="Cari pertanyaan..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               x-data="faqSearch()"
                               @input.debounce="searchFaqs()">
                    </div>
                </div>

                {{-- Category Filter --}}
                <div>
                    <select id="categoryFilter"
                            x-data="faqSearch()"
                            @change="filterCategory()"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>

    {{-- Popular FAQs --}}
    @if($popularFaqs->count() > 0)
    <section class="py-8 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                FAQ Populer
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($popularFaqs as $faq)
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-150 cursor-pointer"
                         onclick="openFaq({{ $faq->id }})">
                        <div class="flex items-center space-x-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center text-purple-600 dark:text-purple-400 text-xs font-bold">
                                {{ $loop->iteration }}
                            </span>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $faq->question }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- FAQ Accordion --}}
    <section class="py-12 bg-white dark:bg-gray-800" id="faqSection">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="faqContainer"
                 x-data="faqAccordion()"
                 x-init="initFaqs({{ $faqs->toJson() }})">
                
                {{-- Results Count --}}
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4" x-show="filteredFaqs.length > 0">
                    Menampilkan <span x-text="filteredFaqs.length"></span> pertanyaan
                </p>

                {{-- FAQ List --}}
                <div class="space-y-3">
                    <template x-for="(faq, index) in filteredFaqs" :key="faq.id">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition duration-150"
                             :class="{ 'ring-2 ring-purple-500': faq.is_featured }">
                            <button @click="toggleFaq(index)"
                                    class="w-full px-6 py-4 text-left flex items-start justify-between hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 group"
                                    :aria-expanded="activeIndex === index"
                                    :aria-controls="'faq-answer-' + index">
                                <div class="flex-1 pr-4">
                                    <div class="flex items-center gap-2">
                                        <span class="flex-shrink-0 text-sm font-medium text-gray-400" x-text="index + 1 + '.'"></span>
                                        <span class="font-medium text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition duration-150" 
                                              x-html="highlightText(faq.question)"></span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300" 
                                              x-text="faq.category_label || 'Umum'"></span>
                                        <span x-show="faq.is_featured" 
                                              class="px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">
                                            Populer
                                        </span>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200 flex-shrink-0 mt-1"
                                     :class="{ 'rotate-180': activeIndex === index }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="activeIndex === index"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="px-6 pb-4"
                                 :id="'faq-answer-' + index">
                                <div class="pt-2 border-t border-gray-200 dark:border-gray-600">
                                    <div class="text-gray-600 dark:text-gray-400 leading-relaxed" 
                                         x-html="highlightText(faq.answer)"></div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Empty State --}}
                <div x-show="filteredFaqs.length === 0" class="text-center py-16">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Maaf, kami belum menemukan jawaban yang Anda cari.</h3>
                    <p class="text-gray-500 dark:text-gray-400">Coba gunakan kata kunci lain atau hubungi kami melalui halaman Kontak.</p>
                    <a href="{{ route('contact') }}" class="mt-4 inline-block px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
   <section class="py-16 bg-gradient-to-r from-teal-600 to-blue-600 dark:from-teal-800 dark:to-blue-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Siap Bergabung Bersama Posyandu?
        </h2>
        <p class="text-lg text-teal-50 dark:text-gray-300 mb-8">
            Daftarkan keluarga Anda untuk mendapatkan layanan kesehatan ibu dan anak secara digital.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" 
               class="px-8 py-3 bg-white text-teal-700 font-semibold rounded-xl hover:bg-gray-100 transition duration-200 shadow-lg hover:shadow-xl flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Daftar Sekarang
            </a>
            <a href="{{ route('login') }}" 
               class="px-8 py-3 bg-[#036672]/30 text-white font-semibold rounded-xl hover:bg-[#036672]/50 transition duration-200 border border-white/20 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Login
            </a>
        </div>
    </div>
</section>
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
                
                // Check URL params
                const params = new URLSearchParams(window.location.search);
                const search = params.get('search');
                const category = params.get('category');
                
                if (search) {
                    this.searchTerm = search;
                    document.getElementById('faqSearch').value = search;
                }
                if (category) {
                    this.categoryFilter = category;
                    document.getElementById('categoryFilter').value = category;
                }
                
                this.filterFaqs();
                
                // Open first FAQ if search exists
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
                    
                    // Search filter
                    if (this.searchTerm) {
                        const term = this.searchTerm.toLowerCase();
                        match = match && (
                            faq.question.toLowerCase().includes(term) ||
                            faq.answer.toLowerCase().includes(term) ||
                            (faq.category_label && faq.category_label.toLowerCase().includes(term))
                        );
                    }
                    
                    // Category filter
                    if (this.categoryFilter) {
                        match = match && faq.category === this.categoryFilter;
                    }
                    
                    return match;
                });
                
                // Reset active index
                this.activeIndex = null;
            },
            
            highlightText(text) {
                if (!this.searchTerm || !text) return text;
                
                const term = this.searchTerm.toLowerCase();
                const regex = new RegExp(`(${term})`, 'gi');
                
                return text.replace(regex, '<mark class="bg-yellow-200 dark:bg-yellow-800/50 text-gray-900 dark:text-white px-0.5 rounded">$1</mark>');
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
                        
                        // Update URL
                        const params = new URLSearchParams(window.location.search);
                        if (search) {
                            params.set('search', search);
                        } else {
                            params.delete('search');
                        }
                        window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
                    }
                }
            },
            
            filterCategory() {
                const category = document.getElementById('categoryFilter').value;
                const container = document.getElementById('faqContainer');
                
                if (container && container._x_dataStack) {
                    const data = container._x_dataStack[0];
                    if (data) {
                        data.categoryFilter = category;
                        data.filterFaqs();
                        
                        // Update URL
                        const params = new URLSearchParams(window.location.search);
                        if (category) {
                            params.set('category', category);
                        } else {
                            params.delete('category');
                        }
                        window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
                    }
                }
            }
        }
    }
    
    function openFaq(id) {
        const container = document.getElementById('faqContainer');
        if (container && container._x_dataStack) {
            const data = container._x_dataStack[0];
            if (data) {
                const index = data.filteredFaqs.findIndex(f => f.id === id);
                if (index !== -1) {
                    data.activeIndex = index;
                    // Scroll to FAQ section
                    document.getElementById('faqSection').scrollIntoView({ behavior: 'smooth' });
                }
            }
        }
    }
    
    // Keyboard navigation for accordion
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