<?php

require_once '../model/profil.php';

if(isset($_POST['token_user'])){
  $token_user = $_POST['token_user'];
};
if ( isset( $_POST['token'] ) )
{
    $token = $_POST['token'];
}

$db = new Info_profil();
$db->connect_to_db();
$result = $db->add_follow($token,$token_user);
print_r ($result);
// echo json_encode($result);