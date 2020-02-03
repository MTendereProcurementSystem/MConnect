<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 10/12/18
 * Time: 3:09 PM
 */

namespace app\modules\v1\helpers;


use app\modules\v1\helpers\EndpointsHelper;

class OrganizationHelper
{
    public static function getContractingAuthority($idno)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->GetContractingAuthority(array('IDNO' => strval($idno)));
        $result = json_encode($client_soap->getResponse()->typContractingAuthority);
        \Yii::$app->getModule('audit')->data('data', base64_encode(gzdeflate($result)));
        return $result;
    }

    public static function getOrganization($idno)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->GetOrganization(array('IDNO' => strval($idno)));
        $result = json_encode($client_soap->getResponse()->typOrganization);
        \Yii::$app->getModule('audit')->data('data', base64_encode(gzdeflate($result)));
        return $result;
    }
}
