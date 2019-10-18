<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class RecetteIngredients extends Model
{

    public function recettes()
    {
        return $this->hasMany(Recette::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class,'recette_id');
    }
}
