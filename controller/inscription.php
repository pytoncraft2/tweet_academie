<?php

require_once '../model/inscription.php';

if ( isset( $_POST['form_data'] ) )
{
    $user_data = $_POST['form_data'];
    $username  = $user_data['username'];
    $arobase   = $user_data['arobase'];
    $date      = $user_data['date de naissance'];
    $email     = $user_data['email'];
    $mdp       = $user_data['mot de passe'];
    $hash_mdp  = password_hash($mdp, PASSWORD_BCRYPT);
    $token     = $user_data['token'];

    $db = new Inscription();
    $db->connect_to_db();

    if (  ( $db->do_user_exist( $email ) ) == true )
    {
        echo 'exist';

        return;
    }
    else
    {
        $db->add_user_to_db( $username, $arobase, $date, $email, $hash_mdp, $token );
    }
}