<?php
session_start();
include_once("../db_connection.php");
include_once("../functions.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user']['uid'])) {
        $uid = $_SESSION['user']['uid'];
        $postId = $_POST['postId'];

        $selectAll = "SELECT * FROM likes WHERE post_id = '$postId' AND liked_by = '$uid'";
        $result = mysqli_query($connection, $selectAll);
        $dateTime = Date("Y-m-d H-i-s");
        

        if (mysqli_num_rows($result) == 0) {
            $insertLike = "INSERT INTO `likes`(`post_id`, `liked_by`, `created_date_time`) VALUES ('$postId', '$uid', now())";
            $addLikeStatus = mysqli_query($connection, $insertLike);
            addNotification("like",$postId,$uid);
        } else {
            $deleteLike = "DELETE FROM `likes` WHERE `liked_by` = '$uid' AND `post_id` = '$postId'";
            $deleteLikeStatus = mysqli_query($connection, $deleteLike);
            removeNotification("like",$postId,$uid);
        }
    } else {
        echo "User not logged in.";
    }
}
?>
