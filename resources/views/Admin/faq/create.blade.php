{{-- resources/views/admin/faq/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tambah FAQ - Sistem Informasi Posyandu')

@section('page-title', 'Tambah FAQ')
@section('page-subtitle', 'Buat pertanyaan yang sering diajukan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.faq.store') }}" 
                  x-ref="form"
                  x-data="faqForm()"
                  @submit.prevent="submitForm">
                @csrf

                <div class="space-y-6">
                    {{-- Question --}}
                    <div>
                        <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Pertanyaan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="question" id="question" rows="2" 
                                  x-model="form.question"
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900 dark:text-white"
                                  required>{{ old('question') }}</textarea>
                        @error('question')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Answer --}}
                    <div>
                        <label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Jawaban <span class="text-red-500">*</span>
                        </label>
                        <textarea name="answer" id="answer" rows="6" 
                                  x-model="form.answer"
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900 dark:text-white"
                                  required>{{ old('answer') }}</textarea>
                        @error('answer')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category & Status --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Kategori
                            </label>
                            <select name="category" id="category" 
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900 dark:text-white">
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" 
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900 dark:text-white">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Sort Order & Featured --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Urutan
                            </label>
                            <input type="number" name="sort_order" id="sort_order" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('sort_order', $faq->sort_order ?? 0) }}" min="0">
                            @error('sort_order')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                                   {{ old('is_featured', $faq->is_featured ?? false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <label for="is_featured" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                Tandai sebagai Populer
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.faq.index') }}" 
                           class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition duration-150">
                            Kembali
                        </a>
                        <button type="reset" 
                                class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition duration-150">
                            Reset
                        </button>
                    </div>
                    <button type="submit" 
                            id="submitButton"
                            x-show="!loading"
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan
                    </button>
                    <button type="button" 
                            x-show="loading"
                            disabled
                            class="px-8 py-2.5 bg-purple-400 cursor-not-allowed text-white font-medium rounded-lg flex items-center">
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
    function faqForm() {
        return {
            loading: false,
            form: {
                question: '{{ old('question') }}',
                answer: '{{ old('answer') }}',
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
