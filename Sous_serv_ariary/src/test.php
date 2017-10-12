<?php
require_once("controller/NotificationController.php");
header("Access-Control-Allow-Origin: *");

require_once('utils/ServicesDB.php');

    if(isset($_POST['token'])){
        $token = $_POST['token'];
        $notif = new NotificationController();
        $services = new ServicesDB();
        $connex = $services->initiateConnex();
        $responses = $notif->synchronise($token, 1, 'toavina');
        
        // $responses = $services->setNewAccount($connex, 1,'toavina','expSiemen', 'Siemenes');
        
        var_dump($responses);
    }


?>