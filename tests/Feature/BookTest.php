<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;

class BookTest extends TestCase
{
    public function test_can_create_book()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $bookData = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'published_year' => 2023,
            'isbn' => '1234567890123',
            'stock' => 5
        ];

        $response = $this->post(route('books.store'), $bookData);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', $bookData);
    }

    public function test_cannot_borrow_when_out_of_stock()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 0]);

        $response = $this->postJson('/api/loans', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'due_date' => now()->addDays(14)->format('Y-m-d')
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['book_id']);
    }
}
