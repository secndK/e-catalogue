<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function getCatalogue()
    {
        return view('pages.Home.accueil');
    }
}
