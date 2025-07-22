<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogueController;

Route::get('/', function () {
    return view('pages.Home.accueil');
});

/*************************************************************************************** LES ROUTES ******************************************************************************************** */


Route::get('catalogue', [CatalogueController::class, 'getCatalogue'])->name('catalogue');
Route::get('catalogue/all', [CatalogueController::class, 'getAllCatalogue'])->name('catalogue.all');
Route::post('catalogue', [CatalogueController::class, 'postCatalogue'])->name('catalogue');
Route::post('createCatalogue', [CatalogueController::class, 'createCatalogue'])->name('catalogue.create');
// Route pour afficher le formulaire de modification avec les données existantes (GET)
// Route GET pour récupérer les données (fonctionne)
Route::get('/catalogue/{id}/edit', [CatalogueController::class, 'editCatalogue'])->name('catalogue.edit');

// AJOUTEZ AUSSI UNE ROUTE POST pour la mise à jour (en plus de PUT)
Route::post('/catalogue/{id}', [CatalogueController::class, 'updateCatalogue'])->name('catalogue.update.post');
Route::put('/catalogue/{id}', [CatalogueController::class, 'updateCatalogue'])->name('catalogue.update');

Route::delete('/catalogue/{id}/delete', [CatalogueController::class, 'deleteCatalogue'])->name('catalogue.delete');

Route::get('/recent-searches', [CatalogueController::class, 'getRecentSearches'])->name('get.recent.searches');
