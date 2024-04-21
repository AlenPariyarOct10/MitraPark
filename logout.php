<?php
session_start();
    if(session_status()==PHP_SESSION_ACTIVE)
    {
        echo "<script>localStorage.removeItem('mp-uid')</script>";
        session_unset();
        session_destroy();
        header("Location: login.php");

    }else{
        header("Location: login.php");
    }
    exit();
    
?>