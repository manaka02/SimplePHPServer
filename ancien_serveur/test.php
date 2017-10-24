  <?php
    
    include_once('Util.php');
  class InitNotifServices 
  {
      private function getHeaderDefault(){
        $header = array(
                  'accept' =>'application/json',
                  'accept-encoding' => 'gzip, deflate',
                  'content-type'=> 'form-data'
                );
        return $header;
      }
    
      public function init($user,$userToken){
          $message = "Bonjour ".$user;
          $notification = ['body' =>$message];;
          $this->notify($userToken, $notification);
      }


      public function notify($usersData){
        $URL_EXPO = "https://exp.host/--/api/v2/push/send";
        $utils = new Util();
        $header = $this->getHeaderDefault();
        $type = "POST";
        $params = array();
        
        foreach ($usersData as $user) {
          $oneUser = array(
            'to' => $user['userToken'],
            'sound' => 'default',
            'body' => $user['message'],
            'badge'=> 1
          );
          array_push($params, $oneUser);
        }
        $paramsJSON = json_encode($params);
          try{
            $test = $utils->sendCurl($URL_EXPO,$type, $header, $paramsJSON);
            var_dump($test);
          }catch(Exeption $e){
            echo($e);
          }
          
        
      }
  }
    