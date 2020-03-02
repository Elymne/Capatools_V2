<?php
return [
    'indexDevis' => [
        'type' => 2,
    ],
    'createDevis' => [
        'type' => 2,
    ],
    'viewDevis' => [
        'type' => 2,
    ],
    'addCompanyDevis' => [
        'type' => 2,
    ],
    'updateDevis' => [
        'type' => 2,
    ],
    'deleteDevis' => [
        'type' => 2,
    ],
    'updateStatusDevis' => [
        'type' => 2,
    ],
    'validateStatusDevis' => [
        'type' => 2,
    ],
    'projectManagerDevis' => [
        'type' => 1,
        'children' => [
            'indexDevis',
            'createDevis',
            'viewDevis',
            'addCompanyDevis',
            'updateDevis',
        ],
    ],
    'operationalManagerDevis' => [
        'type' => 1,
        'children' => [
            'indexDevis',
            'createDevis',
            'viewDevis',
            'addCompanyDevis',
            'updateDevis',
            'deleteDevis',
            'validateStatusDevis',
        ],
    ],
    'accountingSupportDevis' => [
        'type' => 1,
        'children' => [
            'indexDevis',
            'createDevis',
            'viewDevis',
            'addCompanyDevis',
            'updateDevis',
            'deleteDevis',
            'updateStatusDevis',
        ],
    ],
];
