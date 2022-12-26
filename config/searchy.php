<?php
return [
    'default' => 'fuzzy',
    'fieldName' => 'relevance',
    'drivers' => [
        'fuzzy' => [
            'class' => 'Rabiloo\Searchy\SearchDrivers\FuzzySearchDriver',
        ],
        'ufuzzy' => [
            'class' => 'Rabiloo\Searchy\SearchDrivers\FuzzySearchUnicodeDriver',
        ],
        'simple' => [
            'class' => 'Rabiloo\Searchy\SearchDrivers\SimpleSearchDriver',
        ],
        'levenshtein' => [
            'class' => 'Rabiloo\Searchy\SearchDrivers\LevenshteinSearchDriver',
        ],
    ],
];
