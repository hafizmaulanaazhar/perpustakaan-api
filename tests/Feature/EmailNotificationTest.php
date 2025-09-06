<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use App\Jobs\SendLoanNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;
use App\Mail\BookLoaned;

class EmailNotificationTest extends TestCase
{
    public function test_email_notification_job()
    {
        Queue::fake();
        Mail::fake();

        // Create user and book
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 5]);

        // Create loan
        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14)
        ]);

        // Dispatch job
        SendLoanNotification::dispatch($loan);

        // Assert job was pushed to queue
        Queue::assertPushed(SendLoanNotification::class, function ($job) use ($loan) {
            return $job->loan->id === $loan->id;
        });

        // Process the job
        $job = new SendLoanNotification($loan);
        $job->handle();

        // Assert email was sent
        Mail::assertSent(BookLoaned::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_email_content()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $loan = Loan::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);

        $mailable = new BookLoaned($loan);

        $mailable->assertSeeInHtml($book->title);
        $mailable->assertSeeInHtml($user->name);
        $mailable->assertSeeInHtml($loan->due_date->format('d F Y'));
    }

    public function test_email_notification_via_api()
    {
        Queue::fake();
        Mail::fake();

        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 5]);

        // Login to get token
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = $response->json('access_token');

        // Create loan via API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/loans', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'due_date' => now()->addDays(14)->format('Y-m-d')
        ]);

        $response->assertStatus(201);
        Queue::assertPushed(SendLoanNotification::class);
    }
}
