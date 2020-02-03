<?php
namespace app\modules\status;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\status\controllers';
    public $helperNamespace = 'app\modules\status\helpers';
    public $modelsNamespace = 'app\modules\status\models';
    public $defaultRoute = 'default';
    public $check = [];
}
