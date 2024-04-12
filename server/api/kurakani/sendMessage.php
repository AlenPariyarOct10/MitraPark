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
    $dateTime = Date("Y-m-d H-i-s");


    $insertMessageQuery = "INSERT INTO `messages`(`sender_id`, `receiver_id`, `message_text`, `sent_datetime`) VALUES ('$uid','$receiverId','$message','$dateTime')"; 
    $result = mysqli_query($connection, $insertMessageQuery);

    if($result)
    {
        echo json_encode(array("status"=>"success"));
    }else{
        echo json_encode(array("status"=>"failed"));
    }
    
  

    


?>
