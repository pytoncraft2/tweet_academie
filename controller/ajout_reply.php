<?php
require_once '../model/profil.php';

if ( isset( $_POST['id_post'] ) )
{
    $id_post = $_POST['id_post'];}
if ( isset( $_POST['token'] ) )
{
    $token = $_POST['token'];}
if ( isset( $_POST['textarea'] ) )
{
    $textarea = $_POST['textarea'];}
$db = new Info_profil();
$db->connect_to_db();
$result = $db->reply_publish( $id_post, $token, $textarea );
echo json_encode( $result );

?>