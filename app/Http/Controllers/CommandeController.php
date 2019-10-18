<?php

namespace App\Http\Controllers;

use App\Commande;
use App\CommandesRecettes;
use App\Recette;
use App\Ingredient;
use App\RecetteIngredients;
use Illuminate\Http\Request;

class CommandeController extends Controller
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
        $commande_list = Commande::orderBy('livraison', 'asc')->get();
        return view('commandes.commande_index',compact('commande_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $recettes_list = Recette::orderBy('nom', 'asc')->get();
        return view('commandes.commande_nouvelle',compact('recettes_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $z = 0;

        // validation des infos
        $this->validate($request,[
            'nom'   => 'required|min:1|unique:commandes,nom',
            'qte_commande'   => 'min:1',
        ]);

        // transformation format date (DD/MM/YYYY) en (YYYY/MM/DD)
        $livraison = explode('/',$request->livraison);
        $livraison = $livraison[2]."-".$livraison[1]."-".$livraison[0];
        $request->merge([ 'livraison' => $livraison ]);

        // enregistre valeurs dans table "commandes"
        $commande = Commande::create(request([
            'nom','livraison','comments'
        ]));

        $recette_id = $request->recette_id;
        $qte_commande = $request->qte_commande;

        // enregistre valeurs dans table "commandes_recettes"
        for ($i=0; $i < count($qte_commande); $i++)
        {
            $commande->recettes()->attach($recette_id[$i], ['qte_commande' => $qte_commande[$i]]);
        }

        // mise a jour table "ingredients"
        foreach ($recette_id as $recettes_ids) {

            $ingredient = RecetteIngredients::where('recette_id', $recettes_ids)->get();

            for ($j = 0; $j < count($ingredient); $j++) {
                $ingredient_id[] = $ingredient[$j]->ingredient_id;
                $qte_recette[] = $ingredient[$j]->qte;
            }

            foreach ($ingredient_id as $id) {
                $quantite_stock[] = Ingredient::where('id', $id)->select('qte_stock')->get();
            }

            for ($k = 0; $k < count($ingredient_id); $k++) {
                $qte_stock[] = $quantite_stock[$k][0]->qte_stock;
                $new_stock[] = $qte_stock[$k] - ($qte_recette[$k] * $qte_commande[$z]);
            }

            for ($m = 0; $m < count($ingredient_id); $m++) {
                Ingredient::where('id', $ingredient_id[$m])->update([
                    'qte_stock' => $new_stock[$m]
                ]);
            }

            $z++;
            unset(
                $id,
                $ingredient,
                $ingredient_id,
                $qte_recette,
                $qte_stock,
                $quantite_stock,
                $new_stock
            );
        }

        return back()->with('message', 'Commande ajoutée avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commandes = Commande::find($id);
        $recettes = Recette::orderBy('nom', 'asc')->get();

        $cout_total = 0;
        $valeur_commande = 0;

        foreach ($commandes->recettes as $result) {
            $cout_total = $result->prix_final * $result->pivot->qte_commande;
            $valeur_commande += $cout_total;
        }

        $livraison = explode('-',$commandes->livraison);
        $livraison = $livraison[2]."/".$livraison[1]."/".$livraison[0];

        return view('commandes.commande_show', compact('commandes','recettes', 'valeur_commande','livraison'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
//    public function edit(Commande $commande)
//    {
//
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $z = 0;
        $x = 0;
        $this->validate($request, [
            'qte2'  => 'min:1|max:999999',
        ]);

        $nom = $request->nom;
        $comments = $request->comments;
        $livraison = $request->livraison;

        $livraison = explode('/',$request->livraison);
        $livraison = $livraison[2]."-".$livraison[1]."-".$livraison[0];
        $request->merge([ 'livraison' => $livraison ]);

        $commande_up = Commande::find($id);

        $commande_up->update ([
            'nom' => $nom,
            'livraison' => $livraison,
            'comments' => $comments,
        ]);

        $recette_id = $request->recette_id;
        $recette_id2 = $request->recette_id2;
        $qte_commande = $request->qte;

        // verifie si le produit est déjà dans la commande
        if (!empty($recette_id2) && !empty($recette_id)){
        foreach ($recette_id2 as $id){
            if(in_array($id,$recette_id))
            {
                return back()->with('message', 'Vous essayez d\'ajouter le même produit deux fois');
            }
        }}

        $commande_up->recettes()->detach();

        for ($i=0; $i < count($recette_id); $i++)
        {
            $commande_up->recettes()->attach($recette_id[$i], ['qte_commande' => $qte_commande[$i]]);
        }

        // mise a jour table "ingredients"
        foreach ($recette_id as $recettes_ids) {

            $ingredient = RecetteIngredients::where('recette_id', $recettes_ids)->get();

            for ($j = 0; $j < count($ingredient); $j++) {
                $ingredient_id[] = $ingredient[$j]->ingredient_id;
                $qte_recette[] = $ingredient[$j]->qte;
            }

            foreach ($ingredient_id as $id) {
                $quantite_stock[] = Ingredient::where('id', $id)->select('qte_stock')->get();
            }

            for ($k = 0; $k < count($ingredient_id); $k++) {
                $qte_stock[] = $quantite_stock[$k][0]->qte_stock;
                $new_stock[] = $qte_stock[$k] - ($qte_recette[$k] * $qte_commande[$x]);
            }

            for ($m = 0; $m < count($ingredient_id); $m++) {
                Ingredient::where('id', $ingredient_id[$m])->update([
                    'qte_stock' => $new_stock[$m]
                ]);
            }

            $x++;
//            unset(
//                $id,
//                $ingredient,
//                $ingredient_id,
//                $qte_recette,
//                $qte_stock,
//                $quantite_stock,
//                $new_stock
//            );
        }

//        $recette_id2 = $request->recette_id2;
        $qte_commande = $request->qte2;

            for ($i = 0; $i < count($qte_commande); $i++) {
                $commande_up->recettes()->attach($recette_id2[$i], ['qte_commande' => $qte_commande[$i]]);
            }

            foreach ($recette_id2 as $recettes_ids) {

                $ingredient = RecetteIngredients::where('recette_id', $recettes_ids)->get();

                for ($j = 0; $j < count($ingredient); $j++) {
                    $ingredient_id[] = $ingredient[$j]->ingredient_id;
                    $qte_recette[] = $ingredient[$j]->qte;
                }

                if(!empty($ingredient_id)) {

                    foreach ($ingredient_id as $id) {
                    $quantite_stock[] = Ingredient::where('id', $id)->select('qte_stock')->get();
                    }

                    for ($k = 0; $k < count($ingredient_id); $k++) {
                        $qte_stock[] = $quantite_stock[$k][0]->qte_stock;
                        $new_stock[] = $qte_stock[$k] - ($qte_recette[$k] * $qte_commande[$z]);
                    }

                    for ($m = 0; $m < count($ingredient_id); $m++) {
                        Ingredient::where('id', $ingredient_id[$m])->update([
                            'qte_stock' => $new_stock[$m]
                        ]);
                    }
                }

                $z++;
                unset(
                    $id,
                    $ingredient,
                    $ingredient_id,
                    $qte_recette,
                    $qte_stock,
                    $quantite_stock,
                    $new_stock
                );
            }

        $commande_list = Commande::orderBy('id', 'asc')->get();

        foreach ($commande_list as $date) {
            $livraison = explode('-', $date->livraison);
            $livraison = $livraison[2] . "/" . $livraison[1] . "/" . $livraison[0];
        }

        return back()->with('message', 'Commande modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //TODO
        //soft deleting

        $z = 0;
        $recettes = CommandesRecettes::where('commande_id',$commande->id)->get();

        for($i=0;$i < count($recettes); $i++){
            $recettes_ids[] = $recettes[$i]->recette_id;
            $qte_commande[] = $recettes[$i]->qte_commande;
        }

        foreach ($recettes_ids as $recette_id) {

            $ingredient = RecetteIngredients::where('recette_id', $recette_id)->get();

            for ($j = 0; $j < count($ingredient); $j++) {
                $ingredient_id[] = $ingredient[$j]->ingredient_id;
                $qte_recette[] = $ingredient[$j]->qte;
            }

            foreach ($ingredient_id as $id) {
                $quantite_stock[] = Ingredient::where('id', $id)->select('qte_stock')->get();
            }

            for ($k = 0; $k < count($ingredient_id); $k++) {
                $qte_stock[] = $quantite_stock[$k][0]->qte_stock;
                $new_stock[] = $qte_stock[$k] + ($qte_recette[$k] * $qte_commande[$z]);
            }

            for ($m = 0; $m < count($ingredient_id); $m++) {
                Ingredient::where('id', $ingredient_id[$m])->update([
                    'qte_stock' => $new_stock[$m]
                ]);
            }

            $z++;
            unset(
                $id,
                $ingredient,
                $ingredient_id,
                $qte_recette,
                $qte_stock,
                $quantite_stock,
                $new_stock
            );
        }

        $commande->delete();
        $commande->recettes()->detach();

        $commande_list = Commande::orderBy('livraison', 'asc')->get();

        foreach ($commande_list as $date) {
            $livraison = explode('-', $date->livraison);
            $livraison = $livraison[2] . "/" . $livraison[1] . "/" . $livraison[0];
        }

        return view('commandes.commande_index',compact('commande_list', 'livraison'));
    }
}