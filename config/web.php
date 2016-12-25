<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'components' => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qweertre,xvx3254sawdcx66545',
            'parsers'             => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => require(__DIR__ . '/db.php'),
        'urlManager'   => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'rules'               => [
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'patterns'   => [
                        'GET fetch'             => 'index',
                        'GET <id>/fetch'        => 'view',
                        'POST create'           => 'create',
                        'PATCH,PUT <id>/modify' => 'update',
                    ],
                ],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'group',
                    'patterns'   => [
                        'GET fetch'             => 'index',
                        'GET <id>/fetch'        => 'view',
                        'POST create'           => 'create',
                        'PATCH,PUT <id>/modify' => 'update',
                    ],
                ],
            ],
        ],
    ],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];

    // enhanced gii
    $config['modules']['gridview'] = [
        'class' => '\kartik\grid\Module',
    ];
}

return $config;