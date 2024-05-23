<?php

include_once("../../server/db_connection.php");

if(session_status()!=PHP_SESSION_ACTIVE)
{
  session_start();
}
 if($_SESSION['loggedInAdmin']==true)
{

    $page = $_POST['page'];
    $offset = ($page - 1) * 8;
    
   $getAllUsers = "SELECT post_id, (select concat(fname,' ',lname) as uname FROM `users` WHERE uid=p.author_id) as uname, media, status, content FROM posts p LIMIT $offset, 8";
  //  $getAllUsers = "SELECT post_id, (select concat(fname,' ',lname) FROM `users` WHERE uid=p.author_id) as uname, media, status, content FROM posts p";
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
