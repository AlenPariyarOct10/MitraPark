<?php

if(session_status()!=PHP_SESSION_ACTIVE){session_start();};

include_once("../db_connection.php");
$rawData = file_get_contents("php://input");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user']['uid']) || isset($_SESSION['loggedInAdmin'])) {
        $postId = $_POST['postId'];

        $selectAll = "SELECT fname, lname, created_date_time, profile_picture, content, created_date_time, uid, comment_by, comment_id FROM comments c INNER JOIN users u on u.uid=c.comment_by WHERE post_id = '$postId'";
        $result = mysqli_query($connection, $selectAll);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        echo json_encode($result);
    } else {
        echo "User not logged in.";
    }
}
?>
