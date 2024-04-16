<?php

    include_once("../../server/db_connection.php");
    
    if(isset($_GET['reportId'])) {
    
        $reportId = $_GET['reportId'];
    
        $getUser = "SELECT `type`, `component_id` FROM `reports` WHERE `report_id`='$reportId'";
        $getUser = mysqli_query($connection, $getUser);
        $getUser = mysqli_fetch_assoc($getUser);
        $getUserId = $getUser['component_id'];
        $setRestricted = "UPDATE `users` SET `status`='restricted' WHERE `uid`='$getUserId'";
        $result1 = mysqli_query($connection, $setRestricted);

        $updateStatus = "UPDATE `reports` SET `report_response`='restricted' WHERE `report_id`='$reportId'"; 
        $result2 = mysqli_query($connection, $updateStatus);

    
        if($result1 && $result2)
        {
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
    
        }
    
    } else {
        echo json_encode(array("success"=>false));
    
    }
    ?>
    
    

