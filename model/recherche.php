<?php
require_once 'bdd.php';

class Recherche extends MyDatabase
{

    public function arobase($cle)
    {
        $req = "SELECT username ,token FROM user WHERE username LIKE '%{$cle}%'";
        $res = $this->pdo->query($req);
        $donnes = $res->fetch();
        echo $donnes['token'];
    }

    public function findKey($cle)
    {
        $req = "SELECT username, token FROM user WHERE username LIKE '{$cle}%'";
        $res = $this->pdo->query($req);
        $donnes = $res->fetchAll();
        foreach ($donnes as $val) {
            echo "<a href=view.php?t=" . $val['token'] . "><div class='recherche'>" . $val[0] . "</div></a>";
        }

        if (substr($cle, 0, 1) == "@") {
            $req = "SELECT arobase ,token FROM user WHERE arobase LIKE '{$cle}%'";
            $res = $this->pdo->query($req);
            $donnes = $res->fetchAll();
            foreach ($donnes as $val) {
                echo "<a href=view.php?t=" . $val['token'] . "><div class='recherche'>" . $val[0] . "</div></a>";
            }
        } else if (substr($cle, 0, 1) == "#") {

            $req = "SELECT user.token ,CONCAT(CONCAT(SUBSTRING(contenu,1,1),SUBSTRING(contenu,2)), '...') AS 'preview' FROM tweet INNER JOIN user ON user.id_user = tweet.id_user WHERE contenu LIKE '%{$cle}%'";
            $res = $this->pdo->query($req);
            $donnes = $res->fetchAll();
            foreach ($donnes as $val) {
                echo "<a href=view.php?t=" . $val['token'] . " ><div class=recherche>" . $val['preview'] . "</div></a>";
            }
        }
    }

    public function toString($cle)
    {
        return $this->findKey($cle);
    }
}