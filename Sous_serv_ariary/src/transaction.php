<?php
header("Access-Control-Allow-Origin: *");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: Authorization, authorization, Content-Type");
}
require_once("controller/TransactionRestController.php");

if(isset($_GET['account-id']) && empty($_POST)){
    $account_id = "";
    if(isset($_GET["account-id"]))
        $account_id = $_GET["account-id"];

    $tx_handler = new TransactionRestController();
    $tx_handler->getTransaction($account_id);
}
if(!empty($_POST)){
    $senderId = ($_POST['senderId']) ? $_POST['senderId'] : ""; 
    $recipientId = ($_POST['recipientId']) ? $_POST['recipientId'] : "";
    $amount = ($_POST['amount']) ? $_POST['amount'] : "";
    $currency = ($_POST['currency']) ? $_POST['currency'] : "";
    $comment = ($_POST['comment']) ? $_POST['comment'] : "";
    $tx_handler = new TransactionRestController();
    $tx_handler->addTransaction($senderId, $recipientId, $amount, $currency, $comment);
}
?>