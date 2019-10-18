<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class,'recette_ingredients','recette_id','ingredient_id')->withPivot('qte');
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class,'commandes_recettes','recette_id','commande_id')->withPivot('qte_commande');
    }

}
