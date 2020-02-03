<?php

namespace app\modules\v1\helpers;

use Wse\WSSESoap;
use Wse\XMLSecurityKey;
use SoapClient;
use SoapHeader;
use DOMDocument;
use SimpleXMLElement;

const MCONNECT_URL = "https://testgu.justice.gov.md/svcmconnect/";

define('PRIVATE_KEY', dirname(__FILE__) . '/../ssl/mtender/private.key');
define('CERT_FILE', dirname(__FILE__) . '/../ssl/mtender/cert.pem');
define('SERVICE_CERT', dirname(__FILE__) . '/../ssl/mtender/server.cer');

/**
 * SoapSignClient class
 *
 * Sign x.509 soap request
 *
 */

const NAMESPACE_URL = 'https://mconnect.gov.md';
class SoapSignClient extends SoapClient
{


    public static function create($url = MCONNECT_URL)
    {
        $context = stream_context_create([
            'ssl' => [
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
            "https" => array(
                "curl_verify_ssl_peer" => false,
                "curl_verify_ssl_host" => false,
            )
        ]);

        ini_set("soap.wsdl_cache_enabled", "0");
        $client_soap = new SoapSignClient(
            $url . '?wsdl',
            array(
                'trace' => true,
                'soap_version' => SOAP_1_1,
                'stream_context' => $context
            )
        );
        $client_soap->soap_defencoding = 'UTF-8';
        $headers[] = new SoapHeader(
            NAMESPACE_URL,
            'CallReason',
            'Testarea mconnect'
        );
        $headers[] = new SoapHeader(
            NAMESPACE_URL,
            'CallingUser',
            'developer'
        );
        $headers[] = new SoapHeader(
            NAMESPACE_URL,
            'CallBasis',
            'Testarea mconnect'
        );
        $headers[] = new SoapHeader(
            NAMESPACE_URL,
            'CallingEntity',
            'esempla, Ministerul Finantelor'
        );
        $client_soap->__setSoapHeaders($headers);
        return $client_soap;
    }

    /**
     * getResponse function
     *
     * fix bug with parsing xml (in 3+ level deep)
     *
     * @return SimpleXMLElement
     */
    public function getResponse()
    {
        $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $this->__getLastResponse());
        $xmlObejct = new SimpleXMLElement($xml);
        return $xmlObejct->soapenvBody;
    }


    function __doRequest($request, $location, $saction, $version, $one_way = 0)
    {
        $doc = new DOMDocument('1.0');
        $doc->loadXML($request);

        $objWSSE = new WSSESoap($doc);
        
        /* add Timestamp with no expiration timestamp */
        $objWSSE->addTimestamp();
        
        /* create new XMLSec Key using AES256_CBC and type is private key */
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type' => 'private'));
        
        /* load the private key from file - last arg is bool if key in file (TRUE) or is string (FALSE) */
        $objKey->loadKey(PRIVATE_KEY, true);
        
        /* Sign the message - also signs appropiate WS-Security items */
        $options = array("insertBefore" => false);
        $objWSSE->signSoapDoc($objKey, $options);
        
        /* Add certificate (BinarySecurityToken) to the message */
        $token = $objWSSE->addBinaryToken(file_get_contents(CERT_FILE));
        
        /* Attach pointer to Signature */
        $objWSSE->attachTokentoSig($token);

        $objKey = new XMLSecurityKey(XMLSecurityKey::AES256_CBC);
        $objKey->generateSessionKey();

        $siteKey = new XMLSecurityKey(XMLSecurityKey::RSA_OAEP_MGF1P, array('type' => 'public'));
        $siteKey->loadKey(SERVICE_CERT, true, true);
        // echo($objWSSE->saveXML());

        $retVal = parent::__doRequest($objWSSE->saveXML(), $location, $saction, $version);

        $doc = new DOMDocument();
        $doc->loadXML($retVal);

        $options = array("keys" => array("private" => array(
            "key" => PRIVATE_KEY,
            "isFile" => true,
            "isCert" => false
        )));

        $objWSSE->decryptSoapDoc($doc, $options);
        // echo ('--------------------------------');
        // echo ($doc->saveXML());
        // die();
        return $doc->saveXML();
    }
}
