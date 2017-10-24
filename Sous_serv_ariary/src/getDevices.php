<?php
require_once("controller/UserDataController.php");
header("Access-Control-Allow-Origin: *");

require_once('utils/ServicesDB.php');

    if(isset($_POST['pseudo'])){
        $pseudo =  $_POST['pseudo'];
        
        $userServices= new UserDataController();
        $responses = $userServices->getAllDevices($pseudo);
    
        echo $responses;
    }else{
        $error = array(
            'error' => 'error data'
        );
        echo json_encode($error);
    }


?>