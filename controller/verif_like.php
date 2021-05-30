<?php
require_once "../model/profil.php";
if ( isset( $_POST['token'] ) )
{
    $token = $_POST['token'];}
if ( isset( $_POST['id_post'] ) )
{
    $id_post = $_POST['id_post'];}

$db = new Info_profil();
$db->connect_to_db();
$result = $db->verif_like_user( $token, $id_post );
echo json_encode( $result );

?>