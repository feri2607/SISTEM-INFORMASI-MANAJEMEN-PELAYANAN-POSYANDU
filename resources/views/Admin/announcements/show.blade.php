@extends('layouts.app')

@section('title', 'Detail Pengumuman - Sistem Informasi Posyandu')

@section('page-title', 'Detail Pengumuman')
@section('page-subtitle', 'Tinjauan detail pengumuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 font-sans">
            <div class="flex items-center justify-between mb-4">
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $announcement->priority_badge }}">
                    {{ $announcement->priority_label }}
                </span>
                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $announcement->status_badge }}">
                    {{ $announcement->status_label }}
                </span>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $announcement->title }}</h1>
            
            <div class="flex flex-wrap text-sm text-gray-500 dark:text-gray-400 gap-4 mt-4">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ $announcement->user->name ?? 'Tidak diketahui' }}
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Terbit: {{ $announcement->publish_date ?? '-' }}
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Berakhir: {{ $announcement->expire_date ?? '-' }}
                </div>
            </div>
        </div>

        {{-- Body Content --}}
        <div class="p-6 text-gray-800 dark:text-gray-200 prose dark:prose-invert max-w-none">
            @if($announcement->excerpt)
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg italic border-l-4 border-yellow-500">
                {{ $announcement->excerpt }}
            </div>
            @endif

            <div class="mt-4 break-words">
                {!! $announcement->content !!}
            </div>
            
            @if($announcement->attachment)
                <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Lampiran Tersedia</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $announcement->attachment_name ?? 'Download File' }}</p>
                        </div>
                    </div>
                    <a href="{{ $announcement->attachment_url ?? '#' }}" target="_blank" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150">
                        Lihat / Unduh
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Meta/SEO info (optional, just for admin context) --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Tambahan SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="block text-gray-500 dark:text-gray-400">Meta Title</span>
                <span class="block text-gray-900 dark:text-white font-medium">{{ $announcement->meta_title ?? '-' }}</span>
            </div>
            <div>
                <span class="block text-gray-500 dark:text-gray-400">Meta Keywords</span>
                <span class="block text-gray-900 dark:text-white font-medium">{{ $announcement->meta_keywords ?? '-' }}</span>
            </div>
        </div>
        <div class="mt-4 text-sm">
            <span class="block text-gray-500 dark:text-gray-400">Meta Description</span>
            <span class="block text-gray-900 dark:text-white font-medium">{{ $announcement->meta_description ?? '-' }}</span>
        </div>
    </div>

    {{-- Bottom Actions --}}
    <div class="flex gap-4">
        <a href="{{ route('admin.announcements.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition duration-150">
            Kembali
        </a>
        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg font-medium transition duration-150">
            Edit Pengumuman
        </a>
    </div>
</div>
@endsection
