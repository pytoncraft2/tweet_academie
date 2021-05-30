<?php

require_once '../model/connexion.php';

$db = new Connexion();
$db->connect_to_db();

$email = $_POST["email"];
$mdp   = $_POST["mot_de_passe"];

$req = $db->user_connexion( $email, $mdp );
echo(json_encode($req));