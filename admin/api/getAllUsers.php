<?php
// header("Access-Control-Allow-Origin: *"); 
// header("Access-Control-Allow-Methods: POST");
include_once("../../server/db_connection.php");

if(session_status()!=PHP_SESSION_ACTIVE)
{
  session_start();
}
 if($_SESSION['loggedInAdmin']==true)
{

    $page = $_POST['page'];
    $offset = ($page - 1) * 8;
    
   $getAllUsers = "SELECT uid, concat(fname,' ',lname) as uname, profile_picture, status FROM `users` LIMIT $offset, 8";
   $getAllUsers = mysqli_query($connection, $getAllUsers);

   $allData = array();
   while($row = mysqli_fetch_assoc($getAllUsers))
   {
    array_push($allData, $row);
   }

   echo json_encode(($allData));

}else{
    echo json_encode(array());
}
