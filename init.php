<?php
    include_once('NotifServices.php');

    if(isset($_POST['token'])){
      
      $user = $_POST['username'];
      $userToken = $_POST['token'];
      $service = new NotifServices();
      try{
        $service->init($user, $userToken);
      }catch(Exception $e){
        var_dump($e);
      }
        

    }else{
      echo('tsis inin le POST ah');
    }

