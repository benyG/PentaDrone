<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'         => 'Le champ :attribute doit être accepté.',
    'active_url'       => 'Le champ :attribute n\'est pas une URL valide.',
    'alpha'            => 'Le champ :attribute doit seulement contenir des lettres.',
    'after_or_equal'       => ':attribute doit être une date après ou égale à :date.',
    'alpha'                => 'Ce champ ne peut contenir que des lettres.',
    'alpha_dash'       => 'Le champ :attribute doit seulement contenir des lettres, des chiffres et des tirets.',
    'alpha_num'        => 'Le champ :attribute doit seulement contenir des chiffres et des lettres.',
    'array'                => ':attribute doit être un tableau.',
    'before'           => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal'      => ':attribute doit être une date avant ou égal à :date.',
    'between'              => [
        'numeric' => 'La valeur de :attribute doit être comprise entre :min et :max.',
        'file'    => 'Le fichier :attribute doit avoir une taille entre :min et :max kilobytes.',
        'string'  => 'Le texte :attribute doit avoir entre :min et :max caractères.',
        'array'   => ':attribute Doit être entre :min et :max éléments.',
    ],
    'boolean'              => 'le champ doit être vrai ou faux.',
    'confirmed'        => 'Le champ de confirmation :attribute ne correspond pas.',
    'date'             => 'Le champ :attribute n\'est pas une date valide.',
    'date_format'      => 'Le champ :attribute ne correspond pas au format :format.',
    'different'        => 'Les champs :attribute et :other doivent être différents.',
    'digits'           => 'Le champ :attribute doit avoir :digits chiffres.',
    'digits_between'   => 'Le champ :attribute doit avoir entre :min et :max chiffres.',
    'dimensions'           => 'Le champ :attribute contient une image aux dimensions invalide.',
    'distinct'             => 'Le champ :attribute est une valeur dupliquer.',
    'email'            => 'Le format du champ :attribute est invalide.',
    'exists'           => 'Le champ :attribute sélectionné est invalide.',
    'file'                 => 'Le champ :attribute doit être un fichier.',
    'filled'               => 'Le champ :attribute doit contenir une vqleur.',
    'image'            => 'Le champ :attribute doit être une image.',
    'in'               => 'Le champ :attribute est invalide.',
    'in_array'             => 'Le champ :attribute n\'existe pas dans :other.',
    'integer'          => 'Le champ :attribute doit être un entier.',
    'ip'               => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4'                 => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json'                 => 'Le champ :attribute doit être au format JSON valide.',
    'max'                  => [
        "numeric" => "La valeur de :attribute ne peut être supérieure à :max.",
        "file"    => "Le fichier :attribute ne peut être plus gros que :max kilobytes.",
        "string"  => "Le texte de :attribute ne peut contenir plus de :max caractères.",
        'array'   => 'Le tableau :attribute ne peut avoir plus de :max éléments.',
    ],
    'mimes'            => 'Le champ :attribute doit être un fichier de type : :values.',
    'mimetypes'            => 'Le champ :attribute doit contenir un fichier du type: et de vqleur :values.',
    'min'                  => [
        'numeric' => 'La valeur de :attribute doit être inférieure à :min.',
        'file'    => 'Le fichier :attribute doit être plus que gros que :min kilobytes.',
        'string'  => 'Le texte :attribute doit contenir au moins :min caractères.',
        'array'   => 'Le tableau :attribute ne peut avoir moins de :min éléments.',
    ],
    'not_in'           => 'Le champ :attribute sélectionné n\'est pas valide.',
    'not_regex'            => 'Le format du champ :attribute est invalide.',
    'numeric'          => 'Le champ :attribute doit contenir un nombre.',
    'present'              => 'Le champ :attribute doit être présent.',
    'regex'            => 'Le format du champ :attribute est invalide.',
    'required'         => 'Le champ :attribute est obligatoire.',
    'required_if'      => 'Le champ :attribute est obligatoire quand la valeur de :other est :value.',
    'required_unless'      => 'Le champ :attribute est obligatoire quand la valeur de :other est :values.',
    'required_with'    => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_without' => 'Le champ :attribute est obligatoire quand :values n\'est pas présent.',
    'required_with_all'    => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'             => 'Les champs :attribute et :other doivent être identiques.',
    'size'                 => [
        'numeric" => "La taille de la valeur de :attribute doit être :size.',
        'file'    => 'La taille du fichier de :attribute doit être de :size kilobytes.',
        'string'  => 'Le texte de :attribute doit contenir :size caractères.',
        'array'   => 'Le champ :attribute doit contenir :size éléments.',
    ],
    'string'               => 'Le champ :attribute doit être un string.',
    'timezone'             => 'Le champ :attribute doit être une zone valide.',
    'unique'               => 'La valeur du champ :attribute est déjà utilisée.',
    'uploaded'             => 'Le chargement du champ :attribute a échoué.',
    'url'                  => 'Le format de l\'URL de :attribute n\'est pas valide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];