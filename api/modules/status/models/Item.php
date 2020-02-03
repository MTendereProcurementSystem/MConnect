<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 8/6/18
 * Time: 3:26 PM
 */

namespace app\modules\status\models;

use app\modules\status\helpers\HttpHelper;
use app\modules\status\helpers\TcpHelper;
use yii\base\Model;

class Item extends Model
{
    public $name;
    public $type;
    public $port;
    public $host;


    public function rules()
    {
        return [
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => 'Check type',
            'host' => 'Hostname or IP adress',
            'port' => 'Port',

        ];
    }

    public function getStatus()
    {
        switch ($this->type) {
            case 'tcp':
                return TcpHelper::check($this->host, $this->port);
            case 'http':
                return HttpHelper::check($this->host);
            default:
                 break;
        }
    }
}
