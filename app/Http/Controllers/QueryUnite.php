<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\Recette;
use App\RecetteIngredients;
use App\Unite;
use Illuminate\Http\Request;

class QueryUnite extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($ingred_id)
    {
        $query = Ingredient::find($ingred_id);
        return 'helo';
        return $query->nom;
    }
}