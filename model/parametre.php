<?php

require_once 'bdd.php';

class Parametres extends MyDatabase {

    public function desactive($token){

        $stmt = $this->pdo->prepare("UPDATE user SET active ='0' WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }    
    
    public function get_parametres_user($token){

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE token = :token AND active = 1");
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }

        catch (PDOException $e){
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function edit_parametres_user($token, $email, $hash_mdp, $arobase){

        try {
            
            $stmt_ = $this->pdo->prepare( "UPDATE user SET email = :email, mot_de_passe = :mot_de_passe, arobase = :arobase WHERE token = :token AND active = 1" );
            $stmt_->bindParam(':token', $token);
            $stmt_->bindParam( ':email', $email );
            $stmt_->bindParam( ':mot_de_passe', $hash_mdp );
            $stmt_->bindParam( ':arobase', $arobase );
            $stmt_->execute();
            return 1;   
        }

        catch (PDOException $e){
            return "Error :" . $e->getMessage() . "\n";
        }
    }
    
}