<?php
require_once '../model/profil.php';

if ( isset( $_POST['token'] ) )
{
    $token = $_POST['token'];}

$db = new Info_profil();
$db->connect_to_db();
$result = $db->tweet_user( $token );
print_r( json_encode( $result ) );
?>