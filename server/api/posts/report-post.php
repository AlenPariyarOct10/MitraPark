<?php
  include_once("../../../server/db_connection.php");
    if(!isset($_SESSION['user']['uid']))
    {
        session_start();
    }

    if(isset($_SESSION['user']['uid']) && isset($_POST['postId']) && isset($_POST['reportContent']))
    {
        
        $uid = $_SESSION['user']['uid'];
        $postId = $_POST['postId'];
        $content = $_POST['reportContent'];
        $insertReport = "INSERT INTO `reports`(`type`, `component_id`, `report_content`) VALUES ('post','$postId','$content')";
        $result = mysqli_query($connection, $insertReport);

        if($result)
        {
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));

        }
    }else{
        echo json_encode(array("success"=>false));
    }

?>