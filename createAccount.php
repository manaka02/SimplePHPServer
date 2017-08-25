<?php
    include_once('NotifServices.php');

    if(isset($_POST['token'])){
      
      $user = $_POST['username'];
      $userToken = $_POST['token'];
      $service = new NotifServices();
      try{ 
        $service->createAccount($user, $userToken);
        echo json_encode('successfull');
      }catch(Exception $e){
        var_dump($e);
      }
        

    }else{
      echo('tsis inin le POST ah');
    }

