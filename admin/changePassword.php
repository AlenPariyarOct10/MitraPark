<?php

include_once("../server/db_connection.php");

if($_SERVER['REQUEST_METHOD']==="POST")
{
    if(isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password']))
    {
        $hash_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $changeAdminPassword = "UPDATE `admin` SET `password`='$hash_password'";

        $changeAdminPassword = mysqli_query($connection, $changeAdminPassword);

        if(mysqli_affected_rows($connection) > 0)
        {
            header("Location: system.php?changePassword=success");
        }else{
            header("Location: system.php?changePassword=failed");
        }
    }else{
        header("Location: system.php?changePassword=failed");
    }
}else{
    header("Location: system.php?changePassword=failed");
}

?>