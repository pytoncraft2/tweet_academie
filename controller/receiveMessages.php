<?php
    
    require_once '../model/messages.php';
    $show = new Messages();
    $show->connect_to_db();
    $show->affichage_message($_POST["from"],$_POST["to"]);
