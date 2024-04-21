<?php
       include_once("../../../server/db_connection.php");
       if(session_status()!=PHP_SESSION_ACTIVE){
           session_start();
       }
   
       if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['uid']))
       {
        $userId = htmlspecialchars($_POST['uid']);

        $restrictedStatus = "SELECT `status` FROM `users` WHERE uid='$userId'";
        $restrictedStatus = mysqli_query($connection, $restrictedStatus);
        $restrictedStatus = mysqli_fetch_assoc($restrictedStatus);

        echo json_encode($restrictedStatus);
       }
?>