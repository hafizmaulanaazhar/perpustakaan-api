<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_borrow_book(): void
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['*']
        );

        $book = Book::factory()->create(['stock' => 3]);

        $loanData = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'due_date' => now()->addDays(14)->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/loans', $loanData);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Book loan created successfully']);

        $this->assertDatabaseHas('book_loans', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'return_date' => null,
        ]);

        $this->assertEquals(2, $book->fresh()->stock);
    }

    public function test_cannot_borrow_out_of_stock_book(): void
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['*']
        );

        $book = Book::factory()->create(['stock' => 0]);

        $loanData = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'due_date' => now()->addDays(14)->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/loans', $loanData);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Book is out of stock']);

        $this->assertEquals(0, $book->fresh()->stock);
    }
}
