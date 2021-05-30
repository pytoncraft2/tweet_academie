<?php
require_once '../model/profil.php';

if ( isset( $_POST['id_post'] ) )
{
    $id_post = $_POST['id_post'];}

$db = new Info_profil();
$db->connect_to_db();
$result1 = $db->compteur_retweet(  ( $id_post ) );
$result  = $db->compteur_like( $id_post );
$result_ = [];
array_push( $result_, $result1 );
array_push( $result_, $result );
print_r( json_encode( $result_ ) );
?>