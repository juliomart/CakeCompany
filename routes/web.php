<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Ingredients

Route::get('/ingredient/', 'IngredientController@index');

Route::get('/ingredient/create', 'IngredientController@create');

Route::post('/ingredient/', 'IngredientController@store');

Route::get('/ingredient/{id}/show', 'IngredientController@show');

Route::post('/ingredient/{id}/up', 'IngredientController@update');

Route::get('/ingredient/{ingredient}/delete', 'IngredientController@destroy');


//Recettes

Route::get('/recette/', 'RecetteController@index');

Route::get('/recette/create', 'RecetteController@create');

Route::post('/recette/', 'RecetteController@store');

Route::get('/recette/{recette}/show', 'RecetteController@show');

Route::post('/recette/{id}/up', 'RecetteController@update');

Route::get('/recette/{recette}/delete', 'RecetteController@destroy');


//Commandes

Route::get('/commande/', 'CommandeController@index');

Route::get('/commande/create', 'CommandeController@create');

Route::post('/commande/', 'CommandeController@store');

Route::get('/commande/{commande}/show', 'CommandeController@show');

Route::post('/commande/{id}/up', 'CommandeController@update');

Route::get('/commande/{commande}/delete', 'CommandeController@destroy');