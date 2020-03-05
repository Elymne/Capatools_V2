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
    'projectManagerDevis' => [
        'type' => 1,
        'children' => [
            'indexDevis',
            'createDevis',
            'viewDevis',
            'addCompanyDevis',
            'updateDevis',
            'updateStatusDevis',
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
            'updateStatusDevis',
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
    'indexAdmin' => [
        'type' => 2,
    ],
    'createAdmin' => [
        'type' => 2,
    ],
    'viewAdmin' => [
        'type' => 2,
    ],
    'updateAdmin' => [
        'type' => 2,
    ],
    'deleteAdmin' => [
        'type' => 2,
    ],
    'administrator' => [
        'type' => 1,
        'children' => [
            'indexAdmin',
            'createAdmin',
            'viewAdmin',
            'updateAdmin',
            'deleteAdmin',
        ],
    ],
];
