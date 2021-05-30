<?php
require_once '../model/profil.php';

if ( isset( $_POST['token_info_user'] ) )
{
    $token = $_POST['token_info_user'];
    $db = new Info_profil();
    $db->connect_to_db();
    $result = $db->info_user( $token );
    print_r( json_encode( $result ) );
}

if ( isset( $_POST['token_follow'] ) )
{
    $token = $_POST['token_follow'];
    $db = new Info_profil();
    $db->connect_to_db();
    $result = $db->get_user_follow( $token );
    print_r( json_encode( $result ) );
}

if ( isset( $_POST['token_follower'] ) )
{
    $token = $_POST['token_follower'];
    $db = new Info_profil();
    $db->connect_to_db();
    $result = $db->get_user_follower( $token );
    print_r( json_encode( $result ) );
}

if(isset($_POST['token_tweet'])) {
    $db = New Info_profil;
    $db->connect_to_db();
    $tweet = $db->get_user_tweet($_POST['token_tweet']);
    $Json_tweet = json_encode($tweet);
    echo $Json_tweet;
}

if(isset($_POST['token_media'])) {
    $db = New Info_profil;
    $db->connect_to_db();
    $tweet = $db->get_user_tweet_image($_POST['token_media']);
    $Json_tweet = json_encode($tweet);
    echo $Json_tweet;
}

if(isset($_POST['token_jaime'])) {
    $db = New Info_profil;
    $db->connect_to_db();
    $tweet = $db->get_user_like($_POST['token_jaime']);
    $Json_tweet = json_encode($tweet);
    echo $Json_tweet;
}