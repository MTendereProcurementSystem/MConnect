<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 8/6/18
 * Time: 2:56 PM
 */

namespace app\modules\status\helpers;

class TcpHelper
{

    public static function check(string $host, int $port)
    {
        $hostip = @gethostbyname($host);
        if (!$x = @fsockopen($hostip, $port, $errno, $errstr, 5)) { // attempt to connect

            return false;
        } else {
            if ($x) {
                @fclose($x); //close connection
            }
            return true;
        }
    }

}
