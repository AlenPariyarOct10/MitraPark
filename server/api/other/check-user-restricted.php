<?php
  include_once("../../../server/db_connection.php");

  $userId = mysqli_real_escape_string($connection, $_POST['userId']);

  $getStatusQuery = "SELECT `status` FROM `users` WHERE `uid`='$userId'";

  $result = mysqli_query($connection, $getStatusQuery);

  if($result) {
    $row = mysqli_fetch_assoc($result);
    $row = $row['status'];

    if($row !== "active")
    {
        echo json_encode(array("restricted-status"=>true));
    }else{
        echo json_encode(array("restricted-status"=>false));
    }
    
  } else {
    echo json_encode(array("restricted-status"=>false));

  }
?>
