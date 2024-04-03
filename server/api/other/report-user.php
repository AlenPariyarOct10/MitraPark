<?php
  include_once("../../../server/db_connection.php");
    if(!isset($_SESSION['user']['uid']))
    {
        session_start();
    }

    if(isset($_SESSION['user']['uid']) && isset($_POST['userId']) && isset($_POST['content']))
    {
        
        $uid = $_SESSION['user']['uid'];
        $userId = $_POST['userId'];
        $content = $_POST['content'];
        $insertReport = "INSERT INTO `reports`(`type`, `component_id`, `report_content`) VALUES ('user','$userId','$content')";
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