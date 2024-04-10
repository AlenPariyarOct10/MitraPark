<?php
if(session_status()!=PHP_SESSION_ACTIVE)
{
  session_start();
}
 if($_SESSION['loggedInAdmin']!=true)
{

    session_destroy();
    header("Location: ../login.php");
}

?>