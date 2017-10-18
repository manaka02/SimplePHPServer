<?php
header("Access-Control-Allow-Origin: *");
include_once 'utils/Util.php';
include_once 'controller/SimpleRestController.php';
class TransactionRestController extends SimpleRestController{
    function __construct(){
        parent::__construct(true);
    }
    public function getTransaction($account_id, $filter = null, $skip = 0, $take = 10)
    {
       $utils = new Util();
       $header = array();
       $params = array();
       $request = $utils->sendCurl('http://54.229.79.45/ariary2API/web/api/transaction/'.$account_id, 'get',$header,$params );
       $responseJson = json_decode($request); 
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

    public function addTransaction($sender_id, $recipient_id, $amount, $currency, $comment){
        $resultRemote = $this->addRemoteTransaction($sender_id, $recipient_id, $amount, $currency, $comment);
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $resultRemote['statusCode']);
        echo json_encode($resultRemote['response']);
    }
    public function addRemoteTransaction($sender_id, $recipient_id, $amount, $currency, $comment){
        $utils = new Util();
        $uri = "http://54.229.79.45/ariary2API/web/api/transaction";
        $header = array();
        $params = array(
            "amount"=>$amount,
            "senderId"=>$sender_id, 
            "recipientId"=>$recipient_id,
            "comment"=>$comment,
            "currency"=>$currency
        );
        $rep = $utils->sendCurl($uri, "post", $header, $params);
        $responseJson = json_decode($rep);
        $response = $responseJson;
        if(isset($responseJson->error)) {
            $statusCode = 404;
            $response = $responseJson;
        } else {
            $statusCode = 200;
        }
 
        return array(
            "statusCode"=>  $statusCode,
            "response"  =>  $response
        );
    }

}