  <?php
    $URL_EXPO = "https://exp.host/--/api/v2/push/send";
    include_once('Util.php');
  class InitNotifServices 
  {
      private function getHeaderDefault(){
        $header = array(
                  'accept' =>'application/json',
                  'accept-encoding' => 'gzip, deflate',
                  'content-type'=> 'application/json'
                );
        return $header;
      }
    
      public function init($user,$userToken){
          $message = "Bonjour ".$user.' on vous enverra désormais un message sur ce mobile à chaque transaction sur votre compte';
          $data = array(
            'userToken' => $userToken,
            'message' => $message 
          );
          $this->notify($data);
      }


      public function notify(array $usersData){
        $utils = new Util();
        $header = $this->getHeaderDefault();
        $type = "POST";
        $params = array();
        foreach ($usersData as $user) {
          $oneUser = array(
            'to' => $user->userToken,
            'sound' => 'default',
            'body' => $user->message,
            'badge'=> 1
          );
          array_push($params, $oneUser);
        }
        $paramsJSON = json_encode($params);
          try{
            $utils->sendCurl($URL_EXPO,$type, $header, $paramsJSON);
          }catch(Exeption $e){
            echo($e);
          }
          
        
      }
  }
    