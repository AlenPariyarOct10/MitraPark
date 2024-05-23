<?php
    include_once "db_connection.php";
    // ALEN : If available seconds is less than or equal to 0 : redirect to strict mode page 

if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];
    $checkStrictMode = "SELECT * FROM `strict_mode` WHERE `uid`='$uid' AND `strictMode`='1'";

    $result = mysqli_query($connection, $checkStrictMode);
    $result = mysqli_fetch_assoc($result);



    if(($result != null)&&($result['availableAccessSeconds']<=0))
    {
        header("Location: strict-mode-timeout.php");
    }
    
    

    ?>