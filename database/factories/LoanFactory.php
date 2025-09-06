<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'loan_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'return_date' => $this->faker->optional(0.3)->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'return_date' => null,
        ]);
    }

    public function returned(): static
    {
        return $this->state(fn (array $attributes) => [
            'return_date' => $this->faker->dateTimeBetween($attributes['loan_date'], 'now'),
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'due_date' => $this->faker->dateTimeBetween('-1 month', '-1 day'),
            'return_date' => null,
        ]);
    }
}
