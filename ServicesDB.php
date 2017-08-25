<?php

class ServicesDB
{
    public function initiateConnex(){
        $user='root';
        $pass='root';
        $dsn='mysql:host=localhost;dbname=usertoken';

        try {
            $dbh = new PDO($dsn, $user, $pass);
            return $dbh;
        } catch (PDOException $e) {
            print "Erreur ! : " . $e->getMessage();
            die();
        }
    }

    public function closeConnex($connex){
        $connex=null;
    }

    public function getByUser($connex, $user_id){
        $sql = "select * from expo_token where user_id = :user_id";
        $sth = $connex->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':user_id' => $user_id));
        $response = $sth->fetchAll();

        return $response;
    }

    public function getUserWithMobile($connex, $user_id, $token){
        $sql = "select * from expo_token where user_id = :user_id and token = :token";
        $sth = $connex->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':user_id' => $user_id, ':token' => $token));
        $response = $sth->fetchAll();

        return $response;
    }


    public function updateStatus($connex, $user, $userToken, $newStatus ){
        $connex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql="UPDATE expo_token SET connected = :status WHERE user_id = :user AND token = :userToken";
        try{
            $req = $connex->prepare($sql);
            $req->execute(array(
                'status' => $newStatus,
                'user' => $user,
                'userToken' => $userToken));
    
            echo $req->rowCount() . " records UPDATED successfully";
        }catch(Exception $e){
             var_dump($e);
        }
    }

    public function deleteToken($connex, $token){
        $sql = "DELETE FROM expo_token WHERE token = '".$token."'";
        $count = $connex->exec($sql);
        $q = $connex->prepare($sql);
        $response = $q->execute(array($token));    
        if($response == 0){
            throw new Exception("le token n'existe pas dans la base");
        }
        return $response;
    }

    public function insertToken($connex, $token, $user_id, $status){
        $stmt = $connex->prepare("INSERT INTO expo_token (user_id, token, connected) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $token);
        $stmt->bindParam(3, $status);
        $stmt->execute();
    }

    public function getAll($connex){
        $sql = "select * from expo_token";
        $sth = $connex->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        $response = $sth->fetchAll();
        return $response;
    }


}
