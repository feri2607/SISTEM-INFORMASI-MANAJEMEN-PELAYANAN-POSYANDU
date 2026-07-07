@extends('layouts.app')

@section('title', 'Edit Pengumuman - Sistem Informasi Posyandu')

@section('page-title', 'Edit Pengumuman')
@section('page-subtitle', 'Ubah data pengumuman ini')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" 
                  enctype="multipart/form-data"
                  x-data="announcementForm()"
                  x-ref="form"
                  @submit.prevent="submitForm">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" 
                               x-model="form.title"
                               @input="generateSlug()"
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('title', $announcement->title) }}" required>
                        @error('title')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Slug
                        </label>
                        <input type="text" name="slug" id="slug" 
                               x-model="form.slug"
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white font-mono text-sm"
                               value="{{ old('slug', $announcement->slug) }}">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong untuk generate otomatis</p>
                        @error('slug')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category & Priority --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" 
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white">
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $announcement->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Prioritas <span class="text-red-500">*</span>
                            </label>
                            <select name="priority" id="priority" 
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white">
                                <option value="normal" {{ old('priority', $announcement->priority) == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="important" {{ old('priority', $announcement->priority) == 'important' ? 'selected' : '' }}>Penting</option>
                                <option value="very_important" {{ old('priority', $announcement->priority) == 'very_important' ? 'selected' : '' }}>Sangat Penting</option>
                            </select>
                            @error('priority')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status & Dates --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" 
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white">
                                <option value="draft" {{ old('status', $announcement->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $announcement->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="scheduled" {{ old('status', $announcement->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            </select>
                            @error('status')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="publish_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Tanggal Publikasi
                            </label>
                            <input type="datetime-local" name="publish_at" id="publish_at" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('publish_at', $announcement->publish_at ? \Carbon\Carbon::parse($announcement->publish_at)->format('Y-m-d\TH:i') : '') }}">
                            @error('publish_at')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="expire_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Tanggal Berakhir
                            </label>
                            <input type="datetime-local" name="expire_at" id="expire_at" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('expire_at', $announcement->expire_at ? \Carbon\Carbon::parse($announcement->expire_at)->format('Y-m-d\TH:i') : '') }}">
                            @error('expire_at')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Featured --}}
                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                               {{ old('is_featured', $announcement->is_featured) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                        <label for="is_featured" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                            Jadikan Pengumuman Featured
                        </label>
                    </div>

                    {{-- Excerpt --}}
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Ringkasan
                        </label>
                        <textarea name="excerpt" id="excerpt" rows="3" 
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white"
                                  placeholder="Ringkasan pengumuman...">{{ old('excerpt', $announcement->excerpt) }}</textarea>
                        @error('excerpt')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Content --}}
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Konten <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content" id="content" rows="15" 
                                  x-model="form.content"
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white font-mono"
                                  placeholder="Tulis konten pengumuman di sini...">{{ old('content', $announcement->content) }}</textarea>
                        @error('content')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Attachment --}}
                    <div>
                        <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Ubah Lampiran (Biarkan kosong jika tidak ingin mengubah)
                        </label>
                        @if($announcement->attachment)
                            <div class="mb-2 p-3 bg-gray-100 dark:bg-gray-700 rounded text-sm text-gray-700 dark:text-gray-300 flex items-center justify-between">
                                <span>Lampiran saat ini: <strong>{{ basename($announcement->attachment) }}</strong></span>
                                <a href="{{ Storage::url($announcement->attachment) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                            </div>
                        @else
                            <div class="mb-2 p-3 bg-gray-100 dark:bg-gray-700 rounded text-sm text-gray-500 dark:text-gray-400 fade-in">
                                Tidak ada lampiran sebelumnya
                            </div>
                        @endif
                        <input type="file" name="attachment" id="attachment" 
                               accept=".pdf,.docx,.xlsx,.png,.jpg,.jpeg,.webp"
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 dark:file:bg-yellow-900/30 dark:file:text-yellow-400">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PDF, DOCX, XLSX, PNG, JPG, JPEG, WEBP (Maks. 5MB)</p>
                        @error('attachment')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Meta SEO --}}
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">SEO</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Meta Title
                                </label>
                                <input type="text" name="meta_title" id="meta_title" 
                                       class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white"
                                       value="{{ old('meta_title', $announcement->meta_title) }}">
                                @error('meta_title')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Meta Description
                                </label>
                                <textarea name="meta_description" id="meta_description" rows="2" 
                                          class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white"
                                          placeholder="Deskripsi untuk SEO...">{{ old('meta_description', $announcement->meta_description) }}</textarea>
                                @error('meta_description')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Meta Keywords
                                </label>
                                <input type="text" name="meta_keywords" id="meta_keywords" 
                                       class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-gray-900 dark:text-white"
                                       placeholder="Kata kunci dipisahkan koma"
                                       value="{{ old('meta_keywords', $announcement->meta_keywords) }}">
                                @error('meta_keywords')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.announcements.index') }}" 
                           class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition duration-150">
                            Batal
                        </a>
                    </div>
                    <button type="submit" 
                            id="submitButton"
                            x-show="!loading"
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <button type="button" 
                            x-show="loading"
                            disabled
                            class="px-8 py-2.5 bg-yellow-400 cursor-not-allowed text-white font-medium rounded-lg flex items-center">
                        <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function announcementForm() {
        return {
            loading: false,
            form: {
                title: @json(old('title', $announcement->title)),
                slug: @json(old('slug', $announcement->slug)),
                content: @json(old('content', $announcement->content))
            },
            generateSlug() {
                if (!this.form.slug) {
                    this.form.slug = this.form.title
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                }
            },
            submitForm() {
                this.loading = true;
                this.$refs.form.submit();
            }
        }
    }
</script>
@endpush
@endsection
