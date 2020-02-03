<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host='.getenv("AP_DB_URL").';dbname='.getenv("AP_DB_NAME"),
            'username' => getenv("AP_DB_USER"),
            'password' => getenv("AP_DB_PASS"),
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
