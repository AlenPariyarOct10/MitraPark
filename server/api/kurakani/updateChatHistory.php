<?php

    include_once("../../../parts/entryCheck.php");
    include_once("../../db_connection.php");
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

   

    $uid = $_SESSION['user']['uid'];
    $receiverId = $_POST['receipientId'];
    $message = $_POST['msg'];

    // Check if record existis if exist just update the exisiting table
    $getChatRecord = "SELECT * FROM `chat_history` WHERE `user_1`='$uid' AND `user_2`='$receiverId' OR  `user_1`='$receiverId' AND `user_2`='$uid'";
    $getChatRecord = mysqli_query($connection, $getChatRecord);
    $getChatRecord = mysqli_fetch_assoc($getChatRecord);
    $dateTime = Date("Y-m-d H-i-s");


    if($getChatRecord != null)
    {
        $history = "UPDATE `chat_history` SET `last_updated`='$dateTime', `last_message`='$message', `sender_id`='$uid', `seen_status`=0 WHERE `user_1`='$uid' AND `user_2`='$receiverId' OR  `user_1`='$receiverId' AND `user_2`='$uid'";
        
    }else{
        $history = "INSERT INTO `chat_history` (`user_1`, `user_2`, `last_updated`, `last_message`, `sender_id`)VALUES('$uid', '$receiverId', '$dateTime','$message', '$uid')";
        
    }
    $result = mysqli_query($connection, $history);

    if($result)
    {
        echo json_encode(array("status"=>"success"));
    }else{
        echo json_encode(array("status"=>"failed"));
    }
    
?>
