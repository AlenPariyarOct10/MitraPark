<?php
    include_once "../db_connection.php";
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];

    $dateTime = Date("Y-m-d H-i-s");

    $updateQuery = "UPDATE `users` SET `last_active_date_time`='$dateTime' WHERE `uid`='$uid'";
    mysqli_query($connection, $updateQuery);

    

?>