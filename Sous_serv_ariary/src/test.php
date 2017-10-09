<?php
require_once("controller/SynchronisationController.php");
header("Access-Control-Allow-Origin: *");

require_once('utils/ServicesDB.php');


$services = new ServicesDB();
$connex = $services->initiateConnex();
$responses = $services->insertTransaction($connex, 3,4,null, 'expSiemen', 'comment', 1500,'Ar');

var_dump($responses);
?>