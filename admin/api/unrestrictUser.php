<?php

    include_once("../../server/db_connection.php");
    if (isset($_GET['userId'])) {
        $userId = htmlspecialchars($_GET['userId']);
    
        $setRestricted = "UPDATE `users` SET `status`='active' WHERE `uid`='$userId'";
        $setRestricted = mysqli_query($connection, $setRestricted);
    
        if ($setRestricted) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("user" => false));
        }
    }else if(isset($_GET['reportId'])) {
    
        $reportId = $_GET['reportId'];
    
        $getUser = "SELECT `type`, `component_id` FROM `reports` WHERE `report_id`='$reportId'";
        $getUser = mysqli_query($connection, $getUser);
        $getUser = mysqli_fetch_assoc($getUser);
        $getUserId = $getUser['component_id'];
        $setRestricted = "UPDATE `users` SET `status`='active' WHERE `uid`='$getUserId'";
        $result1 = mysqli_query($connection, $setRestricted);

        $updateStatus = "UPDATE `reports` SET `report_response`=NULL WHERE `report_id`='$reportId'"; 
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
    
    

