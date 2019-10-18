<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\Recette;
use App\RecetteIngredients;
use App\Unite;
use Illuminate\Http\Request;

class RecetteController extends Controller
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
        $recette_list = Recette::orderBy('nom', 'asc')->get();
        return view('recettes.recette_index',compact('recette_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ingredients = Ingredient::orderBy('nom', 'asc')->get();
        $unites = Unite::all();
        return view('recettes.recette_nouvelle',compact('ingredients','unites'));
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
            'nom'   => 'required|min:1|unique:recettes,nom',
            'qte'  => 'min:1|max:999999.99',
            'mode_preparation' => 'required',
            'temp' => 'required',
            'cout_heure' => 'required',
//            'ingredient_id' => 'unique:ingredients,id',
        ]);

        $temp = $request->temp;
        $request->merge([ 'temp' => $temp.':00' ]);

        $recette_up = Recette::create(request([
            'nom', 'mode_preparation','temp','qte_recette','cout_heure'])
        );

        $ingredient_id = $request->ingredient_id;
        $qte = $request->qte;

            for ($i=0; $i < count($qte); $i++)
            {
                $recette_up->ingredients()->attach($ingredient_id[$i], ['qte' => $qte[$i]]);
            }

        $cout_total = 0;

        foreach ($recette_up->ingredients as $prix){
            $valeur = $prix->valeur;

            if ($prix->unite_id == 3 ){
                $cout = $valeur * ($prix->pivot->qte);
            }
            else {
                $cout = ($valeur/1000) * ($prix->pivot->qte);
            }

            $cout_total += $cout;
            $cout_total = round($cout_total,2);
        }

        $temp = explode(':',$recette_up->temp);
        $temp = $temp[0] + ($temp[1] / 60 );

        $prix = (3 * $cout_total) + ($recette_up->cout_heure * $temp);

        $recette_up->update([
            'prix_final' => $prix
        ]);

        return back()->with('message', 'Recette ajoutée avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recette  $recette
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recettes = Recette::find($id);
        $unites = Unite::all();
        $ingredients = Ingredient::orderBy('nom', 'asc')->get();

        $cout_total = 0;

        foreach ($recettes->ingredients as $prix){
            $valeur = $prix->valeur;

            if ($prix->unite_id == 3 ){
                $cout = $valeur * ($prix->pivot->qte);
            }
            else {
                $cout = ($valeur/1000) * ($prix->pivot->qte);
            }

            $cout_total += $cout;
            $cout_total = round($cout_total,2);
        }
//
//        $temp = explode(':',$recettes->temp);
//        $temp = $temp[0] + ($temp[1] / 60 );
//
//        $prix = (3 * $cout_total) + ($recettes->cout_heure * $temp);

        return view('recettes.recette_show', compact('recettes','unites', 'ingredients', 'cout_total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recette  $recette
     * @return \Illuminate\Http\Response
     */
//    public function edit(Recette $recette)
//    {
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recette  $recette
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cout_total = 0;

        $this->validate($request, [
            'qte'  => 'min:1|max:999999.99',
            'mode_preparation' => 'required',
            'temp' => 'required',
            'cout_heure' => 'required',
        ]);

        $nom = $request->nom;
        $mode_preparation = $request->mode_preparation;
        $qte_recette = $request->qte_recette;
        $cout_heure = intval($request->cout_heure);
        $temp = $request->temp;
        $request->merge([ 'temp' => $temp.':00' ]);

        $recette_up = Recette::find($id);

        $recette_up->update([
            'nom' => $nom,
            'mode_preparation' => $mode_preparation,
            'temp' => $temp,
            'qte_recette' => $qte_recette,
            'cout_heure' => $cout_heure,
        ]);

        $ingredient_id = $request->ingredient_id;
        $qte = $request->qte;

        $recette_up->ingredients()->detach();

        for ($i=0; $i < count($ingredient_id); $i++)
        {
             $recette_up->ingredients()->attach($ingredient_id[$i], ['qte' => $qte[$i]]);
        }

        $ingredient_id2 = $request->ingredient_id2;
        $qte2 = $request->qte2;

        for ($i = 0; $i < count($qte2); $i++) {
            $recette_up->ingredients()->attach($ingredient_id2[$i], ['qte' => $qte2[$i]]);
        }

        foreach ($recette_up->ingredients as $prix){
            $valeur = $prix->valeur;

            if ($prix->unite_id == 3 ){
                $cout = $valeur * ($prix->pivot->qte);
            }
            else {
                $cout = ($valeur/1000) * ($prix->pivot->qte);
            }

            $cout_total += $cout;
            $cout_total = round($cout_total,2);
        }

        $temp = explode(':',$recette_up->temp);
        $temp = $temp[0] + ($temp[1] / 60 );

        $prix = (3 * $cout_total) + ($recette_up->cout_heure * $temp);

        $recette_up->update([
            'prix_final' => $prix
        ]);

        $recette_list = Recette::orderBy('nom', 'asc')->get();
        return back()->with('message', 'Recette modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recette  $recette
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recette $recette)
    {
        $recette->delete();
        $recette->ingredients()->detach();

        $recette_list = Recette::orderBy('nom', 'asc')->get();

        return view('recettes.recette_index',compact('recette_list'))
            ->with('message', 'Recette retiré de la list');
    }
}
