<?php

require_once 'bdd.php';

class Info_profil extends MyDatabase
{
    public function info_user( $token )
    {
        $sql = $this->pdo->prepare( "SELECT user.username, user.arobase, user.biographie, user.localisation, photo_de_profil.image_url, cover.cover_url, 
        (SELECT COUNT(follow.id_follower) FROM follow INNER JOIN user ON follow.id_follower = user.id_user WHERE token = :token AND active = 1) AS 'following',
        (SELECT COUNT(follow.id_follow) FROM follow INNER JOIN user ON follow.id_follow = user.id_user WHERE token = :token AND active = 1) AS 'follower'
        FROM user 
        INNER JOIN photo_de_profil ON photo_de_profil.id_user = user.id_user
        INNER JOIN cover ON cover.id_user = user.id_user
        WHERE token = :token AND active = 1" );
        $sql->bindParam( ':token', $token );
        $sql->execute();
        $result = $sql->fetch();

        return $result;
    }

    public function modif_info_user( $token, $pseudo, $biographie, $localisation )
    {
        try {
            $sql = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token AND active = 1" );
            $sql->bindParam( ':token', $token );
            $sql->execute();
            $id_user = $sql->fetch();
            $sql_    = $this->pdo->prepare( "UPDATE user SET username = :pseudo, localisation=:localisation, biographie=:biographie WHERE id_user=:id_user" );
            $sql_->bindParam( ':id_user', $id_user[0] );
            $sql_->bindParam( ':pseudo', $pseudo );
            $sql_->bindParam( ':localisation', $localisation );
            $sql_->bindParam( ':biographie', $biographie );
            $sql_->execute();

            return 1;
        }
        catch ( PDOException $e )
        {
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function add_like_user( $token, $id_post )
    {
        try {
            $sql = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token AND active = 1" );
            $sql->bindParam( ':token', $token );
            $sql->execute();
            $id_user = $sql->fetch();
            $sql_    = $this->pdo->prepare( "INSERT INTO like_tweet(id_post,id_user) VALUES (:id_post,:id_user)" );
            $sql_->bindParam( ':id_post', $id_post );
            $sql_->bindParam( ':id_user', $id_user[0] );
            $sql_->execute();

            return 1;
        }
        catch ( PDOException $e )
        {
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function delete_like_user( $token, $id_post )
    {
        try {
            $sql = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token AND active = 1" );
            $sql->bindParam( ':token', $token );
            $sql->execute();
            $id_user = $sql->fetch();
            $sql_    = $this->pdo->prepare( "DELETE FROM like_tweet WHERE id_post=:id_post AND id_user=:id_user" );
            $sql_->bindParam( ':id_post', $id_post );
            $sql_->bindParam( ':id_user', $id_user[0] );
            $sql_->execute();

            return 1;
        }
        catch ( PDOException $e )
        {
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function add_retweet_user( $token, $id_post )
    {
        try {
            $sql = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token AND active = 1" );
            $sql->bindParam( ':token', $token );
            $sql->execute();
            $id_user = $sql->fetch();
            $sql_    = $this->pdo->prepare( "INSERT INTO retweet(id_post,id_user,date_retweet) VALUES (:id_post,:id_user,NOW())" );
            $sql_->bindParam( ':id_post', $id_post );
            $sql_->bindParam( ':id_user', $id_user[0] );
            $sql_->execute();

            return 1;
        }
        catch ( PDOException $e )
        {
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function delete_retweet_user( $token, $id_post )
    {
        try {
            $sql = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token AND active = 1" );
            $sql->bindParam( ':token', $token );
            $sql->execute();
            $id_user = $sql->fetch();
            $sql_    = $this->pdo->prepare( "DELETE FROM retweet WHERE id_post=:id_post AND id_user=:id_user" );
            $sql_->bindParam( ':id_post', $id_post );
            $sql_->bindParam( ':id_user', $id_user[0] );
            $sql_->execute();

            return 1;
        }
        catch ( PDOException $e )
        {
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function upload_user_cover( $token, $cover_url )
    {
        $stmt = $this->pdo->prepare( "UPDATE `cover` SET `cover_url` = :cover_url
        WHERE id_user LIKE (SELECT id_user FROM user WHERE token LIKE :token AND active LIKE 1)" );
        $stmt->bindParam( ':token', $token );
        $stmt->bindParam( ':cover_url', $cover_url );
        $stmt->execute();
    }

    public function upload_user_photo( $token, $photo_url )
    {
        $stmt = $this->pdo->prepare( "UPDATE `photo_de_profil` SET `image_url` = :photo_url
        WHERE id_user LIKE (SELECT id_user FROM user WHERE token LIKE :token AND active LIKE 1)" );
        $stmt->bindParam( ':token', $token );
        $stmt->bindParam( ':photo_url', $photo_url );
        $stmt->execute();
    }

    public function get_user_tweet( $token )
    {
        $stmt = $this->pdo->prepare( "SELECT S.username, S.arobase, S.image_url, S.contenu, S.url_image, S.date_tweet, S.id_user, S.id_post, GROUP_CONCAT(S.l) AS 'Nombre like', GROUP_CONCAT(S.r) AS 'Nombre retweet', GROUP_CONCAT(S.user_like) AS 'User like', GROUP_CONCAT(S.user_retweet) AS 'User retweet'
        FROM
        (SELECT tweet.id_user, tweet.id_post, user.username, user.arobase, photo_de_profil.image_url, tweet.contenu, images.url_image, tweet.date_tweet,
        COUNT(like_tweet.`id_like`) AS l, Null AS r,
        IF (FIND_IN_SET ((SELECT id_user FROM user WHERE token LIKE :token) , GROUP_CONCAT(like_tweet.`id_user`)) , 'oui', 'non') as 'user_like', Null AS 'user_retweet'
        FROM `tweet`
        INNER JOIN user ON tweet.id_user = user.id_user
        LEFT JOIN like_tweet ON tweet.id_post = like_tweet.`id_post`
        LEFT JOIN photo_de_profil on user.id_user = photo_de_profil.id_user
        LEFT JOIN images on images.id_post = tweet.id_post
        WHERE user.token LIKE :token AND user.active LIKE 1
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
        WHERE user.token LIKE :token AND user.active LIKE 1
        GROUP BY tweet.id_post) AS S
        GROUP BY S.id_post
        ORDER BY `S`.`date_tweet` DESC" );
        $stmt->bindParam( ':token', $token );
        $stmt->execute();
        $tweet = $stmt->fetchAll( PDO::FETCH_ASSOC );

        return $tweet;
    }

    public function get_user_tweet_image( $token )
    {
        $stmt = $this->pdo->prepare( "SELECT S.username, S.arobase, S.image_url, S.contenu, S.url_image, S.date_tweet, S.id_user, S.id_post, GROUP_CONCAT(S.l) AS 'Nombre like', GROUP_CONCAT(S.r) AS 'Nombre retweet', GROUP_CONCAT(S.user_like) AS 'User like', GROUP_CONCAT(S.user_retweet) AS 'User retweet'
        FROM
        (SELECT tweet.id_user, tweet.id_post, user.username, user.arobase, photo_de_profil.image_url, tweet.contenu, images.url_image, tweet.date_tweet,
        COUNT(like_tweet.`id_like`) AS l, Null AS r,
        IF (FIND_IN_SET ((SELECT id_user FROM user WHERE token LIKE :token) , GROUP_CONCAT(like_tweet.`id_user`)) , 'oui', 'non') as 'user_like', Null AS 'user_retweet'
        FROM `tweet`
        INNER JOIN user ON tweet.id_user = user.id_user
        LEFT JOIN like_tweet ON tweet.id_post = like_tweet.`id_post`
        LEFT JOIN photo_de_profil on user.id_user = photo_de_profil.id_user
        LEFT JOIN images on images.id_post = tweet.id_post
        WHERE user.token LIKE :token AND user.active LIKE 1 AND images.url_image IS NOT NULL
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
        WHERE user.token LIKE :token AND user.active LIKE 1 AND images.url_image IS NOT NULL
        GROUP BY tweet.id_post) AS S
        GROUP BY S.id_post
        ORDER BY `S`.`date_tweet` DESC" );
        $stmt->bindParam( ':token', $token );
        $stmt->execute();
        $tweet = $stmt->fetchAll( PDO::FETCH_ASSOC );

        return $tweet;
    }

    public function get_user_like( $token )
    {
        $stmt = $this->pdo->prepare( "SELECT S.username, S.arobase, S.image_url, S.contenu, S.url_image, S.date_tweet, S.id_user, S.id_post, GROUP_CONCAT(S.l) AS 'Nombre like', GROUP_CONCAT(S.r) AS 'Nombre retweet', GROUP_CONCAT(S.user_like) AS 'User like', GROUP_CONCAT(S.user_retweet) AS 'User retweet'
        FROM
        (SELECT tweet.id_user, tweet.id_post, user.username, user.arobase, photo_de_profil.image_url, tweet.contenu, images.url_image, tweet.date_tweet,
         COUNT(like_tweet.`id_like`) AS l,
         Null AS r,
        IF (FIND_IN_SET ((SELECT id_user FROM user WHERE token LIKE :token) , GROUP_CONCAT(like_tweet.`id_user`)) , 'oui', 'non') AS 'user_like', Null AS 'user_retweet'
        FROM `tweet`
        INNER JOIN user ON tweet.id_user = user.id_user
        LEFT JOIN like_tweet ON tweet.id_post = like_tweet.`id_post`
        LEFT JOIN photo_de_profil on user.id_user = photo_de_profil.id_user
        LEFT JOIN images on images.id_post = tweet.id_post
        WHERE tweet.id_post IN (SELECT id_post FROM `like_tweet` INNER JOIN user ON user.id_user = like_tweet.id_user WHERE user.token LIKE :token)
        GROUP BY tweet.id_post
        UNION
        SELECT tweet.id_user, tweet.id_post, user.username, user.arobase, photo_de_profil.image_url, tweet.contenu, images.url_image, tweet.date_tweet, Null AS l ,
        COUNT(retweet.id_retweet) AS r,
        Null as 'user_like',
        IF (FIND_IN_SET ((SELECT id_user FROM user WHERE token LIKE :token) , GROUP_CONCAT(retweet.`id_user`)) , 'oui', 'non') AS 'user_retweet'
        FROM `tweet`
        INNER JOIN user ON tweet.id_user = user.id_user
        LEFT JOIN retweet ON tweet.id_post = retweet.`id_post`
        LEFT JOIN photo_de_profil on user.id_user = photo_de_profil.id_user
        LEFT JOIN images on images.id_post = tweet.id_post
        WHERE tweet.id_post IN (SELECT id_post FROM `like_tweet` INNER JOIN user ON user.id_user = like_tweet.id_user WHERE user.token LIKE :token AND user.active LIKE 1)
        GROUP BY tweet.id_post) AS S
        GROUP BY S.id_post
        ORDER BY `S`.`date_tweet` DESC" );
        $stmt->bindParam( ':token', $token );
        $stmt->execute();
        $tweet = $stmt->fetchAll( PDO::FETCH_ASSOC );

        return $tweet;
    }

    public function reply_info( $id_post )
    {
        $sql = $this->pdo->prepare( "SELECT user.username, user.arobase, reply.contenu, reply.date_reply, photo_de_profil.image_url FROM reply INNER JOIN user ON user.id_user = reply.id_user INNER JOIN photo_de_profil ON photo_de_profil.id_user = user.id_user WHERE id_post= :id_post" );
        $sql->bindParam( ':id_post', $id_post );
        $sql->execute();
        $result = $sql->fetchAll();

        return $result;
    }

    public function reply_publish( $id_post, $token, $textarea )
    {
        try {
            $sql = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token AND active = 1" );
            $sql->bindParam( ':token', $token );
            $sql->execute();
            $id_user = $sql->fetch();
            $sql_    = $this->pdo->prepare( "INSERT INTO reply(id_user,id_post, contenu, date_reply) VALUES (:id_user,:id_post,:contenu,NOW())" );
            $sql_->bindParam( ':id_user', $id_user[0] );
            $sql_->bindParam( ':id_post', $id_post );
            $sql_->bindParam( ':contenu', $textarea );
            $sql_->execute();

            return 1;
        }
        catch ( PDOException $e )
        {
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function reply_final( $id_post, $token )
    {
        try {
            $sql = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token AND active = 1" );
            $sql->bindParam( ':token', $token );
            $sql->execute();
            $id_user = $sql->fetch();
            $sql_    = $this->pdo->prepare( "SELECT user.username, user.arobase, reply.contenu, reply.date_reply, photo_de_profil.image_url FROM reply INNER JOIN user ON user.id_user = reply.id_user INNER JOIN photo_de_profil ON photo_de_profil.id_user = user.id_user WHERE reply.id_user = :id_user AND reply.id_post = :id_post ORDER BY reply.date_reply DESC LIMIT 1" );
            $sql_->bindParam( ':id_user', $id_user[0] );
            $sql_->bindParam( ':id_post', $id_post );
            $sql_->execute();
            $result = $sql_->fetch();

            return $result;
        }
        catch ( PDOException $e )
        {
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function add_follow( $token, $token_user )
    //token_user -> la personne a follow
    //token -> la personne qui follow
    {
        try {
            $sql1 = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token_user AND active = 1" );
            $sql1->bindParam( ':token_user', $token_user );
            $sql1->execute();
            $id_user_token_user = $sql1->fetch();
            $sql2               = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token AND active = 1" );
            $sql2->bindParam( ':token', $token );
            $sql2->execute();
            $id_user_token = $sql2->fetch();
            $sql3          = $this->pdo->prepare( "INSERT INTO follow(id_follow, id_follower) VALUES (:id_user1,:id_user2)" );
            $sql3->bindParam( ':id_user1', $id_user_token_user[0] );
            $sql3->bindParam( ':id_user2', $id_user_token[0] );
            $sql3->execute();

            return 1;
        }
        catch ( PDOException $e )
        {
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function delete_follow( $token, $token_user )
    //token_user -> la personne a follow
    //token -> la personne qui follow
    {
        try {
            $sql1 = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token_user AND active = 1" );
            $sql1->bindParam( ':token_user', $token_user );
            $sql1->execute();
            $id_user_token_user = $sql1->fetch();
            $sql2               = $this->pdo->prepare( "SELECT id_user FROM user WHERE token=:token AND active = 1" );
            $sql2->bindParam( ':token', $token );
            $sql2->execute();
            $id_user_token = $sql2->fetch();
            $sql3          = $this->pdo->prepare( "DELETE FROM follow WHERE id_follow = :id_user1 AND id_follower = :id_user2" );
            $sql3->bindParam( ':id_user1', $id_user_token_user[0] );
            $sql3->bindParam( ':id_user2', $id_user_token[0] );
            $sql3->execute();
            return 1;
        }
        catch ( PDOException $e )
        {
            return "Error :" . $e->getMessage() . "\n";
        }
    }

    public function get_user_follow($token) {

        $sql = $this->pdo->prepare( "SELECT user.username, user.arobase, user.biographie, user.localisation, photo_de_profil.image_url
        FROM user 
        INNER JOIN photo_de_profil ON photo_de_profil.id_user = user.id_user
        WHERE user.id_user IN (SELECT id_follow FROM `follow` INNER JOIN user ON user.id_user = follow.id_follower WHERE token LIKE :token) AND active = 1" );
        $sql->bindParam( ':token', $token );
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get_user_follower($token) {

        $sql = $this->pdo->prepare( "SELECT user.username, user.arobase, user.biographie, user.localisation, photo_de_profil.image_url
        FROM user 
        INNER JOIN photo_de_profil ON photo_de_profil.id_user = user.id_user
        WHERE user.id_user IN (SELECT id_follower FROM `follow` INNER JOIN user ON user.id_user = follow.id_follow WHERE token LIKE :token) AND active = 1" );
        $sql->bindParam( ':token', $token );
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}