<?php
require_once("controller/NotificationController.php");
header("Access-Control-Allow-Origin: *");

require_once('utils/ServicesDB.php');


$services = new NotificationController();

$responses = $services->synchronise('ExponentPushToken[D9NQh3AxoQB_PSporLKfsI]', 1, 'toavina');

// $responses = $services->insertTransaction($connex, 3,4,null, 'expSiemen', 'comment', 1500,'Ar');

var_dump($responses);
?>