<?php 
    if(session_status() != PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    include_once("./server/db_connection.php");

    var_dump($_FILES);
    
    if($_FILES['file']['name']!='')
    {

        $fileName = $_FILES['file']['name'];
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $valid_extension = array("jpg",'jpeg');
        if(in_array($extension,$valid_extension))
        {
            $new_name = rand().".".$extension;
            $path = "user_uploads/".$new_name;

           if( move_uploaded_file($_FILES['file']['tmp_name'],$path)){
                $uid = $_SESSION['user']['uid'];
                $insert_pp = "UPDATE `users` SET `profile_picture`='$path' WHERE `uid`='$uid'";
                $result = mysqli_query($connection, $insert_pp);
                $getUserData = "select * from users where `uid`='$uid'";
                $getUserData = $connection->query($getUserData);
                $getUserData = mysqli_fetch_assoc($getUserData); 
                $_SESSION['user']['profile_picture'] = $path;
                echo "changed : ".$_SESSION['user']['profile_picture'];
            }
        }  
    }
    echo "changed : ".$_SESSION['user']['profile_picture'];

    header("Location: profile.php");
    


?>