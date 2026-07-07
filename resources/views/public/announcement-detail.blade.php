{{-- resources/views/public/announcement-detail.blade.php --}}

@extends('layouts.public')

@section('title', $announcement->meta_title ?? $announcement->title . ' - Pengumuman Posyandu')
@section('description', $announcement->meta_description ?? $announcement->excerpt)

@push('styles')
<style>
    .announcement-content {
        @apply text-gray-800 dark:text-gray-200 leading-relaxed;
    }
    .announcement-content h2 {
        @apply text-2xl font-bold mt-8 mb-4 text-gray-900 dark:text-white;
    }
    .announcement-content h3 {
        @apply text-xl font-semibold mt-6 mb-3 text-gray-900 dark:text-white;
    }
    .announcement-content p {
        @apply mb-4;
    }
    .announcement-content ul, .announcement-content ol {
        @apply mb-4 pl-5;
    }
    .announcement-content ul {
        @apply list-disc;
    }
    .announcement-content ol {
        @apply list-decimal;
    }
    .announcement-content li {
        @apply mb-1;
    }
    .announcement-content blockquote {
        @apply border-l-4 border-yellow-500 pl-4 py-2 my-4 bg-gray-50 dark:bg-gray-700/50 rounded-r-lg;
    }
    .announcement-content blockquote p {
        @apply mb-0;
    }
    .announcement-content img {
        @apply rounded-lg shadow-md my-6 max-w-full h-auto;
    }
    .announcement-content table {
        @apply w-full my-4 border-collapse;
    }
    .announcement-content table th {
        @apply bg-gray-100 dark:bg-gray-700 p-2 border border-gray-300 dark:border-gray-600 text-left;
    }
    .announcement-content table td {
        @apply p-2 border border-gray-300 dark:border-gray-600;
    }
    .announcement-content iframe {
        @apply rounded-lg shadow-md my-6 w-full aspect-video;
    }
</style>
@endpush

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition duration-150">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('public.announcements') }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition duration-150">Pengumuman</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 dark:text-white font-medium">{{ $announcement->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-3">
                <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    {{-- Header --}}
                    <div class="p-6 md:p-8 border-b border-gray-200 dark:border-gray-700">
                        {{-- Priority Badge --}}
                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            <span class="px-4 py-1.5 text-sm font-bold rounded-full {{ $announcement->priority_badge }}">
                                @if($announcement->priority === 'very_important')
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                @elseif($announcement->priority === 'important')
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                {{ $announcement->priority_label }}
                            </span>
                            @if($announcement->is_featured)
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">
                                    Featured
                                </span>
                            @endif
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $announcement->category_id ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                                {{ $announcement->category->name ?? 'Umum' }}
                            </span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ $announcement->title }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $announcement->user->name }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $announcement->publish_full }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Berlaku hingga: {{ $announcement->expire_date }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($announcement->views) }} dilihat
                            </span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-6 md:p-8">
                        @if($announcement->attachment && $announcement->is_attachment_image)
                            <div class="mb-6 rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700">
                                <img src="{{ $announcement->attachment_url }}" alt="{{ $announcement->title }}" class="w-full h-auto max-h-[500px] object-cover">
                            </div>
                        @endif

                        <div class="announcement-content">
                            {!! $announcement->content !!}
                        </div>

                        {{-- Attachment --}}
                        @if($announcement->attachment && !$announcement->is_attachment_image)
                            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Lampiran</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $announcement->attachment_name }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ $announcement->attachment_url }}" 
                                       target="_blank"
                                       class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150">
                                        Download
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Share Buttons --}}
                        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Bagikan pengumuman ini:</p>
                            <div class="flex flex-wrap gap-3">
                                <button onclick="shareAnnouncement('whatsapp')" 
                                        class="px-4 py-2 bg-[#25D366] hover:bg-[#1da851] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    WhatsApp
                                </button>
                                <button onclick="shareAnnouncement('facebook')" 
                                        class="px-4 py-2 bg-[#1877f2] hover:bg-[#0d65d9] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    Facebook
                                </button>
                                <button onclick="shareAnnouncement('telegram')" 
                                        class="px-4 py-2 bg-[#0088cc] hover:bg-[#0077b3] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                    </svg>
                                    Telegram
                                </button>
                                <button onclick="shareAnnouncement('twitter')" 
                                        class="px-4 py-2 bg-[#000000] hover:bg-[#1a1a1a] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                    Twitter/X
                                </button>
                                <button onclick="copyLink()" 
                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Salin Link
                                </button>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Related Announcements --}}
                @if($relatedAnnouncements->count() > 0)
                    <div class="mt-12">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Pengumuman Terkait</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($relatedAnnouncements as $related)
                                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 border-l-4 
                                    @if($related->priority === 'very_important') border-red-500
                                    @elseif($related->priority === 'important') border-orange-500
                                    @else border-blue-500 @endif">
                                    <div class="p-4">
                                        <span class="text-xs font-medium {{ $related->priority_badge }}">{{ $related->priority_label }}</span>
                                        <h4 class="font-semibold text-gray-900 dark:text-white mt-1 line-clamp-2">
                                            <a href="{{ route('public.announcement-detail', $related->slug) }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition duration-150">
                                                {{ $related->title }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-2">
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $related->publish_date }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Latest Announcements --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengumuman Terbaru</h3>
                    <div class="space-y-4">
                        @foreach($latestAnnouncements as $latest)
                            <div class="group">
                                <a href="{{ route('public.announcement-detail', $latest->slug) }}" 
                                   class="block hover:text-yellow-600 dark:hover:text-yellow-400 transition duration-150">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <span class="inline-block w-2 h-2 rounded-full 
                                                @if($latest->priority === 'very_important') bg-red-500
                                                @elseif($latest->priority === 'important') bg-orange-500
                                                @else bg-blue-500 @endif">
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white line-clamp-2 group-hover:text-yellow-600 dark:group-hover:text-yellow-400">
                                                {{ $latest->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $latest->publish_date }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Categories --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kategori</h3>
                    <div class="space-y-2">
                        @foreach($categories ?? [] as $category)
                            <a href="{{ route('public.announcements', ['category' => $category->id]) }}" 
                               class="flex items-center justify-between p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition duration-150">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $category->announcements_count ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function shareAnnouncement(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ $announcement->title }}');
        
        let shareUrl = '';
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'whatsapp':
                shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                break;
            case 'telegram':
                shareUrl = `https://t.me/share/url?url=${url}&text=${title}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?text=${title}&url=${url}`;
                break;
        }
        
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }

    function copyLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Link pengumuman telah disalin ke clipboard.',
                timer: 2000,
                showConfirmButton: false,
            });
        });
    }
</script>
@endpush
@endsection