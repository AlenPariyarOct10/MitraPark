<?php
session_start();
include_once("../db_connection.php");
include_once("../functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user']['uid'])) {
        $uid = $_SESSION['user']['uid'];
        $postId = $_POST['postId'];
        $commentAuthor = $_POST['commentAuthor'];
        $commentText = htmlspecialchars($_POST['commentContent']);
        if($commentText!="")
        {
            
            $insertComment = "INSERT INTO `comments`(`comment_by`, `content`, `created_date_time`, `post_id`) VALUES ('$commentAuthor','$commentText',NOW(),'$postId')";
            $insertCommentStatus = mysqli_query($connection, $insertComment);
            addNotification("comment",$postId,$uid);
             
        }

        
    } else {
        echo "User not logged in.";
    }
}
?>


