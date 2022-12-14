<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Recepie;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => "\"" . $this->faker->text($maxNbChars = 80) .  "\"",
            'energy' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1200),
            'protein' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 120),
            'carbs'=> $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            'fat'=> $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            'sugar'=> $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
        ];
    }
    
}

