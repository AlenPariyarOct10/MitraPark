<?php
if(session_status()!=PHP_SESSION_ACTIVE){session_start();};

include_once("../db_connection.php");
$rawData = file_get_contents("php://input");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user']['uid'])) {
        $uid = $_SESSION['user']['uid'];
        $postId = $_POST['postId'];

        $selectAll = "SELECT * FROM likes WHERE post_id = '$postId'";
        $result = mysqli_query($connection, $selectAll);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        

        echo json_encode($result);
    } else {
        echo "User not logged in.";
    }
}
?>
