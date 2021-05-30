<?php

require_once '../model/tweet.php';

function checkImage() {
    $maxSize = 500000;
    $validExt = array('.jpg', '.jpeg', '.png');
    if($_FILES['tweet_image']['error'] > 0) {
      return "error";
    }
    $fileSize = $_FILES['tweet_image']['size'];
    if ($maxSize < $fileSize) {
      return "error";
    }
    $fileExt = "." . strtolower(substr(strchr($_FILES['tweet_image']['name'], "."), 1));
    if(!in_array($fileExt, $validExt)) {
      return "error";
    }
}

if (isset($_POST['content']) && isset($_POST['token']) && !isset($_FILES['tweet_image']['name'])) {
    $db = new Tweet;
    $db->connect_to_db();
    $db->tweet_text($_POST['content'], $_POST['token']);
    return;
}

if(isset($_FILES['tweet_image']['name']) && isset($_POST['token']) && !isset($_POST['content'])) {
    if(checkImage() == "error") {
        echo "erreur";
        return;
    }
    $fileExt = "." . strtolower(substr(strchr($_FILES['tweet_image']['name'], "."), 1));
    $fileName = $_FILES['tweet_image']['name'];
    $tmpName = $_FILES['tweet_image']['tmp_name'];
    $uniqueName = md5(uniqid(rand(),true));
    $path = "../view/upload/image/";
    $localhostPath = "https://notestim.ddns.net/projets/tweeter/view/upload/image/";
    $fileName = $uniqueName . $fileExt;
    $result = move_uploaded_file($tmpName, $path.$fileName);
    $db = new Tweet;
    $db->connect_to_db();
    $db->tweet_image($localhostPath.$fileName, $_POST['token']);
}

if(isset($_FILES['tweet_image']['name']) && isset($_POST['token']) && isset($_POST['content'])) {
    if(checkImage() == "error") {
      echo "erreur";
      return;
    }
    $fileExt = "." . strtolower(substr(strchr($_FILES['tweet_image']['name'], "."), 1));
    $fileName = $_FILES['tweet_image']['name'];
    $tmpName = $_FILES['tweet_image']['tmp_name'];
    $uniqueName = md5(uniqid(rand(),true));
    $path = "../view/upload/image/";
    $localhostPath = "https://notestim.ddns.net/projets/view/upload/image/";
    $fileName = $uniqueName . $fileExt;
    $result = move_uploaded_file($tmpName, $path.$fileName);
    $db = new Tweet;
    $db->connect_to_db();
    $db->tweet_text_image($localhostPath.$fileName, $_POST['token'], $_POST['content']);
}

if(isset($_POST['get_tweet_token'])) {
    $db = new Tweet;
    $db->connect_to_db();
    $tweet = $db->get_user_tweet($_POST['get_tweet_token']);
    $tweetJson = json_encode($tweet);
    echo $tweetJson;
}

if(isset($_POST['get_photo_token'])) {
  $db = new Tweet;
  $db->connect_to_db();
  $photo = $db->get_user_photo($_POST['get_photo_token']);
  echo $photo['image_url'];
}
