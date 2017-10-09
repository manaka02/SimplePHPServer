<?php

/**
 * Created by PhpStorm.
 * User: Miorantsoa
 * Date: 03/07/2017
 * Time: 21:53
 */
header("Access-Control-Allow-Origin: *");
include_once 'utils/Util.php';
include_once 'controller/SimpleRestController.php';
class BalanceRestController extends SimpleRestController {
    public function getBalance($account_id){
        $utils = new Util();
        $params = "";
        $header = "";
        $rep = $utils->sendCurl('http://54.229.79.45/ariary2API/web/api/balance/'.$account_id, 'get',array(),array() );    
        $responseJson = json_decode($rep); 
        if(isset($reponseJson->error)) {
            $statusCode = 404;
            $response = $responseJson;
        } else {
            $statusCode = 200;
        }
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);

        $response = $this->encodeJson($responseJson);
        echo $response;
    }
}