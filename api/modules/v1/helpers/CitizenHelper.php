<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 10/12/18
 * Time: 3:11 PM
 */

namespace app\modules\v1\helpers;

use app\modules\v1\helpers\EndpointsHelper;

class CitizenHelper
{
    public static function getPerson($idnp)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->GetPerson(array('IDNP' => strval($idnp)));
        $result =  json_encode($client_soap->getResponse()->typPerson);
        \Yii::$app->getModule('audit')->data('data', base64_encode(gzdeflate($result)));
        return $result;
    }
}
