<?php
require_once '../model/profil.php';

if ( isset( $_POST['id_post'] ) )
{
    $id_post = $_POST['id_post'];}
if ( isset( $_POST['token'] ) )
{
    $token = $_POST['token'];}

$db = new Info_profil();
$db->connect_to_db();
$result = $db->reply_final( $id_post, $token );
echo json_encode( $result );

?>