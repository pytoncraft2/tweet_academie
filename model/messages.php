<?php
require_once "bdd.php";
class Messages extends MyDatabase
{

    public function req_message_nom($mot)
    {
        if ($mot != "") {
            $req = "SELECT username, token FROM user WHERE username LIKE '{$mot}%' LIMIT 5";
            $res = $this->pdo->query($req);
            $donnes = $res->fetchAll();
            foreach ($donnes as $val) {
                echo "<div class=nom value=" . $val['token'] . ">" . $val['username'] . "</div></a>";
            }
        } else {
            return false;
        }
    }

    public function insert_message($contenu, $destinataire, $expediteur)
    {
        $req = "SELECT id_user FROM user WHERE token = '{$expediteur}'";
        $req2 = "SELECT id_user FROM user WHERE token = '{$destinataire}'";
        $res = $this->pdo->query($req);
        $res2 = $this->pdo->query($req2);
        $donnes = $res->fetchAll();
        $donnes2 = $res2->fetchAll();

        $req = $this->pdo->prepare("INSERT INTO message_prive (contenu,id_destinataire,id_expediteur,date_message_prive) VALUES (:msg, :id_d, :id_e, NOW())");
        $req->execute(array(
            'msg' => $contenu,
            'id_d' => $donnes[0]["id_user"],
            'id_e' => $donnes2[0]["id_user"]
        ));
    }

    public function affichage_message($expediteur, $destinataire)
    {

        $req = "SELECT id_user FROM user WHERE token = '{$destinataire}' OR token = '{$expediteur}'";
        $res = $this->pdo->query($req);
        $donnes = $res->fetchAll();

        $u1 = $donnes[1][0];
        $u2 = $donnes[0][0];
        $sql = "SELECT user.username, message_prive.contenu, user.arobase, message_prive.date_message_prive FROM message_prive INNER JOIN user ON user.id_user = message_prive.id_destinataire
        WHERE (message_prive.id_expediteur = '{$u1}' 
        AND message_prive.id_destinataire = '{$u2}') 
        OR ( message_prive.id_expediteur = '{$u2}' 
        AND message_prive.id_destinataire = '{$u1}') 
        ORDER BY id_message DESC";

        $req = $this->pdo->query($sql);
        $donnes = $req->fetchAll();
        if ($donnes[0]['username'] == "") {
            echo "<p style=text-align:center>Pas de discussion en cours</p>";
        }
        foreach ($donnes as $val) {
            echo "<div class='container'><div class='container_header'><div class='photo'></div><div class='usr_name'><div class='username'>".$val['username']."</div><div class='arobase'>".$val['arobase']."</div></div></div><div class='container_body'><div class='contenu_tweet'>".$val['contenu']."</div><div class='date_tweet'>".$val['date_tweet']."</div></div></div>";
        }
    }
}