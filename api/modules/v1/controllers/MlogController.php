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
use app\modules\v1\helpers\MLogHelper;
use thamtech\jws\components\JwsManager;

class MlogController extends Controller
{

    /**
     * @return json
     * @SWG\Get(
     *  summary="Get logs",
     *  path="/mlog",
     *  tags={"MLog"},
     *  @SWG\Parameter(
     *     name="legal_entity",
     *     in="query",
     *     description="Legal entity that performs the search.",
     *     required=false,
     *     type="string",
     * ),
     *  @SWG\Parameter(
     *     name="legal_basis",
     *     in="query",
     *     description="Legal base for search",
     *     required=true,
     *     type="string",
     * ),
     *  @SWG\Parameter(
     *     name="legal_reason",
     *     in="query",
     *     description="Legal reason for search",
     *     required=false,
     *     type="string",
     * ),
     *  @SWG\Parameter(
     *     name="user",
     *     in="query",
     *     description="IDNP of the user that searches for events.",
     *     required=false,
     *     type="string",
     * ),
     *  @SWG\Parameter(
     *     name="event_time_from",
     *     in="query",
     *     description="Start time for period to search",
     *     required=true,
     *     type="string",
     * ),
     *  @SWG\Parameter(
     *     name="event_time_to",
     *     in="query",
     *     description="Start time for period to search",
     *     required=true,
     *     type="string",
     * ),
     *  @SWG\Parameter(
     *     name="filter",
     *     in="query",
     *     description="A list of key/value for the known fields
          to search. MLog will filter only those
          events that match these given fields.
          The format is field1=value1,field2=value2, etc",
     *     required=false,
     *     type="string",
     * ),
     *  @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     description="The page number to be returned in
          case there are more than 1 page on
          the results. By default this is
          considered to be 0 (first page).",
     *     required=false,
     *     type="string",
     * ),
     *  @SWG\Parameter(
     *     name="page_size",
     *     in="query",
     *     description="The chosen page size. Default: 50.",
     *     required=false,
     *     type="number",
     * ),
     * @SWG\Response(
     *     response="200",
     *     description="successful"
     * ),
     * @SWG\Response(
     *     response="400",
     *     description="bad request (wrong query)"
     * )
     *
     * )
     * @SWG\Post(
     *  summary="Register log",
     *  path="/mlog",
     *  tags={"MLog"},
     *  @SWG\Parameter(
     *     name="Log",
     *     in="body",
     *     description="Register Log",
     *     required=false,
     *     type="object",
     *     @SWG\Schema(
     *      ref="#/definitions/MLogRequest"
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
    public function actionIndex()
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $data = $_GET;
//            $validator = new \JsonSchema\Validator;
//            $validator->validate(
//                $data,
//                (object)['$ref' => 'file://' . dirname(__FILE__) .'/../schemas/MLogQueryRequest.json']
//            );

//            if (!$validator->isValid()) {
//                $message = "Request does not validate. Violations:\n";
//                foreach ($validator->getErrors() as $error) {
//                    $message = $message . sprintf("[%s] %s\n", $error['property'], $error['message']);
//                }
//                throw new \yii\web\HttpException(400, $message, 400);
//            }
            return MLogHelper::readLog($data);
        } elseif ($request->isPost) {

            $data = json_decode($request->getRawBody());
            $validator = new \JsonSchema\Validator;
            $validator->validate(
                $data,
                (object)['$ref' => 'file://' . dirname(__FILE__) .'/../schemas/MLogRequest.json']
            );

//            if (!$validator->isValid()) {
//                $message = "JSON does not validate. Violations:\n";
//                foreach ($validator->getErrors() as $error) {
//                    $message = $message . sprintf("[%s] %s\n", $error['property'], $error['message']);
//                }
//                throw new \yii\web\HttpException(400, $message, 400);
//            }
            return MLogHelper::createLog(json_decode($request->getRawBody(),true));
        }
    }

    public function actionTest()
    {
        $payload = [
            "user_id"=> 23,
            "foo"=> "bar",
        ];
        $tokenString = Yii::$app->getModule('v1')->jwsManager->newToken($payload);
        $token = $this->module->jwsManager->load($tokenString);
        echo('<pre>');
        die(var_dump($token));

        return $tokenString;
    }

}
