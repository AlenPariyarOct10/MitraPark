<?php
include_once("../../../parts/entryCheck.php");
include_once("../../db_connection.php");

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

$uid = $_SESSION['user']['uid'];
$messageId = $_POST['message_id'];

$deleteMessageQuery = "DELETE FROM `messages` WHERE `message_id`='$messageId'";
$deleteResult = mysqli_query($connection, $deleteMessageQuery);

if ($deleteResult) {
    // Deletion was successful
    $deleteStatus = array('success' => true);
} else {
    // Deletion failed
    $deleteStatus = array('success' => false);
}

echo json_encode($deleteStatus);
?>
