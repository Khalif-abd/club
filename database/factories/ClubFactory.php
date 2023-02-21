<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ClubFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => 'Club № ' . fake()->unique()->numberBetween(1, 100),
        ];
    }

}
