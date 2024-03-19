<?php

    include_once("../../../parts/entryCheck.php");
    include_once("../../db_connection.php");
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];

    $uid = $_SESSION['user']['uid'];
    $threshold = strtotime("-5000 minutes");
    $getMitras = "SELECT f.sender_id, f.acceptor_id, u.uid, concat(u.fname,' ',u.lname) as uname, u.profile_picture FROM `friends` f INNER JOIN `users` u ON u.uid = f.acceptor_id OR u.uid = f.sender_id";

    $result = mysqli_query($connection, $getMitras);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($result);
  

    


?>
