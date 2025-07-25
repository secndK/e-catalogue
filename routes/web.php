<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LangageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\EnvironnementController;

Route::get('/', function () {
    return redirect()->route('catalogue');
});

// Routes d'authentification avec des chemins spécifiques
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route d'accès guest
Route::get('/guest-access', [AuthController::class, 'guestAccess'])->name('guest.access');



Route::get('/catalogue', [CatalogueController::class, 'getCatalogue'])->name('catalogue');
Route::get('catalogue/all', [CatalogueController::class, 'getAllCatalogue'])->name('catalogue.all');
Route::post('catalogue', [CatalogueController::class, 'postCatalogue'])->name('catalogue');
Route::post('createCatalogue', [CatalogueController::class, 'createCatalogue'])->name('catalogue.create');
Route::get('/catalogue/{id}/edit', [CatalogueController::class, 'editCatalogue'])->name('catalogue.edit');
Route::post('/catalogue/{id}', [CatalogueController::class, 'updateCatalogue'])->name('catalogue.update.post');
Route::put('/catalogue/{id}', [CatalogueController::class, 'updateCatalogue'])->name('catalogue.update');
Route::delete('/catalogue/{id}/delete', [CatalogueController::class, 'deleteCatalogue'])->name('catalogue.delete');
Route::get('/recent-searches', [CatalogueController::class, 'getRecentSearches'])->name('get.recent.searches');
Route::post('/clear-search-history', [CatalogueController::class, 'clearSearchHistory'])->name('clear.search.history');
