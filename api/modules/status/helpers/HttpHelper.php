<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 8/6/18
 * Time: 4:30 PM
 */
namespace app\modules\status\helpers;

class HttpHelper
{
    public static function check(string $host)
    {
        //check, if a valid url is provided
        if (!filter_var($host, FILTER_VALIDATE_URL)) {
            return false;
        }

        //initialize curl
        $curlInit = curl_init($host);
        curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curlInit, CURLOPT_HEADER, true);
        curl_setopt($curlInit, CURLOPT_NOBODY, true);
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlInit, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlInit, CURLOPT_SSL_VERIFYHOST, false);

        //get answer
        $response = curl_exec($curlInit);
        curl_close($curlInit);

        if ($response) {
            return true;
        }

        return false;
    }
}
