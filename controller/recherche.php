<?php
require_once '../model/recherche.php';
$key = new Recherche();
$key->connect_to_db();
$key->toString($_POST["key"]);