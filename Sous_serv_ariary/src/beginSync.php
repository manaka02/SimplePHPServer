<?php
require_once("controller/NotificationController.php");
header("Access-Control-Allow-Origin: *");

require_once('utils/ServicesDB.php');

    if(isset($_POST['expToken'])){
        $expToken = $_POST['expToken'];
        $id_account =  $_POST['id_account'];
        $device_id =  $_POST['device_id'];
        $alias =  $_POST['alias'];
        $refresh_token = $_POST['refresh_token'];

        $notif = new NotificationController();
        $responses = $notif->beginSync($expToken, $id_account,$device_id, $alias, $refresh_token);
  
        echo $responses;
    }


?>