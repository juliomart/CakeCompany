<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    public function recettes()
    {
        return $this->belongsToMany(Recette::class,'commandes_recettes','commande_id','recette_id')->withPivot('qte_commande');
    }
}
