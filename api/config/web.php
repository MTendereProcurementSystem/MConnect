<?php



$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'name' => 'MConnect',
    'vendorPath' => dirname(dirname(__DIR__))."/vendor",
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules'   => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class'    => 'app\modules\v1\Module',
        ],
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            'ignoreActions' => ['*/docs/*'],
        ],

//        'health' => [
//            'class'  => 'hardtyz\health\Module',
//            'check' => [
//                "API" => [
//                    "type" => "tcp",
//                    "host" => "localhost",
//                    "port" => 8989,
//                    "name" => "API"
//                ],
//                "c_mtender" => [
//                    "type" => "http",
//                    "host" => "http://api-esb.test.interop.gov.md:8280/services/t/mf.gov.md/c_mtender",
//                    "name" => "c_mtender"
//                ],
//                "c_trezoraria" => [
//                    "type" => "http",
//                    "host" => "https://testgu.justice.gov.md/svcmconnect/",
//                    "name" => "c_trezoraria"
//                ],
//                "c_trezoraria_mtender" => [
//                    "type" => "http",
//                    "host" => "https://api-esb.test.interop.gov.md:8243/services/t/mf.gov.md/c_trezoraria_mtender",
//                    "name" => "c_trezoraria_mtender"
//                ],
//            ],
//        ],
    ],
    'components' => [
        'errorHandler' => [
            // web error handler
            'class' => 'bedezign\yii2\audit\components\web\ErrorHandler',
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
        ],
        'response' => [
            //'format' => \yii\web\Response::FORMAT_JSON,
        ],
//        'cache' => [
//            'class' => 'yii\caching\FileCache',
//        ],
//        'errorHandler' => [
//            'errorAction' => 'site/error',
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'http'=>[
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/http-request.log',
                    'categories' => ['yii\httpclient\*'],
                ],
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'syslog' => [
                    'class' => 'yii\log\SyslogTarget',
                    'levels' => ['error', 'warning'],
                ],
//                'db' => [
//                    'class' => 'yii\log\DbTarget',
//
//                    'levels' => ['error', 'warning']
//                ],
//               'mconnect' =>   [
//                   'class' => 'hardtyz\\log\\LogstashTarget',
//                   'dsn' => 'udp://192.168.16.141:30237',
//                   'levels' => ['error', 'warning','info'],
//                   'index' => 'mconnect'
//               ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/v1/docs' => '/v1/docs/index',
                '/v1/docs/<action:\S+>' => '/v1/docs/<action>',
                '/v1/<controller:\S+>/<action:\S+>' => "/v1/<controller>/<action>",
                '/v1/<controller:\S+?>' => '/v1/<controller>',
                '/v1/<action:\S+?>' => '/v1/default/<action>',


            ],
        ],
              'user' => [
                  'identityClass' => 'app\models\User',
                  'enableAutoLogin' => false,
              ],

    ],
    'params' => $params,
];

if (YII_DEBUG) {
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
