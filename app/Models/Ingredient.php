<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    public $fillable = ['name','energy','protein','carbs','fat','sugar'];
    public function recepies()
    {
        return $this->belongsToMany(Recepie::class);
    }
}
