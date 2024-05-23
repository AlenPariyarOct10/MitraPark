<?php
    include_once("db_connection.php");
    
    function createUser($fname, $lname, $email, $password)
    {
        
       
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
     
        
        $currentDateTime = date("Y-m-d H-i-s");
        $insertQuery = "INSERT INTO `users`(`fname`, `lname`, `email`, `password`, `createdDateTime`) VALUES 
        ('$fname','$lname','$email','$hashedPassword','$currentDateTime')";
        
        $GLOBALS['connection']->query($insertQuery);
        

        if($GLOBALS['connection']->affected_rows >0)
        {
            if(!isset($_SESSION)){session_start();}
            $_SESSION['userCreated'] = true;
     
            header('Location: login.php?1');
        }
    }

    function changePassword($uid, $currentPassword, $newPassword)
    {
        // Fetch the hashed password associated with the provided user ID
        $fetchPasswordQuery = "SELECT `password` FROM `users` WHERE `uid`='$uid'";
        $result = mysqli_query($GLOBALS['connection'], $fetchPasswordQuery);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['password'];
            
            // Verify if the provided current password matches the hashed password
            if (password_verify($currentPassword, $hashedPassword)) {
                // Hash the new password
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Update the password in the database
                $updatePasswordQuery = "UPDATE `users` SET `password`='$newHashedPassword' WHERE `uid`='$uid'";
                $updateResult = mysqli_query($GLOBALS['connection'], $updatePasswordQuery);
                
                if ($updateResult) {
                    // Password updated successfully
                    return true;
                } else {
                    // Error updating password
                    return false;
                }
            } else {
                // Current password does not match
                return false;
            }
        } else {
            // Error fetching password
            return false;
        }
    }


    function searchAdmin($email, $password)
    {
        $hasEmail = "select * from `admin` where `email`='$email'";
        $hasEmail = $GLOBALS['connection']->query($hasEmail);
        if($GLOBALS['connection']->affected_rows == 0)
        {
            return false;
        }else{
            $getPassword = mysqli_fetch_assoc($hasEmail); 
            return password_verify($password, $getPassword['password']);
        }
    }
    

    function searchUser($email, $password)
    {
        $hasEmail = "select * from users where `email`='$email'";
        $hasEmail = $GLOBALS['connection']->query($hasEmail);
        if($GLOBALS['connection']->affected_rows == 0)
        {
            return false;
        }else{
            $getPassword = mysqli_fetch_array($hasEmail);   
            return password_verify($password, $getPassword['password']);
        }
    }

    function loginUser($email, $password)
    {
       if(searchAdmin($email, $password))
       {
     
        if(!isset($_SESSION)){session_start();}
        $_SESSION['loggedInAdmin'] = true;
        header("Location: ./admin/index.php");
       }else if(searchUser($email, $password)==false)
       {
            if(!isset($_SESSION)){session_start();}
            $_SESSION['userNotFound'] = true;
            $_SESSION['loggedIn'] = false;
       }else{
            if(!isset($_SESSION)){session_start();}
            $_SESSION['loggedIn'] = true;
            $getUserData = "select * from users where `email`='$email'";
            $getUserData = $GLOBALS['connection']->query($getUserData);
            $getUserData = mysqli_fetch_assoc($getUserData);
            $_SESSION['user'] = $getUserData;
            if($_SESSION['user']['profile_picture']==null){$_SESSION['user']['profile_picture']="/assets/images/user.png";}
            
            header("Location: feed.php");
       }
    }

    function refreshUserData()
    {
        $email = $_SESSION['user']['email'];
        $getUserData = "select * from users where `email`='$email'";
        $getUserData = $GLOBALS['connection']->query($getUserData);
        $getUserData = mysqli_fetch_assoc($getUserData);
        $_SESSION['user'] = $getUserData;

        if($_SESSION['user']['profile_picture']==null){$_SESSION['user']['profile_picture']="/assets/images/user.png";}

    }


  
    function addNotification($type, $component_id, $triggered_by)
    {
            // Type : for which component the notification is generated?
            // Component Id : id of component for which the notification is generated
            // Triggered by (id) : who triggered the notificaition
            // Alen:${triggeredBy} liked:${Type} your post${componentId}
        
        if(session_status()!=PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        $dateTime = Date("Y-m-d H-i-s");

        global $connection;


        $uid = $_SESSION['user']['uid'];
        if($type == "request_received" || $type == "request_accepted")
        {
            $insertQuery = "INSERT INTO `notifications`(`type`, `created_date_time`, `component_id`, `triggered_by`,`author_id`) VALUES ('{$type}', '$dateTime', '{$component_id}' , '{$triggered_by}',{$component_id})";
            $GLOBALS['connection']->query($insertQuery);
        }else{
            
        $authorId = mysqli_query($connection, "SELECT `author_id` FROM `posts` WHERE `post_id`='$component_id'");
        $authorId = mysqli_fetch_assoc($authorId);

        $authorId = $authorId['author_id'];
            if($authorId != $uid)
            {
                $insertQuery = "INSERT INTO `notifications`(`type`, `created_date_time`, `component_id`, `triggered_by`,`author_id`) VALUES ('{$type}', '$dateTime', '{$component_id}' , '{$triggered_by}',{$authorId})";
                $GLOBALS['connection']->query($insertQuery);
            }
        }
        

    }

    function removeNotification($type, $component_id, $triggered_by)
    {
            // Type : for which component the notification is generated?
            // Component Id : id of component for which the notification is generated
            // Triggered by (id) : who triggered the notificaition
            // Alen:${triggeredBy} liked:${Type} your post${componentId}
    
        $deleteQuery = "DELETE FROM `notifications` WHERE `type`='{$type}' AND `component_id`='{$component_id}' AND `triggered_by`='{$triggered_by}'";
        $GLOBALS['connection']->query($deleteQuery);

    }

    function timeAgo($postedTime)
    {

        $currentTime = time();
        $postedTimestamp = strtotime($postedTime);

        $timeDifference = $currentTime - $postedTimestamp;

        $seconds = floor($timeDifference);
        $minutes = floor($timeDifference / 60);
        $hours = floor($timeDifference / (60 * 60));
        $days = floor($timeDifference / (60 * 60 * 24));
        $months = floor($timeDifference / (60 * 60 * 24 * 30));
        $years = floor($timeDifference / (60 * 60 * 24 * 365));

        // Return time ago string
        if ($years > 0) {
            return $years . ($years > 1 ? ' years' : ' year') . ' ago';
        } elseif ($months > 0) {
            return $months . ($months > 1 ? ' months' : ' month') . ' ago';
        } elseif ($days > 0) {
            return $days . ($days > 1 ? ' days' : ' day') . ' ago';
        } elseif ($hours > 0) {
            return $hours . ($hours > 1 ? ' hours' : ' hour') . ' ago';
        } elseif ($minutes > 0) {
            return $minutes . ($minutes > 1 ? ' minutes' : ' minute') . ' ago';
        } else {
            return $seconds . "sec ago";
        }
    }
?>

