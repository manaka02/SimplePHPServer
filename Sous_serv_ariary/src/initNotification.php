<?php
require_once("controller/NotificationController.php");
header("Access-Control-Allow-Origin: *");

require_once('utils/ServicesDB.php');

    if(isset($_POST['expToken'])){
        $expToken = $_POST['expToken'];
        $pseudo =  $_POST['pseudo'];
        $code =  $_POST['code'];
        $idmobile =  $_POST['idmobile'];

        $notif = new NotificationController();
        $responses = $notif->init($pseudo, $code, $expToken, $idmobile);
        
        // $responses = $services->setNewAccount($connex, 1,'toavina','expSiemen', 'Siemenes')
    }


?>