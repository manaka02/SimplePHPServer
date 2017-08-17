<?php
    include_once('initNotifServices');

    if(isset($_POST['token'])){
      
      $user = $_POST['username'];
      $userToken = $_POST['token'];
      $service = new InitNotifServices();
      try{

      }catch(Exception $e){
        $service->init($user, $userToken);
      }
        

    }else{
      echo('tsis inin le POST ah');
    }

