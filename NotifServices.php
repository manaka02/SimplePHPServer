  <?php
    
    include_once('Util.php');
    include_once('ServicesDB.php');
  class NotifServices 
  {
    private $httpVersion = "HTTP/1.1";
    
    public function setHttpHeaders($statusCode){
        $statusMessage = $this -> getHttpStatusMessage($statusCode);
        header("Access-Control-Allow-Origin: *");
        header($this->httpVersion. " ". $statusCode ." ". $statusMessage);
    }

      public function userExist($connex, $username){
        $dbservice = new ServicesDB();
        $listUser = $dbservice->getByUser($connex, $username);
        if(count($listUser) >0) return true;
        else return false;
      }
    
      public function createAccount($user,$userToken){
          $message = 'le compte '.$user.' a été bien enregistré';
          $userData = array(
            'userToken' => $userToken,
            'message' => $message
          );
          $dbservice = new ServicesDB();
          $connex = $dbservice->initiateConnex();
          if($this->userExist($connex, $user)){
            $this ->setHttpHeaders(405);
            echo "Username already exist";
          }else{
            $dbservice->insertToken($connex, $userToken, $user, 1);
            $this->notify([$userData]);
            echo ('successfull');
          }
          
          $dbservice->closeConnex($connex);
      }

      public function stopNotify($user, $userToken){
        $dbservice = new ServicesDB();
        $connex = $dbservice->initiateConnex();
        try{
          $nb = $dbservice->updateStatus($connex,$user,$userToken, 0);
        }catch(Exception $e){
          echo($e->message);
        }
        $dbservice->closeConnex($connex);
      }

      public function init($user, $userToken){
        $message = 'Bonjour '.$user;
        $userData = array(
          'userToken' => $userToken,
          'message' => $message
        );
        $dbservice = new ServicesDB();
        $connex = $dbservice->initiateConnex();
        $listUser = $dbservice->getUserWithMobile($connex,$user,$userToken);
        var_dump($listUser);
        if(count($listUser) == 1){
          $dbservice->updateStatus($connex, $user, $userToken, 1);
        }else{
          $dbservice->insertToken($connex, $userToken, $user, 1);
        }
        
        $this->notify([$userData]);
        $dbservice->closeConnex($connex);
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


      public function getHttpStatusMessage($statusCode){
        $httpStatus = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'No sufficient funds or limits reached',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Invalid input',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }
  }
    