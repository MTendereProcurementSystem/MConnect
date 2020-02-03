<?php
namespace app\modules\v1;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\v1\controllers';
    public $helperNamespace = 'app\modules\v1\helpers';
    public $defaultRoute = 'default';

    public function init()
    {
        parent::init();
        // initialize the module with the configuration loaded from config.php
        \Yii::configure($this, require __DIR__ . '/config.php');
    }

}
