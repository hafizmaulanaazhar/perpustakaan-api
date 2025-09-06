<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Loan;

class BookLoaned extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Peminjaman Buku - ' . $this->loan->book->title)
            ->view('emails.book_loaned')
            ->with([
                'loan' => $this->loan,
                'user' => $this->loan->user,
                'book' => $this->loan->book
            ]);
    }
}
