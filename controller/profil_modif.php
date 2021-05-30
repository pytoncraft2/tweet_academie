<?php
require_once '../model/profil.php';

if ( isset( $_POST['token'] ) )
{
    $token = $_POST['token'];}
if ( isset( $_POST['pseudo'] ) )
{
    $pseudo = $_POST['pseudo'];}
if ( isset( $_POST['biographie'] ) )
{
    $biographie = $_POST['biographie'];}
if ( isset( $_POST['localisation'] ) )
{
    $localisation = $_POST['localisation'];}

$db = new Info_profil();
$db->connect_to_db();
$result = $db->modif_info_user( $token, $pseudo, $biographie, $localisation );
echo $result;
?>