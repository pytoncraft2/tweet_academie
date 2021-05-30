<?php

require_once '../model/parametre.php';

$token = $_POST["token"];

if (isset($token)) {
    
    $db = new Parametres;
    $db->connect_to_db();

    $result_desactive = $db->desactive($token);
    echo(json_encode($result_desactive));

    
}