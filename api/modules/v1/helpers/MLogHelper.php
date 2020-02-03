<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 11/2/18
 * Time: 3:41 PM
 */

namespace app\modules\v1\helpers;

use app\modules\v1\helpers\EndpointsHelper;
use thamtech\jws\components\JwsManager;
use yii\httpclient\Client;
use Yii;

class MLogHelper
{
    public static function createLog($data)
    {
        $data['event_level'] = 'info';
        $data['subject_type'] = 'Organization';
        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport'
        ]);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl(EndpointsHelper::MLOG_ENDPOINT.'/register')
            ->setData($data)
            ->setOptions([
                'sslLocalCert'=> dirname(__FILE__).'/../ssl/mtender/cert.pem',
                'sslLocalPk'=> dirname(__FILE__).'/../ssl/mtender/private.key',
                'sslCafile'=>dirname(__FILE__).'/../ssl/mtender/cacerts.cer',
                'sslVerifyPeer'=>false
            ])
            ->send();
        return $response;

    }

    public static function readLog($data)
    {
        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport'
        ]);
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setUrl(EndpointsHelper::MLOG_ENDPOINT.'/query')
            ->setData($data)
            ->setOptions([
                'sslLocalCert'=> dirname(__FILE__).'/../ssl/mtender/cert.pem',
                'sslLocalPk'=> dirname(__FILE__).'/../ssl/mtender/private.key',
                'sslCafile'=>dirname(__FILE__).'/../ssl/mtender/cacerts.cer',
                'sslVerifyPeer'=>false
            ])
            ->send();
        return $response;
    }

}
