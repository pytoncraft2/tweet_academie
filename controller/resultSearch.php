<?php
require_once '../model/resultSearch.php';

if (isset($_POST["tokenFromSearch"]) && isset($_POST["tokenUser"])) {
    $result = new Result();
    $result->connect_to_db();
    $result->get_user_tweet($_POST["tokenFromSearch"], $_POST["tokenUser"] );
}

if (isset($_POST["tokenFromSearch"]) && isset($_POST["tokenUserFollow"])) {
    $result = new Result();
    $result->connect_to_db();
    $result->get_user_info($_POST["tokenFromSearch"], $_POST["tokenUserFollow"]);
}
