<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 9/27/18
 * Time: 5:13 PM
 */

namespace app\modules\v1\helpers;

use app\modules\v1\helpers\EndpointsHelper;

class BudgetHelper
{


    public static function getBudget($iban, $year)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->getBudget(array('iban' => strval($iban), 'year' => strval($year)));
        return json_encode($client_soap->getResponse()->getBudget_response);
    }

    public static function blockSumBudget($iban, $year, $sum)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->blockSumBudget(array('iban' => strval($iban), 'year' => strval($year), 'sum' => strval($sum)));
        return json_encode($client_soap->getResponse()->blockSumBudget_response);
    }

    public static function checkSumBudget($iban, $year, $sum)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->checkSumBudget(array('iban' => strval($iban), 'year' => strval($year), 'sum' => strval($sum)));
        return json_encode($client_soap->getResponse()->checkSumBudget_response);
    }

    public static function unblockSumBudget($iban, $year, $sum)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->unblockSumBudget(array('iban' => strval($iban), 'year' => strval($year), 'sum' => strval($sum)));
        return json_encode($client_soap->getResponse()->unblockSumBudget_response);
    }

    public static function getIbanList($idno, $cpv = null, $year = null)
    {
        $client_soap = SoapSignClient::create(EndpointsHelper::REGISTRU_ENDPOINT);
        $client_soap->getIbanList(array('idno' => strval($idno), 'cpv' => strval($cpv), 'year' => strval($year)));
        return json_encode($client_soap->getResponse());
    }
}
