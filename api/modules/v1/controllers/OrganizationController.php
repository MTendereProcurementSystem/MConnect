<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 9/21/18
 * Time: 5:53 PM
 */

namespace app\modules\v1\controllers;

use app\modules\v1\helpers\OrganizationHelper;
use app\modules\v1\helpers\SoapSignClient;
use Swagger\Annotations as SWG;
use yii\web\Controller;


class OrganizationController extends Controller
{


    /**
     * @return json
     * @SWG\Get(
     *
     *  tags={"Organization"},
     *  summary="Get Contracting Authority by IDNO",
     *  path="/organization/public",
     *  @SWG\Parameter(
     *     name="idno",
     *     in="query",
     *     description="Organization IDNO",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *     ref="#/definitions/ContractingAuthorityRequest"
     * )
     * ),
     * @SWG\Response(
     *     response="200",
     *     description="successful"
     * )
     *
     * )
     */
    public function actionPublic($idno)
    {
       return OrganizationHelper::getContractingAuthority($idno);
    }

    /**
     * @return json
     * @SWG\Get(
     *  tags={"Organization"},
     *  summary="Get Organization by IDNO",
     *  path="/organization/private",
     *  @SWG\Parameter(
     *     name="idno",
     *     in="query",
     *     description="Organization IDNO",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *     ref="#/definitions/OrganizationRequest"
     * )
     * ),
     * @SWG\Response(
     *     response="200",
     *     description="successful"
     * )
     *
     * )
     */
    public function actionPrivate($idno)
    {
        return OrganizationHelper::getOrganization($idno);

    }


}
