<?php
return [
    'components' => [
        // list of component configurations
        'jwsManager' => [
            'class' => 'thamtech\jws\components\JwsManager',
            'pubkey' => dirname(__FILE__).'/ssl/mtender/cert.pem',
            'pvtkey' =>  dirname(__FILE__).'/ssl/mtender/private.key',

            // The settings below are optional. Defaults will be used if not set here.
            //'encoder' => 'Namshi\JOSE\Base64\Base64UrlSafeEncoder',
            //'exp' => '1 hour',
            //'alg' => 'RS256',
            //'jwsClass' => 'Namshi\JOSE\SimpleJWS',
        ],
    ],
    'params' => [
        // list of parameters
    ],
];
