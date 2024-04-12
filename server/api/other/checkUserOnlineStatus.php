<?php
  include_once("../../../server/db_connection.php");

  // 1. Sanitize user input to prevent SQL injection
  $userId = mysqli_real_escape_string($connection, $_POST['userId']);

  $getStatusQuery = "SELECT `last_active_date_time` FROM `users` WHERE `uid`='$userId'";

  $result = mysqli_query($connection, $getStatusQuery);

  if($result) {
    $row = mysqli_fetch_assoc($result);
    $lastActiveDateTime = $row['last_active_date_time'];
    $lastActiveTimestamp = strtotime($lastActiveDateTime);
    $currentTimestamp = time();
    $differenceInSeconds = $currentTimestamp - $lastActiveTimestamp;
    $differenceInMinutes = floor($differenceInSeconds / 60);


    if($differenceInMinutes <= 5)
    {
        echo json_encode(array("isActive"=>true));
    }else{
        echo json_encode(array("isActive"=>false));
    }
    
  } else {
    echo json_encode(array("isActive"=>false));
  }
?>
