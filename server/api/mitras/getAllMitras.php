<?php

include_once("../../db_connection.php");


if(session_status() != PHP_SESSION_ACTIVE)
{
    session_start();
}

if(isset($_SESSION['user']['uid']) && $_SERVER['REQUEST_METHOD']=="POST")
{
    $uid = $_SESSION['user']['uid'];

    $getAllMitrasQuery = "SELECT DISTINCT sender_id, acceptor_id FROM `friends` WHERE `sender_id`='$uid' OR `acceptor_id`='$uid'";
    $getAllMitras = mysqli_query($connection, $getAllMitrasQuery);
    $getAllMitras = mysqli_fetch_all($getAllMitras, MYSQLI_ASSOC);
    
    $allMitra = array();
    foreach($getAllMitras as $mitra)
    {
        if($mitra['sender_id']==$uid)
        {
            $mitraUid =$mitra['acceptor_id']; 
            
        }else if($mitra['acceptor_id']==$uid)
        {
            $mitraUid = $mitra['sender_id'];
        }
    
        $getUser = "SELECT uid, concat(fname,' ',lname) as uname, profile_picture FROM `users` WHERE `uid`='$mitraUid'";
        $mitraData = mysqli_query($connection, $getUser);
        $mitraData = mysqli_fetch_assoc($mitraData);
    
        array_push($allMitra, $mitraData);
    }
    
    echo json_encode($allMitra);
}else{
    echo "access not allowed";
}





?>