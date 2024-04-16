<?php
include_once("../../server/db_connection.php");

if(isset($_GET['reportId'])) {

    $reportId = $_GET['reportId'];

    $deletReportQuery = "DELETE FROM `reports` WHERE `report_id`='$reportId'";

    $result = mysqli_query($connection, $deletReportQuery);

    if($result)
    {
        echo json_encode(array("success"=>true));
    }else{
        echo json_encode(array("success"=>false));

    }

} else {
    echo json_encode(array("success"=>false));
}
?>

