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


    // getting

    public function getAllChilds($connex,$pseudo)
    {
        $sql = "select * from account where pseudo = :pseudo and father is not null";
        $sth = $connex->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':pseudo' => $pseudo));
        $response = $sth->fetchAll();

        return $response;
    }

    public function getHistory($connex,$account_id){
        $sql = "select * from transaction where 
        sender in (select id_account from account where id_account = :account_id or  father = :account_id)
         or recipient in (select id_account from account where id_account = :account_id or  father = :account_id)";
        $sth = $connex->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':account_id' => $account_id));
        $response = $sth->fetchAll();

        return $response;
    }

    public function changeStatus($connex,$account_id, $status){
        $connex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql="UPDATE account SET connected = :status WHERE id_account = :account_id";
        try{
            $req = $connex->prepare($sql);
            $req->execute(array(
                'status' => $status,
                'account_id' => $account_id)
            );
            echo $req->rowCount() . " records UPDATED successfully";
        }catch(Exception $e){
             var_dump($e);
        }
    }


    public function setNewAccount($connex, $father,$pseudo, $idmobile, $exptoken){
        $stmt = $connex->prepare("INSERT INTO account (father, pseudo, idmobile,exptoken) VALUES(?,?,?,?)
                ON DUPLICATE KEY UPDATE connected = 1");
        // $stmt = $connex->prepare($sql);
        $stmt->bindParam(1, $father);
        $stmt->bindParam(2, $pseudo);
        $stmt->bindParam(3, $idmobile);
        $stmt->bindParam(4, $exptoken);
        $stmt->execute();
    }


    public function insertTransaction($connex, $sender, $recipient, $date_transaction, $type, $comment, $amount, $currency){
        $stmt = $connex->prepare("INSERT INTO transaction (sender, recipient, date_transaction, type, comment,amount, currency ) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $sender);
        $stmt->bindParam(2, $recipient);
        $stmt->bindParam(3, $date_transaction);
        $stmt->bindParam(4, $type);
        $stmt->bindParam(5, $comment);
        $stmt->bindParam(6, $amount);
        $stmt->bindParam(7, $currency);
        $stmt->execute();
    }

}
