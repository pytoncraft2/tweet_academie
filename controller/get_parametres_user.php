<?php

require_once '../model/parametre.php';

if (isset($_POST["token"])) {
    
    $token = $_POST["token"];
    
    $db = new Parametres;
    $db->connect_to_db();

    $result_get = $db->get_parametres_user($token);
    echo(json_encode($result_get));
       
}