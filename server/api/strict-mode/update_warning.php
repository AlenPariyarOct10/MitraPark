<?php
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
       
            $updateQuery = "UPDATE `strict_mode` SET `getWarning`=0 WHERE `endStrictDate`=CURDATE() AND `uid`='$uid'";
            mysqli_query($connection, $updateQuery);
        
    }

    


?>