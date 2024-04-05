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
    $getChatRecord = "SELECT * FROM `chat_history` WHERE `chat_history_of`='$uid' AND `chat_with`='$receiverId' OR  `chat_history_of`='$receiverId' AND `chat_with`='$uid'";
    $getChatRecord = mysqli_query($connection, $getChatRecord);
    $getChatRecord = mysqli_fetch_assoc($getChatRecord);

    // If not existint product insert into chatHistoryOf
    if($getChatRecord != null)
    {
        $history = "UPDATE `chat_history` SET `last_updated`=now() WHERE `chat_history_of`='$uid' AND `chat_with`='$receiverId' OR  `chat_history_of`='$receiverId' AND `chat_with`='$uid'";
        
    }else{
        $history = "INSERT INTO `chat_history` (`chat_history_of`, `chat_with`, `last_updated`)VALUES('$uid', '$receiverId', NOW())";
        
    }
    $result = mysqli_query($connection, $history);

    if($result)
    {
        echo json_encode(array("status"=>"success"));
    }else{
        echo json_encode(array("status"=>"failed"));
    }
    
?>
