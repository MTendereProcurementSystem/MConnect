<?php

namespace app\modules\v1\controllers;

use app\modules\v1\helpers\SoapSignClient;
use Swagger\Annotations as SWG;
use yii\web\Controller;

/**
* Class DefaultController
 * @package app\modules\v1\controllers
 *
 * @SWG\Swagger(
 *     basePath="/api/v1",
 *         produces={"application/json;charset=UTF-8"},
 *         consumes={"application/json"},
 *     @SWG\Definition(
 *             definition="ContractConfirmRequest",
 *             required={"id_dok"},
 *          @SWG\Property(
 *              property="id_dok",
 *              type="string",
 *              description="Contract Status"
 *          ),
 *          @SWG\Property(
 *              property="desc",
 *              type="string",
 *              description="Description"
 *          )
 *     ),
 *     @SWG\Definition(
 *             definition="ContractConfirmResponse",
 *          @SWG\Property(
 *              property="id_dok",
 *              type="integer",
 *              format="int32",
 *              description="Contract id"
 *          ),
 *          @SWG\Property(
 *              property="num_row",
 *              type="integer",
 *              format="int32",
 *              description="Contract id row"
 *          )
 *     ),
 *     @SWG\Definition(
 *             definition="StatusRequest",
 *             required={"status"},
 *          @SWG\Property(
 *              property="status",
 *              type="integer",
 *              format="int32",
 *              description="Contract Status"
 *          )
 *     ),
 *     @SWG\Definition(
 *             definition="StatusResponse",
 *              @SWG\Property(
 *              property="Contract",
 *              type="object",
 *              description="Returned list of contracts",
 *              @SWG\Property(
 *                 property="id_doc",
 *                 type="string",
 *                 description="contract ID", 
 *               ),
 *               @SWG\Property(
 *                 property="id_hist",
 *                 type="string",
 *                 description="History id" 
 *               ),
 *               @SWG\Property(
 *                 property="status",
 *                 type="number",
 *                 description="Status of the contract" 
 *               ),
 *               @SWG\Property(
 *                 property="st_date",
 *                 type="string",
 *                 format="date",
 *                 description="Date of the changing status" 
 *               ),
 *               @SWG\Property(
 *                 property="reg_nom",
 *                 type="number",
 *                 description="Register number" 
 *               ),
 *               @SWG\Property(
 *                 property="reg_date",
 *                 type="string",
 *                 description="Date of the register" 
 *               ),
 *               @SWG\Property(
 *                 property="descr",
 *                 type="string",
 *                 description="Description of the contract" 
 *               )
 *          ),
 *     ),
 *     @SWG\Definition(
 *          definition="ContractRequest",
 *          required={"header","benef","details"},
 *          @SWG\Property(
 *              property="header",
 *              type="object",
 *              description="Contract Header",
 *              @SWG\Property(
 *                  property="id_dok",
 *                  type="string",
 *                  description="Id-ul Contractului",
 *              ),
 *              @SWG\Property(
 *                  property="nr_dok",
 *                  type="string",
 *                  description="Numarul Contractului",
 *              ),
 *              @SWG\Property(
 *                  property="da_dok",
 *                  type="string",
 *                  format="date",
 *                  description="Data Contractului",
 *              ),
 *              @SWG\Property(
 *                  property="suma",
 *                  type="number",
 *                  format="double",
 *                  description="Suma Contractului",
 *              ),
 *              @SWG\Property(
 *                  property="kd_val",
 *                  type="string",
 *                  description="Codul valutei",
 *              ),
 *              @SWG\Property(
 *                  property="pkd_fisk",
 *                  type="string",
 *                  description="Codul fiscal al contractantului",
 *              ),
 *              @SWG\Property(
 *                  property="pkd_sdiv",
 *                  type="string",
 *                  description="Numărul subdiviziunii contractantului",
 *              ),
 *              @SWG\Property(
 *                  property="pname",
 *                  type="string",
 *                  description="Denumirea contractantului",
 *              ),
 *              @SWG\Property(
 *                  property="bkd_fisk",
 *                  type="string",
 *                  description="Beneficiarul contractului",
 *              ),
 *              @SWG\Property(
 *                  property="bkd_sdiv",
 *                  type="string",
 *                  description="Subdiviziunea beneficiarului",
 *              ),
 *              @SWG\Property(
 *                  property="bname",
 *                  type="string",
 *                  description="Denumirea beneficiarului",
 *              ),
 *              @SWG\Property(
 *                  property="desc",
 *                  type="string",
 *                  description="Descrierea contractului",
 *              ),
 *              @SWG\Property(
 *                  property="reg_nom",
 *                  type="string",
 *                  description="Numărul de înregistrare la trezorărie",
 *              ),
 *              @SWG\Property(
 *                  property="reg_date",
 *                  type="string",
 *                  description="Data înregistării la trezorărie",
 *              ),
 *              @SWG\Property(
 *                  property="achiz_nom",
 *                  type="string",
 *                  description="Numărul contractului la Agenția achiziții publice",
 *              ),
 *              @SWG\Property(
 *                  property="achiz_date",
 *                  type="string",
 *                  format="date",
 *                  description="Data înregistrării contractului la Agenția achiziții publice",
 *              ),
 *              @SWG\Property(
 *                  property="avans",
 *                  type="number",
 *                  format="double",
 *                  description="Avans",
 *              ),
 *              @SWG\Property(
 *                  property="da_expire",
 *                  type="string",
 *                  format="date",
 *                  description="Data expirării contractului",
 *              ),
 *              @SWG\Property(
 *                  property="c_link",
 *                  type="string",
 *                  description="Link-ul spre contract în format .pdf",
 *              ),
 *          ),
 *      @SWG\Property(
 *     property="benef",
 *     type="array",
 *     description="Beneficiar's Contract",
 *          @SWG\Items(
 *              @SWG\Property(
 *                  property="id_dok",
 *                  type="string",
 *                  description="Id-ul Contractului",
 *              ),
 *              @SWG\Property(
 *                  property="bbic",
 *                  type="string",
 *                  description="Codul BIC",
 *              ),
 *              @SWG\Property(
 *                  property="biban",
 *                  type="integer",
 *                  format="int32",
 *                  description="Codul IBAN",
 *              ),
 *          ),
 *     ),
 *          @SWG\Property(
 *              property="details",
 *              type="array",
 *              description="Contract Details",
 *     @SWG\Items(
 *              @SWG\Property(
 *                  property="id_dok",
 *                  type="string",
 *                  description="Id-ul Contractului",
 *              ),
 *              @SWG\Property(
 *                  property="suma",
 *                  type="number",
 *                  format="double",
 *                  description="Suma",
 *              ),
 *              @SWG\Property(
 *                  property="piban",
 *                  type="string",
 *                  description="Codul IBAN",
 *              ),  
 *              @SWG\Property(
 *                  property="byear",
 *                  type="integer",
 *                  format="int32",
 *                  description="An bugetat",
 *              ),
 * ),
 *          )
 *     ),     
 *     @SWG\Definition(
 *             definition="ContractingAuthorityRequest",
 *             required={"idno"},
 *          @SWG\Property(property="idno", type="string", description="IDNO")
 *     ),
 *      @SWG\Definition(
 *             definition="OrganizationRequest",
 *             required={"idno"},
 *          @SWG\Property(property="idno", type="string", description="IDNO")
 *     ),
 *      @SWG\Definition(
 *             definition="PersonRequest",
 *             required={"idnp"},
 *          @SWG\Property(property="idnp", type="string", description="IDNP")
 *     ),
 *      @SWG\Definition(
 *             definition="IbanListRequest",
 *             required={"idno", "cpv", "year"},
 *          @SWG\Property(property="idno", type="number", description="Organization IDNO"),
 *          @SWG\Property(property="cpv", type="string", description="Cpv code"),
 *          @SWG\Property(property="year", type="number", description="Year")
 *     ),
 *      @SWG\Definition(
 *             definition="BudgetRequest",
 *             required={"iban", "year"},
 *          @SWG\Property(property="iban", type="string", description="Organization IBAN"),
 *          @SWG\Property(property="year", type="number", description="Year")
 *     ),
 *      @SWG\Definition(
 *             definition="SumBudgetRequest",
 *             required={"iban", "year", "sum"},
 *          @SWG\Property(property="iban", type="string", description="Organization IBAN"),
 *          @SWG\Property(property="year", type="number", description="Year"),
 *          @SWG\Property(property="sum", type="number", description="Sum")
 *     ),
 *     @SWG\Definition(
 *             definition="NaturalPersonResponse",
 *             required={"idnp"},
 *          @SWG\Property(
 *              property="Identification",
 *              type="object",
 *              description="Identification",
 *                  @SWG\Property(
 *                      property="IDNP",
 *                      type="string",
 *                      description="IDNP",
 *                  ),
 *                  @SWG\Property(
 *                      property="FirstName",
 *                      type="string",
 *                      description="FirstName",
 *                  ),
 *                  @SWG\Property(
 *                      property="LastName",
 *                      type="string",
 *                      description="LastName",
 *                  ),
 *                  @SWG\Property(
 *                      property="SecondName",
 *                      type="string",
 *                      description="SecondName",
 *                  ),
 *                  @SWG\Property(
 *                      property="BirthDate",
 *                      type="string",
 *                      description="BirthDate",
 *                  ),
 *                  @SWG\Property(
 *                      property="CitizenCode",
 *                      type="string",
 *                      description="CitizenCode",
 *                  ),
 *
 *          ),
 *          @SWG\Property(
 *              property="Document",
 *              type="object",
 *              description="Document",
 *                  @SWG\Property(
 *                      property="DocTypeCode",
 *                      type="string",
 *                      description="DocTypeCode",
 *                  ),
 *                  @SWG\Property(
 *                      property="Series",
 *                      type="string",
 *                      description="Series",
 *                  ),
 *                  @SWG\Property(
 *                      property="Number",
 *                      type="string",
 *                      description="Number",
 *                  ),
 *                  @SWG\Property(
 *                      property="IssueDate",
 *                      type="string",
 *                      description="IssueDate",
 *                  ),
 *                  @SWG\Property(
 *                      property="ExpirationDate",
 *                      type="string",
 *                      description="ExpirationDate",
 *                  ),
 *                  @SWG\Property(
 *                      property="StatusCode",
 *                      type="string",
 *                      description="StatusCode",
 *                  ),
 *
 *          ),
 *          @SWG\Property(
 *              property="Address",
 *              type="object",
 *              description="Address",
 *                  @SWG\Property(
 *                      property="Region",
 *                      type="string",
 *                      description="Region",
 *                  ),
 *                  @SWG\Property(
 *                      property="Locality",
 *                      type="string",
 *                      description="Locality",
 *                  ),
 *                  @SWG\Property(
 *                      property="AdministrativeCode",
 *                      type="object",
 *                      description="AdministrativeCode",
 *                  ),
 *                  @SWG\Property(
 *                      property="Street",
 *                      type="string",
 *                      description="Street",
 *                  ),
 *                  @SWG\Property(
 *                      property="House",
 *                      type="string",
 *                      description="House",
 *                  ),
 *                  @SWG\Property(
 *                      property="Block",
 *                      type="string",
 *                      description="Block",
 *                  ),
 *                  @SWG\Property(
 *                      property="Flat",
 *                      type="string",
 *                      description="Flat",
 *                  ),
 *                  @SWG\Property(
 *                      property="Email",
 *                      type="object",
 *                      description="Email",
 *                  ),
 *                  @SWG\Property(
 *                      property="Phone",
 *                      type="object",
 *                      description="Phone",
 *                  ),
 *          ),
 *     ),
 *     @SWG\Definition(
 *             definition="MLogRequest",
 *             required={"event_time","event_type","event_source","event_message","legal_entity","user_session","user_address","amount","documents"},
 *             @SWG\Property(
 *                      property="event_time",
 *                      type="string",
 *                      description="Date",
 *                      example="2016-11-28T23:12:37.334+02:00"
 *             ),
 *             @SWG\Property(
 *                      property="event_type",
 *                      type="string",
 *                      description="Type event",
 *                      example="ex: MTender.Bid.Open|MTender.Offer.Submitted|etc",
 *             ),
 *             @SWG\Property(
 *                      property="event_source",
 *                      type="string",
 *                      description="MTender component that logged the event",
 *             ),
 *             @SWG\Property(
 *                      property="event_message",
 *                      type="string",
 *                      description="Describe the performed action",
 *             ),
 *             @SWG\Property(
 *                      property="legal_entity",
 *                      type="string",
 *                      description="IDNO of the company/authority that performed the action",
 *             ),
 *             @SWG\Property(
 *                      property="user_session",
 *                      type="string",
 *                      description="String",
 *             ),
 *             @SWG\Property(
 *                      property="user_address",
 *                      type="string",
 *                      description="user IP address (not system IP address, as this is already known by MLog)",
 *             ),
 *             @SWG\Property(
 *                      property="amount",
 *                      type="string",
 *                      description="Suma",
 *             ),
 *             @SWG\Property(
 *                      property="documents",
 *                      type="array",
 *                      description="Documents information",
 *                      items= @SWG\Items(
 *                         type="string",
 *                         example="url1|id1|hash1"
 *                      ),
 *             ),
 *     ),
 *
 *)
 */

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


    // Services Mtender




    // Services Trezorerie




}

