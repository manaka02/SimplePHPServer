<?php
    
    include_once('utils/Expo_util.php');
    include_once('utils/ServicesDB.php');
  class NotificationController 
  {
    private $httpVersion = "HTTP/1.1";
    
    public function setHttpHeaders($statusCode){
        $statusMessage = $this -> getHttpStatusMessage($statusCode);
        header("Access-Control-Allow-Origin: *");
        header($this->httpVersion. " ". $statusCode ." ". $statusMessage);
    }

    public function stopNotify($connex, $account_id){
        try{
            $nb = $dbservice->changeStatus($connex,$account_id, 0);
        }catch(Exception $e){
            echo($e->message);
        }
        $dbservice->closeConnex($connex);
    }

    public function beginSync($expToken,$id_father, $device_id, $alias, $refresh_token){
        $services = new ServicesDB();
        $connex = $services->initiateConnex();

        $newIdAccount = $services->synchronise($connex, $id_father, $device_id, $expToken, $alias);
        $data = array(
            'type' => 'sync',
                    'id_account' => $newIdAccount,
                    'refresh_token' => $refresh_token,
                    'alias' => $alias
                );
            $dataJson = json_encode($data);
            $array = array(
            array(
            'userToken' => $expToken, 
            'message' => 'Synchronisation en cours',
            'title' => 'Synchronisation',
            'data' => $data
            ));

        $this->notify($array);
    }

    

    /**
     * fonction pour notifier une ou plusieurs devices
     * @example dictionnaire userData : [
     *    {
     *      userToken : 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]',
     *      message : 'VOus avez recu tel somme'  
     *  'title' => 'nouvelle transaction',
     *      data : '{"from":"toavina","amount":25000,"date":"24-08-17 12:00:00","type":"Achat"}'  
     *    },
     *    {
     *      userToken : 'ExponentPushToken[548-MAH3q7rfedRwZR-rGAq]',
     *      message : 'Vous avez envoyé de l'argent  ,
     *      'title' => 'nouvelle transaction',
      *    'data' => '{"from":"toavina","amount":25000,"date":"24-08-17 12:00:00","type":"Achat"}'  
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
            'badge'=> 1,
            'title' => $user['title'],
            'data' => json_encode($user['data'])
          );
          array_push($params, $oneUser);
        }

        $paramsJSON = json_encode($params);
        var_dump($params);
          try{
            $test = $utils->sendCurl($paramsJSON);
          }catch(Exeption $e){
            var_dump($e);
          }
      }

      /**
       * Synchronisation client app and marchand App
       *
       * @return void
       */
      public function synchronise($expToken, $id_account, $pseudo){
        $data = array('type' => 'sync',
                        'id_account' => $id_account,
                        'pseudo' => $pseudo
                      );
        $dataJson = json_encode($data);
        $array = array(
            array(
                'userToken' => $expToken, 
                'message' => 'Synchronisation avec le compte de '.$pseudo,
                'title' => 'Debut de Synchronisation',
                'data' => $data
            ));

        $this->notify($array);
      }

      /**
       * call after finish synchrone and add token into BDD
       *
       * @param string $expToken
       * @return void
       */
      public function finishSynchronise($connex,$expToken, $pseudo,$device_id){
        $services = new ServicesDB();
        // $services->setNewAccount($connex,)
        $data = array('type' => 'finishSync' );
        $array = array(
            array(
                'userToken' => $expToken, 
                'message' => 'Synchronisation efféctuée',
                'title' => 'Succès',
                'data' => $data
            ));
        $this->notify($array);
      }

      public function Desynchronise($ExpToken){
        $data = array('type' => 'stopSync' );
        $array = array(
            array(
                'userToken' => $expToken, 
                'message' => 'La Synchronisation a été coupée',
                'title' => 'Stop Synchronisation',
                'data' => $data
            ));

        $this->notify($array);
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
    