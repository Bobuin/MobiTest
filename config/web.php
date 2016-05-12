<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id'           => 'basic',
    'basePath'     => dirname(__DIR__),
    'bootstrap'    => ['log'],
    'defaultRoute' => 'repo/view',
    'components'   => [
        'request'              => [
            'cookieValidationKey' => 'JKgvHJcf87tfuCVHJ7iygGKJvh',
        ],
        'cache'                => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'                 => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler'         => [
            'errorAction' => 'site/error',
        ],
        'mailer'               => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log'                  => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'                   => require(__DIR__ . '/db.php'),
        'urlManager'           => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => false,
            'rules'               => [
            ],
        ],
        'authClientCollection' => [
            'class'   => 'yii\authclient\Collection',
            'clients' => [
                'github' => [
                    'class'        => 'yii\authclient\clients\GitHub',
                    'clientId'     => '063e485fa4d2779a94d2',
                    'clientSecret' => '761a079af5b8cca6cb0c8d81a5d2ad2fcac644d5',
                ],
            ],
        ],
    ],
    'params'       => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        'allowedIPs' => ['1.2.3.4', '127.0.0.1', '::1'],
    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
