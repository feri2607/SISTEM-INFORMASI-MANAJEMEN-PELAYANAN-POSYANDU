<?php
// app/Http/Requests/FaqRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $faq = $this->route('faq');

        return [
            'question' => ['required', 'string', 'min:5', 'max:500'],
            'answer' => ['required', 'string', 'min:10'],
            'category' => ['nullable', 'string', Rule::in(array_keys(Faq::getCategoryList()))],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['boolean'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'Pertanyaan wajib diisi.',
            'question.min' => 'Pertanyaan minimal 5 karakter.',
            'question.max' => 'Pertanyaan maksimal 500 karakter.',
            'answer.required' => 'Jawaban wajib diisi.',
            'answer.min' => 'Jawaban minimal 10 karakter.',
            'category.in' => 'Kategori tidak valid.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'sort_order.min' => 'Urutan minimal 0.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}