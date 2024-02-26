<?php

return [

    'Chauffeur' => [
        'name' => "Gestion des Chauffeurs",
        'route' => 'chauffeur.valide',
        'routes' => ['chauffeur.valide', 'chauffeur.nonvalide'],
        'icon' => 'icon ni ni-users',
        'role'   => 'Controlleur',
        'childrens' => [
            [
                'name'  => 'Liste des chauffeurs à valider',
                'role'  => 'Controlleur',
                'route' => 'chauffeur.nonvalide',
                'altRoute' => '',
            ],
            [
                'name'  => 'Liste des chauffeurs valider',
                'role'  => 'Controlleur',
                'route' => 'chauffeur.valide',
                'altRoute' => '',
            ],
        ],
    ],
];