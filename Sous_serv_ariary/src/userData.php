<?php
header("Access-Control-Allow-Origin: *");
require_once("controller/UserDataController.php");
require_once('utils/ServicesDB.php');

    if(isset($_POST['id_account'])){
        $id_account =  $_POST['id_account'];

        $userServices= new UserDataController();
        $responses = $userServices->getUserData($id_account);
  
<<<<<<< HEAD
        echo $responses;
=======
        echo ($responses);
>>>>>>> 67809c3f2fb3bc57434ddf2edf4d68e77a7ab23f
    }


?>