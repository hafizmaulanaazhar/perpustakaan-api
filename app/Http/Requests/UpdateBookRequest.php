<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => ['required', 'string', Rule::unique('books')->ignore($this->book)],
            'stock' => 'required|integer|min:0'
        ];
    }

    public function messages()
    {
        return [
            'published_year.digits' => 'The published year must be 4 digits.',
            'published_year.min' => 'The published year must be at least 1900.',
            'published_year.max' => 'The published year may not be greater than the current year.',
        ];
    }
}
