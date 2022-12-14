<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recepie>
 */
class RecepieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text($maxNbChars = 80),
            'description' => $this->faker->text($maxNbChars = 500),
            'instructions' => $this->faker->text($maxNbChars = 1000),
        ];
    }
}
