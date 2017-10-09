<?php
require_once("controller/BalanceRestController.php");
header("Access-Control-Allow-Origin: *");
$account_id = "";
if(isset($_GET["account-id"]))
    $account_id = $_GET["account-id"];

$balanceRest = new BalanceRestController();
$balanceRest->getBalance($account_id);
?>