<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepie extends Model
{
    use HasFactory;
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('amount')->withTimestamps();
    }
    public function energy()
    {
        $sum = 0;
        foreach($this->ingredients as $ingredient)
        {
            $sum+=($ingredient->energy*($ingredient->pivot->amount/100));
        }
        return $sum; 
    }
    public function protein()
    {
        $sum = 0;
        foreach($this->ingredients as $ingredient)
        {
            $sum+=$ingredient->protein*($ingredient->pivot->amount/100);
        }
        return $sum; 
    }
    public function carbs()
    {
        $sum = 0;
        foreach($this->ingredients as $ingredient)
        {
            $sum+=$ingredient->carbs*($ingredient->pivot->amount/100);
        }
        return $sum; 
    }
    public function fat()
    {
        $sum = 0;
        foreach($this->ingredients as $ingredient)
        {
            $sum+=$ingredient->fat*($ingredient->pivot->amount/100);
        }
        return $sum; 
    }
    public function sugar()
    {
        $sum = 0;
        foreach($this->ingredients as $ingredient)
        {
            $sum+=$ingredient->sugar*($ingredient->pivot->amount/100);
        }
        return $sum; 
    }
}
