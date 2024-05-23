<?php

    include_once("../../server/db_connection.php");
    if(isset($_GET['postId']))
    {
        $postId = htmlspecialchars($_GET['postId']);

        $setRestricted = "UPDATE `posts` SET `status`='restricted' WHERE `post_id`='$postId'";
        $setRestricted = mysqli_query($connection, $setRestricted);

        if($setRestricted)
        {
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));

        }
    }else if(isset($_GET['reportId'])) {
    
        $reportId = htmlspecialchars($_GET['reportId']);
        echo $reportId;
        $getPost = "SELECT `type`, `component_id` FROM `reports` WHERE `report_id`='$reportId'";
        $getPost = mysqli_query($connection, $getPost);
        $getPost = mysqli_fetch_assoc($getPost);
        var_dump($getPost);
        $getPostId = $getPost['component_id'];
        $setRestricted = "UPDATE `posts` SET `status`='restricted' WHERE `post_id`='$getPostId'";
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
    
    

