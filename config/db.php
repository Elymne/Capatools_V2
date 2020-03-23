<?php

return [

    // env de dev.
    /*
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=capatools;port=3306',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    */

    // env de recette.
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=gp7vw.myd.infomaniak.com;dbname=gp7vw_capatools_yii_preprod',
    'username' => 'gp7vw_capatools',
    'password' => 'bw05KovxWVfJ',
    'charset' => 'utf8',

    // env de prod.

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',yii
];
