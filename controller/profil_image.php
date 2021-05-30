<?php

require_once '../model/profil.php';

function checkImage($image) {
    $maxSize = 300000;
    $validExt = array('.jpg', '.jpeg', '.png');
    if($_FILES[$image]['error'] > 0) {
      return "error";
    }
    $fileSize = $_FILES[$image]['size'];
    if ($maxSize < $fileSize) {
      return "error";
    }
    $fileExt = "." . strtolower(substr(strchr($_FILES[$image]['name'], "."), 1));
    if(!in_array($fileExt, $validExt)) {
      return "error";
    }
}

function upload_image($image, $uploadPath) {
    $fileExt = "." . strtolower(substr(strchr($_FILES[$image]['name'], "."), 1));
    $fileName = $_FILES[$image]['name'];
    $tmpName = $_FILES[$image]['tmp_name'];
    $uniqueName = md5(uniqid(rand(),true));
    $path = "../view/upload/" . $uploadPath . "/";
    $localhostPath = "https://notestim.ddns.net/projets/tweeter/view/upload/" . $uploadPath . "/";
    $fileName = $uniqueName . $fileExt;
    $result = move_uploaded_file($tmpName, $path.$fileName);
    return $localhostPath.$fileName;
}

if(isset($_FILES['profil_cover']['name']) && isset($_POST['token'])) {
    if(checkImage('profil_cover') == "error") {
        echo "erreur";
        return;
    }
    $path = upload_image('profil_cover','cover');
    $db = New Info_profil;
    $db->connect_to_db();
    $db->upload_user_cover($_POST['token'], $path);
    echo $path;
}

if(isset($_FILES['profil_photo']['name']) && isset($_POST['token'])) {
    if(checkImage('profil_photo') == "error") {
        echo "erreur";
        return;
    }
    $path = upload_image('profil_photo','photo');
    $db = New Info_profil;
    $db->connect_to_db();
    $db->upload_user_photo($_POST['token'], $path);
    echo $path;
}
