<?php

    include_once('../../parts/entryCheck.php');
    include_once('../../server/db_connection.php');
    include_once('../../server/validation.php');
    include_once('../../server/functions.php');

    (session_status() !== PHP_SESSION_ACTIVE) ? session_start() : "";
    $uid = $_SESSION['user']['uid'];
  

    // Check in Request List
    $selectFriendRequest = "SELECT * FROM `friend_requests` WHERE `receiver_id`='$uid'";
    $requestList = mysqli_query($connection, $selectFriendRequest);


    if($requestList===null)
    {
        echo 'No requests received';
    }else{
        foreach($requestList as $request)
        {
                        // Get profile data
            $senderId = $request['sender_id'];
            $selectUser = "SELECT concat(`fname`,' ',`lname`) as `name`, `uid`, `profile_picture` FROM users WHERE `uid`='$senderId'";
            $userData = mysqli_query($connection, $selectUser);
            $userData = mysqli_fetch_assoc($userData);

            echo '<div class="mitra-request-list-item" id="request-'.$request['request_id'].'">
        <a class="redirect-to-profile" href="user.php?id='.$request['sender_id'].'">
            <img class="mitra-request-profile-list" src="./'.$userData['profile_picture'].'">
            <span class="uname">
               '.$userData["name"].'
            </span>
        </a>
    </div>';
        }
        
    }
    
 
    
?>