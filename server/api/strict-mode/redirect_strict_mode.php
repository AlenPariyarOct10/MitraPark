<?php
if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];
    $checkStrictMode = "SELECT * FROM `strict_mode` WHERE `endStrictDate`=CURDATE() AND `uid`='$uid'";

    $result = mysqli_query($connection, $checkStrictMode);
    $result = mysqli_fetch_assoc($result);

    if(($result != null)&&($result['availableAccessSeconds']<=0))
    {
        header("Location: strict-mode-timeout.php");
    }
    
    

    ?>