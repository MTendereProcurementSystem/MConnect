<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 9/21/18
 * Time: 4:45 PM
 */

namespace app\modules\v1\controllers;

use app\modules\v1\helpers\CitizenHelper;
use app\modules\v1\helpers\SoapSignClient;
use Swagger\Annotations as SWG;
use yii\web\Controller;



class CitizenController extends Controller
{

    /**
     * @return json
     * @SWG\Get(
     *  summary="Get Person by IDNP",
     *  path="/citizen/get",
     *  tags={"Citizen"},
     *  @SWG\Parameter(
     *     name="idnp",
     *     in="query",
     *     description="Person IDNP",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *     ref="#/definitions/PersonRequest"
     * )
     * ),
     * @SWG\Response(
     *     response="200",
     *     description="successful"
     * )
     *
     * )
     */
    public function actionGet($idnp)
    {
        return CitizenHelper::getPerson($idnp);
    }
}
