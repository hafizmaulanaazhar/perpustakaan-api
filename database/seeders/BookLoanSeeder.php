<?php

namespace Database\Seeders;

use App\Models\Loan;
use Illuminate\Database\Seeder;

class BookLoanSeeder extends Seeder
{
    public function run(): void
    {
        Loan::factory(10)->current()->create();
        Loan::factory(10)->returned()->create();
        Loan::factory(5)->overdue()->create();
    }
}
