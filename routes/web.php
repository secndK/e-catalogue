<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;


Route::get('/', function () {
    return view('jaures');
});
