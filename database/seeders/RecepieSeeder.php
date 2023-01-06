<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Recepie;
use App\Models\Ingredient;
class RecepieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Recepie::factory()->count(50)->create();
        Ingredient::factory()->count(30)->create();
        Recepie::All()->each(function($recepie)
        {
            $ingredients = Ingredient::inRandomOrder()->take(rand(3,10))->get();
            foreach($ingredients as $ingredient)
            {
                $recepie->ingredients()->save($ingredient);
            }
        });
        Recepie::All()->each(function($recepie)
        {
            $ingredients = $recepie->ingredients;
            foreach($ingredients as $ingredient)
            {
                $ingredient->pivot->amount = rand(20,300);
                $ingredient->pivot->save();
            }
        });
    }
}
