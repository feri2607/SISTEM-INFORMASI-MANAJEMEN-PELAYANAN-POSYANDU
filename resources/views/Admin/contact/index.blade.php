{{-- resources/views/admin/contact/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Kelola Kontak - Sistem Informasi Posyandu')

@section('page-title', 'Kelola Kontak')
@section('page-subtitle', 'Atur informasi kontak Posyandu')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Kontak</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Update informasi kontak yang akan ditampilkan di halaman publik</p>
                </div>
                <a href="{{ route('admin.contact.messages') }}" 
                   class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Pesan Masuk
                    @if($unreadCount > 0)
                        <span class="ml-2 px-2 py-0.5 text-xs font-bold rounded-full bg-[#036672] text-white">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            </div>

            <form method="POST" action="{{ route('admin.contact.update') }}">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Posyandu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('name', $contact->name ?? '') }}" required>
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" id="address" rows="3" 
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                  required>{{ old('address', $contact->address ?? '') }}</textarea>
                        @error('address')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone & WhatsApp --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="phone" id="phone" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('phone', $contact->phone ?? '') }}" required>
                            @error('phone')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                WhatsApp
                            </label>
                            <input type="text" name="whatsapp" id="whatsapp" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('whatsapp', $contact->whatsapp ?? '') }}">
                            @error('whatsapp')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Email & Website --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('email', $contact->email ?? '') }}" required>
                            @error('email')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Website
                            </label>
                            <input type="url" name="website" id="website" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('website', $contact->website ?? '') }}">
                            @error('website')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Social Media --}}
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Media Sosial</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Facebook
                                </label>
                                <input type="url" name="facebook" id="facebook" 
                                       class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                       value="{{ old('facebook', $contact->facebook ?? '') }}">
                            </div>
                            <div>
                                <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Instagram
                                </label>
                                <input type="url" name="instagram" id="instagram" 
                                       class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                       value="{{ old('instagram', $contact->instagram ?? '') }}">
                            </div>
                            <div>
                                <label for="youtube" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    YouTube
                                </label>
                                <input type="url" name="youtube" id="youtube" 
                                       class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                       value="{{ old('youtube', $contact->youtube ?? '') }}">
                            </div>
                            <div>
                                <label for="tiktok" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    TikTok
                                </label>
                                <input type="url" name="tiktok" id="tiktok" 
                                       class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                       value="{{ old('tiktok', $contact->tiktok ?? '') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Google Maps & Office Hours --}}
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div>
                            <label for="google_maps_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Google Maps Embed URL
                            </label>
                            <textarea name="google_maps_url" id="google_maps_url" rows="3" 
                                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                      placeholder="<iframe src='...'></iframe>">{{ old('google_maps_url', $contact->google_maps_url ?? '') }}</textarea>
                            @error('google_maps_url')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="office_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Jam Operasional <span class="text-red-500">*</span>
                            </label>
                            <textarea name="office_hours" id="office_hours" rows="5" 
                                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                      required>{{ old('office_hours', $contact->office_hours ?? '') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Setiap baris mewakili satu baris jam operasional</p>
                            @error('office_hours')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-wrap items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" 
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection