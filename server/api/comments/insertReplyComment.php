<?php
session_start();
include_once("../../db_connection.php");


header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user']['uid'])) {
       
        $uid = $_SESSION['user']['uid'];
        $parentCommentId = $_POST['parent_comment_id'];
        $commentAuthor = $_POST['comment_author'];
        $commentContent = htmlspecialchars($_POST['comment_content']);
        
        if ($parentCommentId && $commentAuthor && $commentContent) {
         
            $parentCommentId = mysqli_real_escape_string($connection, $parentCommentId);
            $commentAuthor = mysqli_real_escape_string($connection, $commentAuthor);
            $commentContent = mysqli_real_escape_string($connection, $commentContent);
            $dateTime = Date("Y-m-d H-i-s");

  
            $insertReplyCommentQuery = "INSERT INTO reply_comments (parent_comment_id, comment_author, created_timestamp, comment_content) VALUES ('$parentCommentId', '$commentAuthor', '$dateTime, '$commentContent')";
            $insertReplyCommentResult = mysqli_query($connection, $insertReplyCommentQuery);

            if ($insertReplyCommentResult) {
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false));
            }
        } else {
            echo json_encode(array("success" => false));
        }
    } else {
        echo json_encode(array("success" => false));
    }
} else {
    echo json_encode(array("success" => true));
}

mysqli_close($connection);
?>
