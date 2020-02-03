<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 9/21/18
 * Time: 4:45 PM
 */

namespace app\modules\v1\controllers;

use app\modules\v1\helpers\SoapSignClient;
use app\modules\v1\helpers\BudgetHelper;
use Swagger\Annotations as SWG;
use yii\web\Controller;



class BudgetController extends Controller
{

    /**
     * @return json
     * @SWG\Get(
     *  summary="Get iban list by IDNO, CPV and YEAR",
     *  path="/budget/iban",
     *  tags={"Budget"},
     *  @SWG\Parameter(
     *     name="idno",
     *     in="query",
     *     description="Organization IDNO",
     *     required=true,
     *     type="number",
     *     @SWG\Schema(
     *     ref="#/definitions/PersonRequest"
     * )
     * ),
     * @SWG\Parameter(
     *     name="cpv",
     *     in="query",
     *     description="cpv code",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *     ref="#/definitions/PersonRequest"
     * )
     * ),
     *  @SWG\Parameter(
     *     name="year",
     *     in="query",
     *     description="Year",
     *     required=true,
     *     type="number",
     *     @SWG\Schema(
     *     ref="#/definitions/PersonRequest"
     * )
     * ),
     *
     * @SWG\Response(
     *     response="200",
     *     description="successful"
     * )
     *
     * )
     */
    public function actionIban($idno, $cpv= null, $year=null)
    {
        return  BudgetHelper::getIbanList($idno, $cpv, $year);
    }

    /**
     * @return json
     * @SWG\Get(
     *  summary="Get budget by IBAN, YEAR",
     *  path="/budget/get",
     *  tags={"Budget"},
     *  @SWG\Parameter(
     *     name="iban",
     *     in="query",
     *     description="Organization IBAN",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *     ref="#/definitions/BudgetRequest"
     * )
     * ),
     * @SWG\Parameter(
     *     name="year",
     *     in="query",
     *     description="Year",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *     ref="#/definitions/BudgetRequest"
     * )
     * ),
     *
     * @SWG\Response(
     *     response="200",
     *     description="successful"
     * )
     *
     * )
     */
    public function actionGet($iban, $year)
    {
        return  BudgetHelper::getBudget($iban, $year);
    }


    public function actionBlockSumBudget($iban, $year, $sum)
    {
        return  BudgetHelper::blockSumBudget($iban, $year, $sum);
    }


    /**
     * @return json
     * @SWG\Get(
     *  summary="Check sum budget by IBAN, YEAR",
     *  path="/budget/check",
     *  tags={"Budget"},
     *  @SWG\Parameter(
     *     name="iban",
     *     in="query",
     *     description="Organization IBAN",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *     ref="#/definitions/SumBudgetRequest"
     * )
     * ),
     * @SWG\Parameter(
     *     name="year",
     *     in="query",
     *     description="Year",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *     ref="#/definitions/SumBudgetRequest"
     * )
     * ),
     * @SWG\Parameter(
     *     name="sum",
     *     in="query",
     *     description="Blocking sum",
     *     required=true,
     *     type="number",
     *     @SWG\Schema(
     *     ref="#/definitions/SumBudgetRequest"
     * )
     * ),
     *
     * @SWG\Response(
     *     response="200",
     *     description="successful"
     * )
     *
     * )
     */
    public function actionCheck($iban, $year, $sum)
    {
        return  BudgetHelper::checkSumBudget($iban, $year, $sum);
    }


    public function actionUnblockSumBudget($iban, $year, $sum)
    {
        return  BudgetHelper::unblockSumBudget($iban, $year, $sum);
    }

}
