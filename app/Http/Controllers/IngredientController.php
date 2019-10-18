<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\Recette;
use App\RecetteIngredients;
use App\Unite;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;

class IngredientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredient_list = Ingredient::orderBy('nom', 'asc')->get();
        return view('ingredients.ingredient_index',compact('ingredient_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unites = Unite::all();
        return view('ingredients.ingredient_nouveau',compact('unites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nom'   => 'required|min:1|unique:ingredients,nom',
            'qte_stock'  => 'required|numeric|min:1|max:999999.99',
            'unite_id' => 'required',
        ]);

        Ingredient::create(request([
                'nom', 'qte_stock', 'unite_id', 'valeur'])
        );

        $ingredient_list = Ingredient::orderBy('nom', 'asc')->get();
        return back()
            ->with('message', 'Ingrédient ajouté avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingredient = Ingredient::find($id);
        $unite = Unite::find($ingredient->unite_id);

        return view('ingredients.ingredient_show',compact('ingredient','unite'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function edit($id)
//    {
//
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'qte_stock'  => 'required|numeric|min:1|max:999999.99',
        ]);

        $ingredient = Ingredient::find($id);
        $ingredient->update($request->all());

        $ingredient_list = Ingredient::orderBy('nom', 'asc')->get();
        return back()
            ->with('message', 'Stock modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ingredient = RecetteIngredients::where('ingredient_id',$id)->first();
        if (!empty($ingredient->ingredient_id)){

            return back()
                ->with('message', 'Ingrédient utilisé dans une recette!  Vous devez modifier la recette pour faire cela.');
        }

        Ingredient::destroy($id);
        $ingredient_list = Ingredient::orderBy('nom', 'asc')->get();
        return view('ingredients.ingredient_index',compact('ingredient_list'))
            ->with('message', 'Ingrédient retiré de la liste');

    }
}
