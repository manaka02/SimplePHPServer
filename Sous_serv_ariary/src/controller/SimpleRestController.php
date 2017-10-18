<?php

/**
 * Created by PhpStorm.
 * User: Miorantsoa
 * Date: 03/07/2017
 * Time: 21:21
 */
class SimpleRestController{
    private $httpVersion = "HTTP/1.1";

    function __construct($protected){
    	if($protected){
	    	$tokeninfo = $this->getTokenInfo();
	    	if(!$tokeninfo || (isset($tokeninfo->active) && !$tokeninfo->active)){
	    		$statusCode = 401;
	            $responseJson = array('error'=>'Unauthorized');
	            $requestContentType = $_SERVER['HTTP_ACCEPT'];
		        $this ->setHttpHeaders($requestContentType, $statusCode);
		        $response = $this->encodeJson($responseJson);
		        echo $response;
	    		exit();
	    	}	
    	}
    }

    public function setHttpHeaders($contentType, $statusCode){

        $statusMessage = $this -> getHttpStatusMessage($statusCode);
        header("Access-Control-Allow-Origin: *");
        header($this->httpVersion. " ". $statusCode ." ". $statusMessage);
        header("Content-Type:". $contentType);
    }

    public function getHttpStatusMessage($statusCode){
        $httpStatus = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'No sufficient funds or limits reached',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Invalid input',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }

    public function encodeJson($responseData) {
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;
    }


    public function getToken(){
         if (!function_exists('getallheaders')){ 
            function getallheaders() 
            { 
                   $headers = []; 
               foreach ($_SERVER as $name => $value) 
               { 
                   if (substr($name, 0, 5) == 'HTTP_') 
                   { 
                       $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
                   } 
               } 
               return $headers; 
            } 
        } 
        $allHeader = getallheaders();
        if(isset($allHeader['Authorization'])){
            $auth_header = $allHeader['Authorization'];
            $token = explode(' ', $auth_header);
            if($token[1]){
                return $token[1];
            } 
        }
        return false;
    }
    public function getTokenInfo(){
        $token = $this->getToken();
        if($token){
            $utils = new Util();
            $params = "";
            $header = "";
            $url = 'http://localhost/Oauth2_server/src/oauth/tokeninfo.php?access_token='.$token;
            $rep = $utils->sendCurl($url, 'get',array(),array() );    
            $responseJson = json_decode($rep); 
            return $responseJson;
        }
        else{
            return false;
        }
    }
}