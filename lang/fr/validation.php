<?php

/**
 * Messages de validation en français — règles utilisées par l'application.
 * `attributes` traduit les noms de champs des formulaires publics.
 */
return [
    'accepted'         => 'Vous devez accepter le champ :attribute.',
    'after'            => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal'   => 'Le champ :attribute doit être une date postérieure ou égale au :date.',
    'array'            => 'Le champ :attribute doit être un tableau.',
    'boolean'          => 'Le champ :attribute doit être vrai ou faux.',
    'date'             => 'Le champ :attribute n\'est pas une date valide.',
    'email'            => 'Le champ :attribute doit être une adresse email valide.',
    'exists'           => 'La sélection du champ :attribute est invalide.',
    'image'            => 'Le champ :attribute doit être une image.',
    'in'               => 'La sélection du champ :attribute est invalide.',
    'integer'          => 'Le champ :attribute doit être un entier.',
    'max' => [
        'numeric' => 'Le champ :attribute ne doit pas dépasser :max.',
        'file'    => 'Le fichier :attribute ne doit pas dépasser :max kilo-octets.',
        'string'  => 'Le champ :attribute ne doit pas dépasser :max caractères.',
        'array'   => 'Le champ :attribute ne doit pas contenir plus de :max éléments.',
    ],
    'min' => [
        'numeric' => 'Le champ :attribute doit être au moins :min.',
        'string'  => 'Le champ :attribute doit contenir au moins :min caractères.',
        'array'   => 'Le champ :attribute doit contenir au moins :min éléments.',
    ],
    'numeric'          => 'Le champ :attribute doit être un nombre.',
    'required'         => 'Le champ :attribute est obligatoire.',
    'string'           => 'Le champ :attribute doit être une chaîne de caractères.',

    'attributes' => [
        'guest_name'       => 'nom complet',
        'guest_email'      => 'email',
        'guest_phone'      => 'téléphone',
        'check_in'         => 'date d\'arrivée',
        'check_out'        => 'date de départ',
        'guests'           => 'nombre d\'hôtes',
        'special_requests' => 'demandes spéciales',
        'accept_cgv'       => 'conditions générales de vente',
        'room_id'          => 'chambre',
        'name'             => 'nom',
        'email'            => 'email',
        'subject'          => 'objet',
        'message'          => 'message',
        'ref'              => 'référence',
    ],
];
