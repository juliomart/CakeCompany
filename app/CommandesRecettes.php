<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class CommandesRecettes extends Model
{
    public function recettes()
    {
        return $this->hasMany(Recette::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
