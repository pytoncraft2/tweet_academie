<?php

class MyDatabase {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;
    public $pdo;

    public function connect_to_db(){
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "M1N3CRAFT";
        $this->dbname = "tweet_academie";
        $this->charset = "utf8mb4";

        try {
        $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo; 
        } catch (PDOException $e) {
            echo "Connexion échouée: ".$e->getMessage();
        }
    }
}
