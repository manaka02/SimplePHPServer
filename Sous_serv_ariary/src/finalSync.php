<?php
require_once("controller/NotificationController.php");
header("Access-Control-Allow-Origin: *");

require_once('utils/ServicesDB.php');

    if(isset($_POST['expToken'])){
        $expToken = $_POST['expToken'];
        $pseudo =  $_POST['pseudo'];
        $device_id =  $_POST['pseudo'];

        $notif = new NotificationController();
        $services = new ServicesDB();
        $connex = $services->initiateConnex();
        $responses = $notif->init($pseudo, $expToken);
        
        // $responses = $services->setNewAccount($connex, 1,'toavina','expSiemen', 'Siemenes');
        
        echo $responses;
    }


?>