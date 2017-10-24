<?php
require_once("controller/UserDataController.php");
header("Access-Control-Allow-Origin: *");

require_once('utils/ServicesDB.php');

    if(isset($_POST['id_account'])){
        $id_account =  $_POST['id_account'];
        
        $userServices= new UserDataController();
        $responses = $userServices->getAllDevices($id_account);
    
        echo $responses;
    }


?>