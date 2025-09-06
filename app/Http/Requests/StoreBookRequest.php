<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
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
            'isbn' => ['required', 'string', 'unique:books,isbn'],
            'stock' => 'required|integer|min:0'
        ];
    }
}
