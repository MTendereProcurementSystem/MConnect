<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 10/3/18
 * Time: 11:05 AM
 */

namespace app\modules\v1\controllers;

use app\modules\v1\helpers\SoapSignClient;
use Swagger\Annotations as SWG;
use yii\web\Controller;
use app\modules\v1\helpers\ContractsHelper;
use Yii;
use JsonSchema\Validator;

class ContractController extends Controller
{



    /**
     * @return json
     * @SWG\Post(
     *  summary="Register new contract",
     *  path="/contract/register",
     *  tags={"Contract"},
     *  @SWG\Parameter(
     *     name="Contract",
     *     in="body",
     *     description="Register Contract",
     *     required=false,
     *     type="object",
     *     @SWG\Schema(
     *      ref="#/definitions/ContractRequest"
     *     )
     * ),
     * @SWG\Response(
     *     response="200",
     *     description="successful"
     * ),
     * @SWG\Response(
     *     response="400",
     *     description="bad request (wrong post body)"
     * )
     *
     * )
     */

    public function actionRegister()
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            throw new \yii\web\HttpException(400,'Only POST allowed',400);
        }
        $data = json_decode($request->getRawBody());
        $validator = new \JsonSchema\Validator;
        $validator->validate($data, (object)['$ref' => 'file://' . dirname(__FILE__) .'/../schemas/ContractRegister.json']);

        if (!$validator->isValid()) {
            $message = "JSON does not validate. Violations:\n";
            foreach ($validator->getErrors() as $error) {
                $message = $message . sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
           //throw new \yii\web\HttpException(400,$message, 400);
        }
        return ContractsHelper::postRegister(json_decode($request->getRawBody(),true));
    }


    /**
     * @return json
     * @SWG\Get(
     *  summary="Check if Trezorery registered sent contract",
     *  path="/contract/queue",
     *  tags={"Contract"},
     *  @SWG\Parameter(
     *     name="status",
     *     in="query",
     *     description="Contract status",
     *     required=true,
     *     type="integer",
     *     format="int32",
     *     @SWG\Schema(
     *     ref="#/definitions/StatusRequest"
     * )
     * ),
     * @SWG\Response(
     *     response="200",
     *     description="successful",
     *     @SWG\Schema(
     *       ref="#/definitions/StatusResponse"
     *     )
     * )
     *
     * )
     */
    public function actionQueue($status)
    {
        return ContractsHelper::getQueue($status);
    }

    /**
     * @return json
     * @SWG\Post(
     *  summary="Set confirm status by contract id",
     *  path="/contract/confirm",
     *  tags={"Contract"},
     *  @SWG\Parameter(
     *     name="id_dok",
     *     in="query",
     *     description="Contract id",
     *     required=true,
     *     type="string",
     *  @SWG\Schema(
     *     ref="#/definitions/ContractConfirmRequest"
     * )
     * ),
     * @SWG\Parameter(
     *     name="desc",
     *     in="query",
     *     description="Description",
     *     required=false,
     *     type="string",
     * @SWG\Schema(
     *     ref="#/definitions/ContractConfirmRequest"
     * )
     * ),
     * @SWG\Response(
     *     response="200",
     *     description="successful",
     *     @SWG\Schema(
     *       ref="#/definitions/ContractConfirmResponse"
     *     )
     * )
     *
     * )
     */
    public static function actionConfirm($id_dok, $desc = '')
    {
        return ContractsHelper::getConfirmReceipt($id_dok, $desc);
    }

}