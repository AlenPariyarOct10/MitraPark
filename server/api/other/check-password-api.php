<?php
  include_once("../../../server/db_connection.php");
   
  if($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['uid']) && isset($_GET['formPassword']))
  {
    $uid = trim(htmlspecialchars($_GET['uid']));
    $formPassword = trim(($_GET['formPassword']));
    $getPassword = "SELECT `password` FROM `users` WHERE `uid`='$uid'";
    $getPassword = mysqli_query($connection, $getPassword);
    if(mysqli_affected_rows($connection)){
        $password = mysqli_fetch_assoc($getPassword);
        
        if(password_verify($formPassword, $password['password']))
        {
            echo json_encode(array("status"=>true));
        }else{
            echo json_encode(array("status"=>false));
        }
    }else{
        echo json_encode(array("status"=>false));
    }
  }
?>