<?php
header("Access-Control-Allow-Origin: *"); // Change * to your allowed origin if known
header("Access-Control-Allow-Methods: POST");
include_once("../../server/db_connection.php");

if(session_status()!=PHP_SESSION_ACTIVE)
{
  session_start();
}
 if($_SESSION['loggedInAdmin']==true)
{

    $reportType = $_POST['reportType'];
    $page = $_POST['page'];
    $offset = ($page - 1) * 20;
    
    if($reportType=='post')
    {
        $getAllReported = "SELECT DISTINCT *,
        (SELECT COUNT(DISTINCT report_id)
        FROM `reports`
        INNER JOIN posts p ON component_id = p.post_id
        WHERE `type`='$reportType' AND `report_response` IS NULL) AS total_count
        FROM `reports`
        INNER JOIN posts p ON component_id=post_id
        WHERE reports.type='$reportType' AND p.status = 'active' AND `report_response` IS NULL
        LIMIT $offset, 20";
    }else if($reportType=='user')
    {
        $getAllReported = "SELECT DISTINCT *,
        (SELECT COUNT(DISTINCT report_id)
        FROM `reports`
        INNER JOIN users u ON component_id = u.uid
        WHERE `type`='$reportType' AND `report_response` IS NULL) AS total_count
        FROM `reports`
        INNER JOIN users u ON component_id = u.uid
        WHERE `type`='$reportType' AND u.status = 'active' AND `report_response` IS NULL
        LIMIT $offset, 20";

    }else if($reportType=='restrictedPosts')
    {
        $getAllReported = "SELECT *, (SELECT COUNT(report_id)
        FROM `reports`
        WHERE `report_response`='restricted' and `type`='post') AS total_count FROM `reports` WHERE `type`='post' AND `component_id` IN (SELECT `post_id` FROM `posts` WHERE `status`='restricted') LIMIT $offset, 20";

    }else if($reportType == "restrictedUser") {
        $getAllReported = "SELECT * FROM `reports` r 
            INNER JOIN users u ON u.uid = r.component_id 
            WHERE `type`='user' AND u.status='restricted' 
            LIMIT $offset, 20";
    }
    $result = mysqli_query($connection, $getAllReported);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    echo json_encode($result);

}else{
    echo "No data";
}
