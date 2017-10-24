<?php
header("Access-Control-Allow-Origin: *");
require_once("controller/UserDataController.php");
require_once('utils/ServicesDB.php');

    if(isset($_GET['pseudo'])){
        $pseudo =  $_GET['pseudo'];
        $expToken =  $_GET['expToken'];

        $userServices= new UserDataController();
        $responses = $userServices->getUserData($pseudo, $expToken);
  
        echo $responses;
    }else{
        $error = array(
            'error' => 'error data'
        );
        echo json_encode($error);
    }


?>