<?php

namespace app\modules\status\controllers;

use app\modules\status\models\Item;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $arrItems = $this->module->check;
        $items = [];
        foreach ($arrItems as $arrItem) {
            $item = new Item;
            $item->setAttributes($arrItem, false);
            $items[] = $item;
        }
        return $this->render('index', array('items' => $items));
    }

}
