<?php

class ServicesDB
{
    
    public function initiateConnex(){
        // $user='ariary_vola_mg';
        // $pass='mg7R5JU92pwv3f6';
        // $dsn='mysql:host=localhost;dbname=ariary_vola_mg';
        $user='root';
        $pass='root';
        $dsn='mysql:host=localhost;dbname=usertoken';
        

        try {
            $dbh = new PDO($dsn, $user, $pass,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            return $dbh;
        } catch (PDOException $e) {
            print "Erreur ! : " . $e->getMessage();
            die();
        }
    }

    public function closeConnex($connex){
        $connex=null;
    }

    public function getUserData($connex, $pseudo, $expToken){
        $sql = 'select * from account where pseudo = :pseudo and exptoken = :expToken';
        $sth = $connex->prepare($sql);
        $sth->execute(array(
            ':pseudo' => $pseudo,
            ':expToken' => $expToken
        ));
        $response = $sth->fetchObject();
        return $response;
    }

    public function synchronise($connex, $id_father, $device_id, $expToken,  $alias)
    {
        $connex->beginTransaction();
        try{
            $new_id_account = $this->addNewAccountWithIdFather($connex,$id_father, $device_id, $expToken,$alias);
            $query2 = $this->addNewTree($connex, $new_id_account, $id_father);

            $connex->commit();
            return $new_id_account;
        }catch(PDOExecption  $e){
            echo "Error!: " . $e->getMessage() . "</br>"; 
            $connex->rollBack();
            throw $e;
        }
    }

    public function addNewAccountWithIdFather($connex,$id_father, $idmobile, $exptoken, $alias )
    {
        try{
            $stmt = $connex->prepare("INSERT INTO account (pseudo, idmobile,exptoken,alias, connected) select pseudo, :idmobile, :exptoken,:alias, connected from account where id_account = :id_account
            ON DUPLICATE KEY UPDATE connected = 1,  alias = :alias");
            $stmt->bindParam('id_account', $id_father);
            $stmt->bindParam('idmobile', $idmobile);
            $stmt->bindParam('exptoken',$exptoken);
            $stmt->bindParam('alias',$alias);
            $req = $stmt->execute();
            $lastInsert = $connex->lastInsertId();
            if($lastInsert == 0){
                echo "un ancien enfant";
                $stmt2 = $connex->prepare('select id_account from account where exptoken = :exptoken');
                $stmt2->execute(array(':exptoken' => $exptoken));
                $response = $stmt2->fetchAll();
                $lastInsert = $response[0]['id_account'];
            }
            return $lastInsert; 
       }catch(PDOExecption  $e){
            echo "Error!: " . $e->getMessage() . "</br>"; 
            throw $e;
       }
    }

    public function addNewAccount($connex,$pseudo, $idmobile, $expToken)
    {
        try{
            $stmt = $connex->prepare("INSERT INTO account (pseudo, idmobile,exptoken,alias, connected) select :pseudo, :idmobile, :expToken,:alias, connected from account where pseudo = :pseudo and exptoken = :expToken 
            ON DUPLICATE KEY UPDATE connected = 1");
                    $stmt->bindParam('pseudo', $pseudo);
                    $stmt->bindParam('alias', $pseudo);
                    $stmt->bindParam('idmobile', $idmobile);
                    $stmt->bindParam('expToken', $expToken);
                    $req = $stmt->execute();
                    return $connex->lastInsertId(); 
        }catch(PDOExecption  $e){
            echo "Error!: " . $e->getMessage() . "</br>"; 
            throw $e;
       }
    }

    // public function addNewAccount($connex,$pseudo, $idmobile, $expToken){
    //    try{
    //         $stmt = $connex->prepare("INSERT INTO account (pseudo, idmobile,expToken,alias,connected) VALUES(?,?,?,'',1)
    //         ON DUPLICATE KEY UPDATE connected = 1");
    //         $stmt->bindParam(1, $pseudo);
    //         $stmt->bindParam(2, $idmobile);
    //         $stmt->bindParam(3, $expToken);
    //         $req = $stmt->execute();
    //         return $connex->lastInsertId(); 
    //    }catch(PDOExecption  $e){
    //         echo "Error!: " . $e->getMessage() . "</br>"; 
    //         throw $e;
    //    }
    // }

    public function addNewTree($connex, $id_account, $father){
        try{
            $stmt = $connex->prepare("INSERT INTO tree (id_account, father) VALUES(?,?)");
            $stmt->bindParam(1, $id_account);
            $stmt->bindParam(2, $father);
            $req = $stmt->execute();
            return $req;
       }catch(PDOExecption  $e){
            echo "Error!: " . $e->getMessage() . "</br>"; 
            throw $e;
       }
    }

    public function getAllDevices($connex, $pseudo){
        $sql = 'select * from account where pseudo = :pseudo and connected = 1';
        $sth = $connex->prepare($sql);
        $sth->execute(array(':pseudo' => $pseudo));
        $response = $sth->fetchAll();
        return $response;
    }

   
}
