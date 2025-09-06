<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::factory(30)->create()->each(function ($book) {
            if ($book->stock === 0) {
                $book->update(['stock' => rand(1, 5)]);
            }
        });
    }
}
