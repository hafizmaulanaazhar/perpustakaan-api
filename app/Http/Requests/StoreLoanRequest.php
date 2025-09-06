<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Book;

class StoreLoanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => [
                'required',
                'exists:books,id',
                function ($attribute, $value, $fail) {
                    $book = Book::find($value);
                    if ($book && $book->available_stock <= 0) {
                        $fail('The book is out of stock.');
                    }
                }
            ],
            'due_date' => 'required|date|after:today'
        ];
    }
}
