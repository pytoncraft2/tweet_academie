<?php    
    require_once '../model/messages.php';
    $mot = $_POST['b'];
    $getName = new Messages();
    $getName->connect_to_db();
    $getName->req_message_nom($mot);
