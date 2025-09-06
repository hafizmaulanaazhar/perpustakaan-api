<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Loan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookLoaned;

class SendLoanNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function handle()
    {
        try {
            // Log untuk testing
            Log::info('Mengirim email notifikasi untuk peminjaman buku', [
                'loan_id' => $this->loan->id,
                'user_id' => $this->loan->user_id,
                'book_id' => $this->loan->book_id,
                'user_email' => $this->loan->user->email
            ]);

            // Kirim email
            Mail::to($this->loan->user->email)->send(new BookLoaned($this->loan));

            Log::info('Email notifikasi berhasil dikirim ke: ' . $this->loan->user->email);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email notifikasi: ' . $e->getMessage());
        }
    }
}
