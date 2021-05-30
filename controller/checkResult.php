<?php
require_once '../model/resultSearch.php';
$result = new Result();
$result->connect_to_db();
$result->checkResult($_POST["recherche"]);