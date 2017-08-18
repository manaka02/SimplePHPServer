  <?php
    
    include_once('Util.php');
    include_once('ServicesDB.php');
  class NotifServices 
  {
    
      public function init($user,$userToken){
          $message = 'Bonjour '.$user;
          $userData = array(
            'userToken' => $userToken,
            'message' => $message
          );
          $dbservice = new ServicesDB();
          $connex = $dbservice->initiateConnex();
          $dbservice->insertToken($connex, $userToken, $user);
          $this->notify([$userData]);
          $dbservice->closeConnex($connex);
      }

      public function stopNotify($userToken){
        $dbservice = new ServicesDB();
        $connex = $dbservice->initiateConnex();
        try{
          $nb = $dbservice->deleteToken($connex,$userToken);
        }catch(Exception $e){
          echo($e->message);
        }
      }

    /**
     * fonction pour notifier une ou plusieurs devices
     * @example dictionnaire userData : [
     *    {
     *      userToken : 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]',
     *      message : 'VOus avez recu tel somme'    
     *    },
     *    {
     *      userToken : 'ExponentPushToken[548-MAH3q7rfedRwZR-rGAq]',
     *      message : 'Vous avez envoyé de l'argent    
     *    }
     * ]
     *
     * @param [type] $userData
     * @return void
     */
      public function notify($usersData){
        $utils = new Util();
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
            $test = $utils->sendCurl($paramsJSON);
          }catch(Exeption $e){
            echo($e);
          }
      }
  }
    