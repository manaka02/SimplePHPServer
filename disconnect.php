<?php
    include_once('NotifServices.php');

    if(isset($_POST['token'])){

      $userToken = $_POST['token'];
      $service = new NotifServices();
      try{
        $service->stopNotify($userToken);
        echo json_encode('successfull');
      }catch(Exception $e){
        echo($e->message);
      }
        

    }else{
      echo('tsis inin le POST ah');
    }

