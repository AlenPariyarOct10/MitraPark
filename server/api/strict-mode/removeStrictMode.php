<?php

    // ALEN : Checking if strict mode exists 
    include_once "../../db_connection.php";
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];
    $checkStrictMode = "SELECT * FROM `strict_mode` WHERE `endStrictDate`=CURDATE() AND `uid`='$uid'";
    $result = mysqli_query($connection, $checkStrictMode);
    $result = mysqli_fetch_assoc($result);
    
    if($result != null)
    {
        $removeStrictMode = "UPDATE `strict_mode` SET `strictMode`=0, `autoRenew`=0 WHERE `uid`='$uid'";
        mysqli_query($connection, $removeStrictMode);
        header("Location: /MitraPark/index.php");
    }

?>