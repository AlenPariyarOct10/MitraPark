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
            echo "hello";
            header('Location: login.php?1');
        }
    }

    function searchUser($email, $password)
    {
        $hasEmail = "select * from users where `email`='$email'";
        $hasEmail = $GLOBALS['connection']->query($hasEmail);
        if($GLOBALS['connection']->affected_rows == 0)
        {
            echo "fail";
            return false;
        }else{
            $getPassword = mysqli_fetch_array($hasEmail);   
            return password_verify($password, $getPassword['password']);
        }
    }

    function loginUser($email, $password)
    {
       if(searchUser($email, $password)==false)
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


?>