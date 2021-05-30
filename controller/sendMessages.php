<?php
    
    require_once '../model/messages.php';
    $msg = new Messages();
    $msg->connect_to_db();
    $msg->insert_message($_POST["contenu"],$_POST["to"],$_POST["from"]);
