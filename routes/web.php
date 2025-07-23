<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OsController;
use App\Http\Controllers\LangageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\EnvironnementController;


Route::get('/', [CatalogueController::class, 'getCatalogue'])->name('accueil');

/*************************************************************************************** LES ROUTES ******************************************************************************************** */

/**les routes pour applications */
Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
Route::put('/applications/{id}', [ApplicationController::class, 'update'])->name('applications.update');
Route::delete('/applications/{id}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
/**route pour les env */

// Récupérer tous les environnements

Route::get('/environnements', [EnvironnementController::class, 'getEnvironnement'])->name('environnements.get');
Route::post('/environnements', [EnvironnementController::class, 'createEnvironnement'])->name('environnements.create');
Route::put('/environnements/{id}', [EnvironnementController::class, 'updateEnvironnement'])->name('environnements.update');
Route::delete('/environnements/{id}', [EnvironnementController::class, 'deleteEnvironnement'])->name('environnements.delete');

/**routes pour langage */
Route::get('/langages', [LangageController::class, 'getLangage'])->name('langages.get');
Route::post('/langages', [LangageController::class, 'createLangage'])->name('langages.create');
Route::put('/langages/{id}', [LangageController::class, 'updateLangage'])->name('langages.update');
Route::delete('/langages/{id}', [LangageController::class, 'deleteLangage'])->name('langages.delete');
/** route pour os */
Route::get('/os', [OsController::class, 'getOs'])->name('os.get');
Route::post('/os', [OsController::class, 'createOs'])->name('os.create');
Route::put('/os/{id}', [OsController::class, 'updateOs'])->name('os.update');
Route::delete('/os/{id}', [OsController::class, 'deleteOs'])->name('os.delete');
/** routes pour les services */
Route::get('/services', [ServiceController::class, 'getService'])->name('services.get');
Route::post('/services', [ServiceController::class, 'createService'])->name('services.create');
Route::put('/services/{id}', [ServiceController::class, 'updateService'])->name('services.update');
Route::delete('/services/{id}', [ServiceController::class, 'deleteService'])->name('services.delete');





















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
Route::post('/clear-search-history', [CatalogueController::class, 'clearSearchHistory'])->name('clear.search.history');
