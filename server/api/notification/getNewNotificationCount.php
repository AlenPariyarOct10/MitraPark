<?php
    if(session_status() != PHP_SESSION_ACTIVE)
    {
        session_start();
    }
    include_once("../../db_connection.php");
    $uid = $_SESSION['user']['uid'];
    $getNewNotificationsCount = "SELECT count(`seen_status`) as unseen FROM `notifications` WHERE `author_id`='$uid' AND `seen_status`='0'";
    $result = mysqli_query($connection, $getNewNotificationsCount);
    $notificationCount = mysqli_fetch_assoc($result);
    echo json_encode($notificationCount);
?>