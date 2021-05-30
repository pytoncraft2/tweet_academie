<?php
require_once '../model/profil.php';

if ( isset( $_POST['token'] ) )
{
    $token = $_POST['token'];}

$db = new Info_profil();
$db->connect_to_db();
$result = $db->affiche_like_user( $token );
echo json_encode( $result );
?>