<?php

class ClassName
{
    public function initiateConnex(){
        $user='root';
        $pass='root';
        $dsn='pgsql:host=localhost;port=5432;dbname=usertoken';

        try {
            $dbh = new PDO($dsn, $user, $pass);
            print "Connecté :)";
            return dbh;
        } catch (PDOException $e) {
            print "Erreur ! : " . $e->getMessage();
            die();
        }
    }

    public function closeConnex($connex){
        $connex.close();
    }

    public function getToken($connex, $user_id){

    }

    public function deleteToken($connex, $user_id){

    }

    public function insertToken($connex, $token, $user_id){

    }

    public function getAll($connex){

    }


}
