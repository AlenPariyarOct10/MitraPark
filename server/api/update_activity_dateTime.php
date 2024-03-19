<?php
    include_once "../db_connection.php";
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];
    $updateQuery = "UPDATE `users` SET `last_active_date_time`=now() WHERE `uid`='$uid'";
    mysqli_query($connection, $updateQuery);

    

?>