<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebaseController extends Controller
{


    function getChauffeurNonValider(Request $request)
    {
        return view('pages.chauffeur_nonvalide');
    }

    function getChauffeurValider()
    {
        return view('pages.chauffeur_valide');
    }
}