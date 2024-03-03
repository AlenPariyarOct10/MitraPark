<?php
if (isset($_POST)) {
    include_once("../db_connection.php");
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once("../db_connection.php");
    var_dump($_POST);
    var_dump($_SESSION['user']['uid']);

    $selectAll = "SELECT * FROM likes WHERE post_id='{$_POST['postId']}'";

    $result = $connection->query($selectAll);

    if(mysqli_affected_rows($connection)==0)
    {
        $insertLike = "INSERT INTO `likes`(`post_id`, `liked_by`, `created_date_time`) VALUES ('{$_POST['postId']}','{$_SESSION['user']['uid']}',now())";
        $connection->query($insertLike);
    }else{
        $deleteLike = 'DELETE FROM `likes` WHERE 0=';
    }
    var_dump(mysqli_fetch_array($result));
    
    
   

}
?>