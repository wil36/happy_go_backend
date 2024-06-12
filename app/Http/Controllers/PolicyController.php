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

    /**
     * security
     * 
     * Cette fonctionnalité permet aux utilisateurs de supprimer leurs données personnelles
     * grâce à l'envoie d'un mail ou on doit renseigner nom, téléphone et numéro de CNI
     */
    public function security()
    {
        return view('profile.delete-user-account');
    }
}
