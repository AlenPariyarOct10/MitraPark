<?php
    if(session_status()!=PHP_SESSION_ACTIVE){session_start();};
    include_once("../db_connection.php");

    $checkMaintenanceMode = "SELECT `maintenance_mode` FROM `system_data` WHERE 1";
    $checkMaintenanceMode = mysqli_query($connection, $checkMaintenanceMode);
    $checkMaintenanceMode = mysqli_fetch_assoc($checkMaintenanceMode);
    if($checkMaintenanceMode['maintenance_mode']==='1')
    {
        echo json_encode(array("maintenance-mode"=>true));
    }else{
        echo json_encode(array("maintenance-mode"=>false));
    }
?>