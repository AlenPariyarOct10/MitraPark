<?php
    include_once("db_connection.php");

     $checkMaintenanceMode = "SELECT `maintenance_mode` FROM `system_data` WHERE 1";
     $checkMaintenanceMode = mysqli_query($connection, $checkMaintenanceMode);
     $checkMaintenanceMode = mysqli_fetch_assoc($checkMaintenanceMode);
     if($checkMaintenanceMode['maintenance_mode']==='1')
     {
         header("Location: maintenance-mode.php");
     }

     $uid = $_SESSION['user']['uid'];
     $checkRestricted = "SELECT `status` FROM `users` WHERE `uid`='$uid'";
     $checkRestricted = mysqli_query($connection, $checkRestricted);
     $checkRestricted = mysqli_fetch_assoc($checkRestricted);
     if($checkRestricted['status']==='restricted')
     {
         header("Location: user-restricted.php");
     }
?>