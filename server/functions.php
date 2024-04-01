<?php
    include_once("db_connection.php");
    
    function createUser($fname, $lname, $email, $phone, $password)
    {
        
        echo "called";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        echo "called";
        
        $currentDateTime = date("Y-m-d h:i:s");
        $insertQuery = "INSERT INTO `users`(`fname`, `lname`, `phone`, `email`, `password`, `createdDateTime`) VALUES 
        ('$fname','$lname','$phone','$email','$hashedPassword','$currentDateTime')";
        
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

        $uid = $_SESSION['user']['uid'];

        $insertQuery = "INSERT INTO `notifications`(`type`, `created_date_time`, `component_id`, `triggered_by`,`author_id`) VALUES ('{$type}', NOW(), '{$component_id}' , '{$triggered_by}',{$uid})";
        $GLOBALS['connection']->query($insertQuery);

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
?>