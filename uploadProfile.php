<?php 

    include_once("./server/db_connection.php");
    
    if($_FILES['file']['name']!='')
    {
        session_start();
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
                $getUserData = "select * from users where `email`='$email'";
                $getUserData = $connection->query($getUserData);
                $getUserData = mysqli_fetch_assoc($getUserData);
                var_dump(json_encode($getUserData));
                
            }
        }
        
    }
    


?>