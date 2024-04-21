<?php
       include_once("../../../server/db_connection.php");
       if(session_status()!=PHP_SESSION_ACTIVE){
           session_start();
       }
   
       if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['post_id']))
       {
        $post_id = htmlspecialchars($_POST['post_id']);

        $restrictedStatus = "SELECT `status` FROM `posts` WHERE post_id='$post_id'";
        $restrictedStatus = mysqli_query($connection, $restrictedStatus);
        $restrictedStatus = mysqli_fetch_assoc($restrictedStatus);

        echo json_encode($restrictedStatus);
       }
?>