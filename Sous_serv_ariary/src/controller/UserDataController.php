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
include_once 'utils/ServicesDB.php';
class BalanceRestController extends SimpleRestController {
    public function getBalance($account_id){
        $utils = new Util();
        $services = new ServicesDB();
        $data = null;
        $statusCode = 200;
        try{
            $connex = $services->initiateConnex();
            $data = $services->getAccountData($connex, $account_id);
            $services->closeConnex($connex);
        }catch (PDOException $e) {
            $statusCode = 404;
            $response = $responseJson;
        }
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);

        $response = $this->encodeJson($data);
        echo $response;
    }
}