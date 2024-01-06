<?php

    include_once("db_connection.php");

    $params = json_decode(file_get_contents("php://input"),true);

    $uid = $params['uid'];
    $mediaType = $params['mediaType'];

    $selectMediaQuery = "SELECT * FROM `mp_media` WHERE `author_id`='$uid' AND `media_type`='$mediaType'";
    
    if($mediaType == "profile")
    {
        $image = $connection->query($selectMediaQuery);
        $image = $image->fetch_all(MYSQLI_ASSOC);
        print_r(json_encode($image));
    }
    





?>