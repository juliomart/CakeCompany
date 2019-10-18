<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\Recette;
use App\RecetteIngredients;
use App\Unite;
use Illuminate\Http\Request;

class js_sql extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function query($ingred_id)
    {
        if(isset($_POST['ingred_id']) === true && empty($_POST['ingred_id']) === false){
            $query = Ingredient::where('id', $ingred_id)->get();
            $unite = Unite::where('id',$query->unite_id)->get();
            $result = $unite->type;
            return $result;
        }
    }
}