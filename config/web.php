<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    ///La route par défaut est le dashboard
    'defaultRoute' => 'dashboard/index',

    // Liste composants (c'est juste des alias qui font référence à des classes, fonctions ect ect)
    'components' => [

        // describe here.
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '2Q1MQf8IHT0av7p3aPE_b4mUtwP4yxGh',
        ],
        // Set cache folder.
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // Set user model class for users management.
        'user' => [
            'identityClass' => 'app\models\users\CapaUser',
            'loginUrl' => 'index',
            'enableAutoLogin' => true,
        ],
        // Role management.
        'authManager' => [
            'class' => 'yii\rbac\PhpManager'
        ],
        // Error handler.
        'errorHandler' => [
            'errorAction' => 'dashboard/error',
        ],
        // Php mailer.
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        // Logger file.
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        // Database connection.
        'db' => $db,
        // ... unknow (write the use here)
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        // ... unknow (write the use here)
        'discoverService' => [
            'class' => 'app\components\DiscoverService',
        ],

        'formatter' => [
            'numberFormatterSymbols' => [\NumberFormatter::CURRENCY_SYMBOL => '€'],
        ],

    ],
    'name' => 'CAPATOOLS V2.0',

    // définit la langue cible comme étant le français-France
    'language' => 'fr-FR',

    // définit la langue source comme étant l'anglais États-Unis
    'sourceLanguage' => 'en-US',

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
