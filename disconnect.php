<?php
    include_once('NotifServices.php');

    if(isset($_POST['token'])){

      $userToken = $_POST['token'];
      $user = $_POST['user'];
      $service = new NotifServices();
      try{
        $service->stopNotify($user, $userToken);
        echo json_encode('successfull');
      }catch(Exception $e){
        echo($e->message);
      }
        

    }else{
      echo('tsis inin le POST ah');
    }

