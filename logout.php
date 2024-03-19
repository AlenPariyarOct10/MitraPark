<?php
    if(session_status()==PHP_SESSION_ACTIVE)
    {
        echo "<script>localStorage.removeItem('mp-uid')</script>";
        session_destroy();
    }else{
        header("Location: login.php");
    }
    
?>