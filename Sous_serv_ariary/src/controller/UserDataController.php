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
    
    public function getUserData($pseudo, $expo_token){
        $tokeninfo = $this->getTokenInfo();
        if(isset($tokeninfo->active) && $tokeninfo->active){
            $utils = new Util();
            $services = new ServicesDB();
            $data = null;
            $statusCode = 200;
            try{
                $connex = $services->initiateConnex();
                $data = $services->getUserData($connex, $pseudo, $expo_token);
                $response = $data;
                if(empty($data)){
                    $statusCode = 404;
                    $response = array("error"=>"Not found");
                }
                $services->closeConnex($connex);
            }catch (PDOException $e) {
                $statusCode = 404;
                var_dump($e);
                $response = array("error"=>"Erreur de connexion");
                $services->closeConnex($connex);
            }
        }
        else{
            $statusCode = 401;
            $response = array('error'=>'Unauthorized');
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
        }
        // finally{
        //     return array(
        //         'statusCode'=>$statusCode,
        //         'response'=>$response
        //     );
        // }
    }
    public function saveAccount($user_account, $expo_token, $device_name, $password){
        $localResponse = $this->saveLocalAccount($user_account, $device_name, $expo_token);

        $response = $localResponse['response'];
        $statusCode = $localResponse['statusCode'];
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);

        
        echo $this->encodeJson($response);
    }

    public function getAllDevices($pseudo){
        $tokeninfo = $this->getTokenInfo();
        if(isset($tokeninfo->active) && $tokeninfo->active){
            $utils = new Util();
            $services = new ServicesDB();
            $data = null;
            $statusCode = 200;
            echo 'tonga ato v';
            try{
                $connex = $services->initiateConnex();
                $data = $services->getAllDevices($connex, $pseudo);
                $response = $data;
                $services->closeConnex($connex);
            }catch (PDOException $e) {
                $statusCode = 404;
                $response = $responseJson;
            }
        }
        else{
            $statusCode = 401;
            $response = array('error'=>'Unauthorized');
        }
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);

        $response = $this->encodeJson($response);
        echo  $response;
    }
}