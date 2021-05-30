<?php
require_once "bdd.php";

class Tweet extends MyDatabase {

    public function tweet_text($content, $token){
        $stmt = $this->pdo->prepare("INSERT INTO `tweet`(`id_user`, `contenu`, `date_tweet`) 
        VALUES ((SELECT  id_user FROM user WHERE token = :token) , :content, NOW())");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':content', $content);
        $stmt->execute();

    }

    public function tweet_image($image_url, $token){
        $stmt = $this->pdo->prepare("INSERT INTO `tweet`(`id_user`, `contenu`, `date_tweet`) 
        VALUES ((SELECT  id_user FROM user WHERE token = :token) , '', NOW());
        INSERT INTO `images`(`id_post`, `url_image`) VALUES ((SELECT LAST_INSERT_ID()), :image_url);");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->execute();
    }

    public function tweet_text_image($image_url, $token, $content){
        $stmt = $this->pdo->prepare("INSERT INTO `tweet`(`id_user`, `contenu`, `date_tweet`) 
        VALUES ((SELECT  id_user FROM user WHERE token = :token) , :content, NOW());
        INSERT INTO `images`(`id_post`, `url_image`) VALUES ((SELECT LAST_INSERT_ID()), :image_url);");
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
    }

    public function get_user_tweet($token){

        $stmt = $this->pdo->prepare("SELECT S.username, S.arobase, S.image_url, S.contenu, S.url_image, S.date_tweet, S.id_user, S.id_post, GROUP_CONCAT(S.l) AS 'Nombre like', GROUP_CONCAT(S.r) AS 'Nombre retweet', GROUP_CONCAT(S.user_like) AS 'User like', GROUP_CONCAT(S.user_retweet) AS 'User retweet' 
        FROM
        (SELECT tweet.id_user, tweet.id_post, user.username, user.arobase, photo_de_profil.image_url, tweet.contenu, images.url_image, tweet.date_tweet, 
        COUNT(like_tweet.`id_like`) AS l, Null AS r, 
        IF (FIND_IN_SET ((SELECT id_user FROM user WHERE token LIKE :token) , GROUP_CONCAT(like_tweet.`id_user`)) , 'oui', 'non') AS 'user_like', Null AS 'user_retweet'        FROM `tweet`
        INNER JOIN user ON tweet.id_user = user.id_user
        LEFT JOIN like_tweet ON tweet.id_post = like_tweet.`id_post`
        LEFT JOIN photo_de_profil on user.id_user = photo_de_profil.id_user
        LEFT JOIN images on images.id_post = tweet.id_post
        WHERE user.token LIKE :token OR user.id_user IN (SELECT id_follow FROM `follow` INNER JOIN user ON id_follower = id_user WHERE token LIKE :token) AND user.active LIKE 1
        GROUP BY tweet.id_post
        UNION
        SELECT tweet.id_user, tweet.id_post, user.username, user.arobase, photo_de_profil.image_url, tweet.contenu, images.url_image, tweet.date_tweet, Null AS l , 
        COUNT(retweet.id_retweet) AS r, Null as 'user_like', 
        IF (FIND_IN_SET ((SELECT id_user FROM user WHERE token LIKE :token) , GROUP_CONCAT(retweet.`id_user`)) , 'oui', 'non') AS 'user_retweet'
        FROM `tweet`
        INNER JOIN user ON tweet.id_user = user.id_user
        LEFT JOIN retweet ON tweet.id_post = retweet.`id_post`
        LEFT JOIN photo_de_profil on user.id_user = photo_de_profil.id_user
        LEFT JOIN images on images.id_post = tweet.id_post
        WHERE user.token LIKE :token OR user.id_user IN (SELECT id_follow FROM `follow` INNER JOIN user ON id_follower = id_user WHERE token LIKE :token) AND user.active LIKE 1
        GROUP BY tweet.id_post) AS S
        GROUP BY S.id_post
        ORDER BY `S`.`date_tweet` DESC");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get_user_photo($token){
        $stmt = $this->pdo->prepare("SELECT image_url FROM `photo_de_profil` 
        INNER JOIN user ON photo_de_profil.id_user = user.id_user 
        WHERE token LIKE :token AND active LIKE 1");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}