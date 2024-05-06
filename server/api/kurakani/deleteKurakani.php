<?php
include_once("../../../parts/entryCheck.php");
include_once("../../db_connection.php");

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

$uid = $_SESSION['user']['uid'];
$messageId = $_POST['message_id'];
$receiver_id = $_POST['receiver_id'];
$dateTime = Date("Y-m-d H-i-s");

$deleteMessageQuery = "DELETE FROM `messages` WHERE `message_id`='$messageId'";
$history = "UPDATE `chat_history` SET `last_updated`='$dateTime', `last_message`='unsent', `sender_id`='$uid', `seen_status`=0 WHERE `user_1`='$uid' AND `user_2`='$receiver_id' OR  `user_1`='$receiver_id' AND `user_2`='$uid'";
$updateHistory = mysqli_query($connection, $history);
$deleteResult = mysqli_query($connection, $deleteMessageQuery);

if ($deleteResult) {
    $deleteStatus = array('success' => true);
} else {
    $deleteStatus = array('success' => false);
}

echo json_encode($deleteStatus);
?>
