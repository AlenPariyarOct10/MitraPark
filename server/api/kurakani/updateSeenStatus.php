<?php

    include_once("../../../parts/entryCheck.php");
    include_once("../../db_connection.php");
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];
    $senderId = $_POST['senderId'];

    $setSeen = "UPDATE `messages` SET `seen_status`=1 WHERE `sender_id`='$senderId' AND `receiver_id`='$uid'";
   
    $result = mysqli_query($connection, $setSeen);

    if($result)
    {
        echo json_encode(array("status"=>"success"));
    }else{
        echo json_encode(array("status"=>"failed"));
    }
    
?>
