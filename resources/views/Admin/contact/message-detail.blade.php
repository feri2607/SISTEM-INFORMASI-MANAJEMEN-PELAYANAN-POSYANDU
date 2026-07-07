{{-- resources/views/admin/contact/message-detail.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Pesan - Sistem Informasi Posyandu')

@section('page-title', 'Detail Pesan')
@section('page-subtitle', 'Lihat detail pesan dari pengunjung')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Pesan</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Informasi lengkap pesan</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $message->status_badge }}">
                        {{ $message->status_label }}
                    </span>
                    @if(!$message->is_read)
                        <form method="POST" action="{{ route('admin.contact.message.read', $message->id) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="px-3 py-1 bg-[#036672] hover:bg-[#036672] text-white text-xs font-medium rounded-lg transition duration-150">
                                Tandai Dibaca
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Sender Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg mb-6">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Nama</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $message->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                    <p class="font-medium text-gray-900 dark:text-white">
                        <a href="mailto:{{ $message->email }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            {{ $message->email }}
                        </a>
                    </p>
                </div>
                @if($message->phone)
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Telepon</p>
                    <p class="font-medium text-gray-900 dark:text-white">
                        <a href="tel:{{ $message->phone }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            {{ $message->phone }}
                        </a>
                    </p>
                </div>
                @endif
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Tanggal</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $message->created_at_formatted }}</p>
                </div>
            </div>

            {{-- Subject --}}
            <div class="mb-4">
                <p class="text-xs text-gray-500 dark:text-gray-400">Subjek</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $message->subject }}</p>
            </div>

            {{-- Message --}}
            <div class="mb-6">
                <p class="text-xs text-gray-500 dark:text-gray-400">Pesan</p>
                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg whitespace-pre-wrap text-gray-700 dark:text-gray-300">
                    {{ $message->message }}
                </div>
            </div>

            {{-- Reply Button --}}
            <div class="flex flex-wrap items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" 
                   class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Balas Email
                </a>
                <a href="{{ route('admin.contact.messages') }}" 
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition duration-150 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 