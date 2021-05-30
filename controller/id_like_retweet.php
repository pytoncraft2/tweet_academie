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
$result1 = $db->id_retweet( $id_post, $token );
$result  = $db->id_like( $id_post, $token );
$result_ = [];
array_push( $result_, $result1 );
array_push( $result_, $result );
print_r( json_encode( $result_ ) );
?>