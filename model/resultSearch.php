<?php

require_once 'bdd.php';

class Result extends MyDatabase
{

    public function checkResult($key)
    {
        header('Location: ./../view/html/result.php?k=' . urlencode($key));
    }

    public function get_user_tweet($tokenFromSearch, $tokenUser){

        $stmt = $this->pdo->prepare("SELECT S.username, S.arobase, S.image_url, S.contenu, S.url_image, S.date_tweet, S.id_user, S.id_post, GROUP_CONCAT(S.l) AS 'Nombre like', GROUP_CONCAT(S.r) AS 'Nombre retweet', GROUP_CONCAT(S.user_like) AS 'User like', GROUP_CONCAT(S.user_retweet) AS 'User retweet' 
        FROM
        (SELECT tweet.id_user, tweet.id_post, user.username, user.arobase, photo_de_profil.image_url, tweet.contenu, images.url_image, tweet.date_tweet, 
        COUNT(like_tweet.`id_like`) AS l, Null AS r, 
        IF (FIND_IN_SET ((SELECT id_user FROM user WHERE token LIKE :tokenUser) , GROUP_CONCAT(like_tweet.`id_user`)) , 'oui', 'non') as 'user_like', Null AS 'user_retweet'
        FROM `tweet`
        INNER JOIN user ON tweet.id_user = user.id_user
        LEFT JOIN like_tweet ON tweet.id_post = like_tweet.`id_post`
        LEFT JOIN photo_de_profil on user.id_user = photo_de_profil.id_user
        LEFT JOIN images on images.id_post = tweet.id_post
        WHERE user.token LIKE :tokenFromSearch AND user.active LIKE 1
        GROUP BY tweet.id_post
        UNION
        SELECT tweet.id_user, tweet.id_post, user.username, user.arobase, photo_de_profil.image_url, tweet.contenu, images.url_image, tweet.date_tweet, Null AS l , 
        COUNT(retweet.id_retweet) AS r, Null as 'user_like', 
        IF (FIND_IN_SET ((SELECT id_user FROM user WHERE token LIKE :tokenUser) , GROUP_CONCAT(retweet.`id_user`)) , 'oui', 'non') AS 'user_retweet'
        FROM `tweet`
        INNER JOIN user ON tweet.id_user = user.id_user
        LEFT JOIN retweet ON tweet.id_post = retweet.`id_post`
        LEFT JOIN photo_de_profil on user.id_user = photo_de_profil.id_user
        LEFT JOIN images on images.id_post = tweet.id_post
        WHERE user.token LIKE :tokenFromSearch AND user.active LIKE 1
        GROUP BY tweet.id_post) AS S
        GROUP BY S.id_post
        ORDER BY `S`.`date_tweet` DESC");
        $stmt->bindParam(':tokenFromSearch', $tokenFromSearch);
        $stmt->bindParam(':tokenUser', $tokenUser);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function get_user_info($tokenFromSearch, $tokenUserFollow){

        $sql = $this->pdo->prepare( "SELECT user.username, user.arobase, user.biographie, user.localisation, photo_de_profil.image_url, cover.cover_url,
        IF (FIND_IN_SET ((SELECT id_user FROM user WHERE token LIKE :tokenUserFollow) , GROUP_CONCAT(follow.id_follower)) , 'oui','non') AS 'follow',
        (SELECT COUNT(follow.id_follower) FROM follow INNER JOIN user ON follow.id_follower = user.id_user WHERE token = :tokenFromSearch AND active = 1) AS 'following',
        (SELECT COUNT(follow.id_follow) FROM follow INNER JOIN user ON follow.id_follow = user.id_user WHERE token = :tokenFromSearch AND active = 1) AS 'follower'
        FROM user 
        INNER JOIN photo_de_profil ON photo_de_profil.id_user = user.id_user
        INNER JOIN cover on cover.id_user = user.id_user
        LEFT JOIN follow ON follow.id_follow = user.id_user
        WHERE token=:tokenFromSearch AND active = 1
        GROUP BY id_follow" );
        $sql->bindParam( ':tokenFromSearch', $tokenFromSearch );
        $sql->bindParam( ':tokenUserFollow', $tokenUserFollow );

        $sql->execute();
        $result = $sql->fetch();
        echo json_encode($result);
    }
}
