<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'published_year' => 'sometimes|required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => ['sometimes', 'required', 'string', Rule::unique('books', 'isbn')->ignore($this->book)],
            'stock' => 'sometimes|required|integer|min:0',
        ];
    }
}
