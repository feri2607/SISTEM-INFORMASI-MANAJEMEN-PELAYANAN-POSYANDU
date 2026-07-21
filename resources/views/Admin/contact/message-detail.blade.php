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

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-lg text-sm border border-green-200 dark:border-green-800">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 rounded-lg text-sm border border-red-200 dark:border-red-800">
                    ❌ {{ session('error') }}
                </div>
            @endif

            {{-- Reply Form --}}
            <form method="POST" action="{{ route('admin.contact.message.reply', $message->id) }}"
                  class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                @csrf
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#036672]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Balas Pesan
                </h4>

                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                    <div class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        Kepada: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $message->name }}</span>
                        &lt;<span class="text-blue-600 dark:text-blue-400">{{ $message->email }}</span>&gt;
                    </div>
                    <div class="mb-3 text-sm text-gray-500 dark:text-gray-400">
                        Subjek: <span class="font-medium text-gray-700 dark:text-gray-300">Re: {{ $message->subject }}</span>
                    </div>
                    <textarea name="reply_body" rows="6"
                              class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-[#036672]/30 focus:border-[#036672] outline-none resize-y transition-all @error('reply_body') border-red-400 @enderror"
                              placeholder="Tulis balasan Anda di sini...">{{ old('reply_body') }}</textarea>
                    @error('reply_body')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap items-center gap-3 mt-4">
                    <button type="submit"
                            class="px-5 py-2.5 bg-[#036672] hover:bg-[#025560] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Balasan
                    </button>
                    <a href="{{ route('admin.contact.messages') }}"
                       class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition duration-150 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection