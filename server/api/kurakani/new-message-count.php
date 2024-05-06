<?php
    include_once("../../../parts/entryCheck.php");
    include_once("../../db_connection.php");

    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];

    $getMessageQuery = "SELECT count(`receiver_id`) as messages_count FROM `messages` WHERE `receiver_id`='$uid' AND `seen_status`='0'";

    $result = mysqli_query($connection, $getMessageQuery);

    echo json_encode(mysqli_fetch_assoc($result));
?>