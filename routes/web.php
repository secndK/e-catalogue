<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\CatalogueController;

Route::get('/', function () {
    return view('jaures');
});



/*************************************************************************************** LES ROUTES ******************************************************************************************** */


// on va afficher l'application qu'on recherche dans la bar a partir de cette route
Route::get('catalogue', [CatalogueController::class, 'getCatalogue'])->name('catalogue');
