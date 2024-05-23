<?php

if(session_status()!=PHP_SESSION_ACTIVE){session_start();};

include_once("../../db_connection.php");

$rawData = file_get_contents("php://input");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user']['uid']) || isset($_SESSION['loggedInAdmin'])) {
  
        $parentCommentId = $_POST['parentCommentId'];

        $selectAll = "SELECT fname, lname, created_timestamp, profile_picture, comment_content, uid, comment_author, reply_comment_id FROM reply_comments c INNER JOIN users u on u.uid=c.comment_author WHERE parent_comment_id = '$parentCommentId'";
        $result = mysqli_query($connection, $selectAll);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        echo json_encode($result);
    } else {
        echo "User not logged in.";
    }
}
?>
