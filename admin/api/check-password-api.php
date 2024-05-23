<?php
include_once("../../server/db_connection.php");
session_start();
  if($_SERVER['REQUEST_METHOD']==='GET' && isset($_SESSION['loggedInAdmin']) && isset($_GET['formPassword']))
  {
    $formPassword = (($_GET['formPassword']));
    $getPassword = "SELECT `password` FROM `admin`";
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
  }else{
    echo json_encode(array("status"=>false));
  }
?>