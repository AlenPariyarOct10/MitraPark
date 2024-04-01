<?php
session_start();
include_once("../../db_connection.php");

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user']['uid'])) {
        $replyCommentId = $_POST['reply_comment_id'];

        if ($replyCommentId) {
            $replyCommentId = mysqli_real_escape_string($connection, $replyCommentId);
  
            $checkAuthorQuery = "SELECT * FROM reply_comments WHERE reply_comment_id = '$replyCommentId' AND comment_author = '{$_SESSION['user']['uid']}'";
            $checkAuthorResult = mysqli_query($connection, $checkAuthorQuery);

            if (mysqli_num_rows($checkAuthorResult) > 0) {
                $deleteReplyCommentQuery = "DELETE FROM reply_comments WHERE reply_comment_id = '$replyCommentId'";
                $deleteReplyCommentResult = mysqli_query($connection, $deleteReplyCommentQuery);

                if ($deleteReplyCommentResult) {
                    echo json_encode(array("success" => true));
                } else {
                    echo json_encode(array("success" => false, "message" => "Failed to delete reply comment"));
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Unauthorized to delete reply comment"));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Missing required fields"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "User not logged in"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}

mysqli_close($connection);
?>
