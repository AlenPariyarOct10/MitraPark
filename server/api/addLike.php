<?php
session_start();
include_once("../db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user']['uid'])) {
        $uid = $_SESSION['user']['uid'];
        $postId = $_POST['postId'];

        $selectAll = "SELECT * FROM likes WHERE post_id = ?";
        $stmt = $connection->prepare($selectAll);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $insertLike = "INSERT INTO `likes`(`post_id`, `liked_by`, `created_date_time`) VALUES (?, ?, now())";
            $stmt = $connection->prepare($insertLike);
            $stmt->bind_param("ii", $postId, $uid);
            $stmt->execute();
        } else {
            $deleteLike = 'DELETE FROM `likes` WHERE `liked_by` = ? AND `post_id` = ?';
            $stmt = $connection->prepare($deleteLike);
            $stmt->bind_param("ii", $uid, $postId);
            $stmt->execute();
        }
    } else {
        echo "User not logged in.";
    }
}
?>
