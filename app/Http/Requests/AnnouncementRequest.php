<?php
// app/Http/Requests/AnnouncementRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $announcement = $this->route('announcement');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('announcements')->ignore($announcement)],
            'category_id' => ['required', 'exists:announcement_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'priority' => ['required', Rule::in(['normal', 'important', 'very_important'])],
            'status' => ['required', Rule::in(['draft', 'published', 'scheduled', 'archived'])],
            'publish_at' => ['nullable', 'date', 'after_or_equal:today'],
            'expire_at' => ['nullable', 'date', 'after:publish_at'],
            'attachment' => ['nullable', 'file', 'max:5120', 'mimes:pdf,docx,xlsx,png,jpg,jpeg,webp'],
            'is_featured' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul pengumuman wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'content.required' => 'Konten pengumuman wajib diisi.',
            'priority.required' => 'Prioritas wajib dipilih.',
            'priority.in' => 'Prioritas tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'publish_at.after_or_equal' => 'Tanggal publikasi harus hari ini atau setelahnya.',
            'expire_at.after' => 'Tanggal berakhir harus setelah tanggal publikasi.',
            'attachment.max' => 'Ukuran lampiran maksimal 5 MB.',
            'attachment.mimes' => 'Format lampiran harus PDF, DOCX, XLSX, PNG, JPG, JPEG, atau WEBP.',
        ];
    }
}