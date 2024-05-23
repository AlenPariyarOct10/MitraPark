<?php
include_once('../../db_connection.php');

    if($_SERVER['REQUEST_METHOD']==="POST")
    {
        session_start();
        $uid = $_SESSION['user']['uid'];
        $deleteNotifications = "DELETE FROM `notifications` WHERE `author_id`='$uid'";
        $deleteNotifications = mysqli_query($connection, $deleteNotifications);
        
        if(mysqli_affected_rows($connection)>0)
        {
            echo json_encode(true);
        }else{
            echo json_encode(false);

        }
    }
?>