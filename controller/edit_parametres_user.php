<?php

require_once '../model/parametre.php';

if ( isset( $_POST['form_data'] ) )
{
    $user_data = $_POST['form_data'];
    $email     = $user_data['email'];
    $mdp       = $user_data['mot de passe'];
    $hash_mdp  = password_hash($mdp, PASSWORD_BCRYPT);
    $arobase   = $user_data['username'];
    $token     = $user_data['token'];
    
    $db = new Parametres();
    $db->connect_to_db();
    $sql = ($db->edit_parametres_user($token, $email, $hash_mdp, $arobase));

    if ($sql == 1){
        echo 'check_modif';
        return;
    }
    
}