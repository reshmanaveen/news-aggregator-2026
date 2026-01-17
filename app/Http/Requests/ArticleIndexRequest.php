<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q'        => 'nullable|string|max:255',
            'source'   => 'nullable|string|exists:sources,slug',
            'category' => 'nullable|string|max:100',
            'author'   => 'nullable|string|max:255',
            'from'     => 'nullable|date',
            'to'       => 'nullable|date|after_or_equal:from',
            'page'     => 'nullable|integer|min:1',
        ];
    }
}
