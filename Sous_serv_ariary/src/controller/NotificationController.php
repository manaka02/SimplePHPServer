<?php
    header("Access-Control-Allow-Origin: *");
    include_once('utils/Expo_util.php');
    include_once('utils/ServicesDB.php');
    include_once 'controller/SimpleRestController.php';
  class NotificationController extends SimpleRestController
  {

    function __construct(){
        parent::__construct(false);
    }

    private $httpVersion = "HTTP/1.1";


    public function init($pseudo, $code, $expToken, $idmobile){
        $tokeninfo = $this->getTokenInfo();
        if(isset($tokeninfo->active) && $tokeninfo->active){
            $utils = new Util();
            $services = new ServicesDB();
            $data = null;
            $statusCode = 200;
            try{
                $connex = $services->initiateConnex();
                $data = $services->addNewAccount($connex,$pseudo,$code, $idmobile, $expToken);
                $response = $data;
                if(empty($data)){
                    $statusCode = 404;
                    $response = array("error"=>"Not found");
                }
                $services->closeConnex($connex);
            }catch (PDOException $e) {
                $statusCode = 404;
                $response = array("error"=>"Erreur de connexion");
                $services->closeConnex($connex);
            }
        }else{
            $statusCode = 401;
            $response = array('error'=>'Unauthorized','error_description'=>"The token is no longer valide or have been invalidated");
        }
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);

        $response = $this->encodeJson($response);
        echo  $response;
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
        $utils = new Expo_util();
        $params = array();
        
        foreach ($usersData as $user) {
            $user['data'] != null
            ? $oneUser = array(
                'to' => $user['userToken'],
                'sound' => 'default',
                'body' => $user['message'],
                'badge'=> 1,
                'title' => 'nouvelle transaction',
                'data' =>  $user['data']
                
              )
            : $oneUser = array(
                'to' => $user['userToken'],
                'sound' => 'default',
                'body' => $user['message'],
                'badge'=> 1,
                'title' => 'nouvelle transaction'                
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

      
  }
    