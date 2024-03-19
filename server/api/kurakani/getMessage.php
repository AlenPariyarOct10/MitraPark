<?php

    include_once("../../../parts/entryCheck.php");
    include_once("../../db_connection.php");
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }


    $uid = $_SESSION['user']['uid'];
    $receiverId = $_POST['receipientId'];

    $getMessageQuery = "SELECT * FROM `messages` WHERE `sender_id`='$uid' AND `receiver_id`='$receiverId' OR `sender_id`='$receiverId' AND `receiver_id`='$uid'";

    $result = mysqli_query($connection, $getMessageQuery);

    echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
    
  

    


?>
