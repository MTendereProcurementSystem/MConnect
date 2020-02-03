<?php

/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 10/3/18
 * Time: 11:05 AM
 */

namespace app\modules\v1\helpers;

use app\modules\v1\helpers\EndpointsHelper;
use SimpleXMLElement;

class ContractsHelper
{
    public static function postRegister($data)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        try {
            $result = $client_soap->put_contract(array(
                "add_contract_header" => $data['header'],
                "add_contract_benef" => $data['benef'],
                "add_contract_details" => $data['details']
            ));

            $xmlObejct = new SimpleXMLElement($result->any);
            $result = json_encode($xmlObejct);
        } catch (\Throwable $th) {
            $re = '/(?=DS Fault Message:).+$/m';
            preg_match($re, $th->getMessage(), $matches, 0);

            throw new \yii\web\HttpException(400, $matches[0], 400);
        }


        \Yii::$app->getModule('audit')->data('data', base64_encode(gzdeflate($result)));
        return $result;
    }

    public static function getQueue($status)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->get_contract_queue(array(
            "status" => $status
        ));

        $result = json_encode($client_soap->getResponse()->contract_queue_rezult);
        \Yii::$app->getModule('audit')->data('data', base64_encode(gzdeflate($result)));
        return $result;
    }

    public static function getConfirmReceipt($id_dok, $desc = '')
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->ConfirmContractStatusReceipt(array(
            "id_dok" => $id_dok,
            "description" => $desc
        ));
        $result = json_encode($client_soap->getResponse()->ConfirmContractStatusReceipt_response);
        \Yii::$app->getModule('audit')->data('data', base64_encode(gzdeflate($result)));

        return $result;
    }
}
