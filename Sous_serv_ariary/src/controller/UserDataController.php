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
class UserDataController extends SimpleRestController {
    function __construct(){
        parent::__construct(false);
    }
    public function getUserData($account_id){
        $tokeninfo = $this->getTokenInfo();
        if(isset($tokeninfo->active) && $tokeninfo->active){
            $utils = new Util();
            $services = new ServicesDB();
            $data = null;
            $statusCode = 200;
            try{
                $connex = $services->initiateConnex();
                $data = $services->getAccountData($connex, $account_id);
                $response = $data;
                if(empty($data)){
                    $statusCode = 404;
                    $response = array("error"=>"Not found");
                }
            }catch (PDOException $e) {
                $statusCode = 404;
                $response = array("error"=>"Erreur de connexion");
            }finally{
                $services->closeConnex($connex);
            }
        }
        else{
            $statusCode = 401;
            $response = array('error'=>'Unauthorized','error_description'=>"The token is no longer valide or have been invalidated");
        }
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);

        $response = $this->encodeJson($response);
        echo  $response;
    }

    public function saveLocalAccount($user_account, $device_name, $expo_token){
        $utils = new Util();
        $services = new ServicesDB();
        $data = null;
        $statusCode = 200;
        try{
            $connex = $services->initiateConnex();
            if(!empty($user_account) && !empty($expo_token) && !empty($device_name)){
                $new_account = $services->addNewAccount($connex,$user_account, $device_name, $expo_token);
                if($new_account !=0){
                    $statusCode = 200;
                    $response = array(
                        "id"=>$new_account,
                        "pseudo"=>$user_account,
                        "device_name"=>$device_name,
                        "expo_token"=>$expo_token
                    );
                }
                else{
                    $statusCode = 405;
                    $response = array("Erreur"=>"Aucune donnée n' a été enregistrer");
                }
            }
            else{
                $statusCode = 405;
                $message = $this->getHttpStatusMessage[$statusCode];
                $response = array("Error"=>$message);
            }
        }catch(PDOException $e){
            $statusCode = 405;
            $response = array("Error"=>$e);
        }finally{
            return array(
                'statusCode'=>$statusCode,
                'response'=>$response
            );
        }
    }
    public function saveAccount($user_account, $expo_token, $device_name, $password){
        $localResponse = $this->saveLocalAccount($user_account, $device_name, $expo_token);

        $response = $localResponse['response'];
        $statusCode = $localResponse['statusCode'];
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);

        
        echo $this->encodeJson($response);
    }

}