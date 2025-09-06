<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'published_year' => $this->faker->year,
            'isbn' => $this->faker->isbn13,
            'stock' => $this->faker->numberBetween(1, 10),
        ];
    }
}
