<?php
require_once "bdd.php";

class Connexion extends MyDatabase
{
    public function user_connexion( $email, $password )
    {

        $req =$this->pdo->prepare("SELECT token, mot_de_passe FROM user WHERE email =:email AND active =1");
        $req->bindParam(':email', $email);
        $req->execute();
        $connexion = $req->fetch();
       
        if ( !empty( $connexion ) )
        {
            $pass_verif = password_verify($password, $connexion['mot_de_passe']);
            if($pass_verif == true){
                return $connexion;
            }
            return false;

        }
        else
        {
            return false;
        }

     }

}