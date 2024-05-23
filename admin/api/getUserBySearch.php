<?php
// header("Access-Control-Allow-Origin: *"); 
// header("Access-Control-Allow-Methods: POST");
include_once("../../server/db_connection.php");

if(session_status()!=PHP_SESSION_ACTIVE)
{
  session_start();
}

 if($_SESSION['loggedInAdmin']==true && isset($_GET['search']))
{

    $search = htmlspecialchars($_GET['search']);
    
    $getAllUsers = "SELECT uid, CONCAT(fname, ' ', lname) as uname, profile_picture, status FROM users WHERE CONCAT(fname, ' ', lname) LIKE '%$search%' OR uid = '$search' OR email LIKE '%$search%';";


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
