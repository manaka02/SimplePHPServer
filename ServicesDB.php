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

    public function getToken($connex, $user_id){
        $sql = "select * from expo_token where user_id = :user_id";
        $sth = $connex->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':user_id' => $user_id));
        $response = $sth->fetchAll();

        var_dump($response);
        return $response;
    }

    public function deleteToken($connex, $token){
        $sql = "delete from expo_token where token = ".$token;
        $count = $connex->exec($sql);
        if($count == 0){
            throw new Exception("le token n'existe pas dans la base");
        }
        return $count;
    }

    public function insertToken($connex, $token, $user_id){
        $stmt = $connex->prepare("INSERT INTO expo_token (user_id, token) VALUES (?, ?)");
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $token);
        $stmt->execute();
    }

    public function getAll($connex){
        $sql = "select * from expo_token";
        $sth = $connex->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        $response = $sth->fetchAll();
        var_dump($response);
        return $response;
    }


}
