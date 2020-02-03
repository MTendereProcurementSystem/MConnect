<?php

/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 7/10/18
 * Time: 12:19 PM
 */

namespace app\modules\v1\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @OA\Swagger(
 *     basePath="/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     openapi="3.0.0",
 *     @SWG\Info(version="1.1", title="CDU-MTender API"),
 * )
 */
class DocsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions() : array
    {
        return [
            'index' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => Url::to(['json-schema']),
            ],
            'json-schema' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                // Тhe list of directories that contains the swagger annotations.
                'scanDir' => [
                    Yii::getAlias('@app/modules/v1/controllers'),
                   // Yii::getAlias('@app\modules\v1\controllers'),
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}
