<?php
header("Access-Control-Allow-Origin: *");
require_once("controller/UserDataController.php");
require_once('utils/ServicesDB.php');

    if(isset($_POST['id_account'])){
        $id_account =  $_POST['id_account'];

        $userServices= new UserDataController();
        $responses = $userServices->getUserData($id_account);
  
        echo ($responses);
    }


?>