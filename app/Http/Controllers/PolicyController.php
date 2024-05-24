<?php

namespace App\Http\Controllers;


use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class PolicyController extends Controller
{   

    /**
     * privacy
     * 
     * Controller d'affichage de la politique de confidentialité
     * en français et une URL en français
     */
    public function privacy()
    {
        $policyFile = Jetstream::localizedMarkdownPath('policy.md');
        return view('policy',[
            'policy' => Str::markdown(file_get_contents($policyFile)),
        ]);
    }


    /**
     * terms
     * 
     * Controller d'affichage des de conditions d'utilisation
     * en français et une URL en français
     */
    public function terms()
    {
        $termsFile = Jetstream::localizedMarkdownPath('terms.md'); // On localise le chemin du fichier terms.md
        return view('terms',[
            'terms' => Str::markdown(file_get_contents($termsFile)), // 
        ]);
    }
}
