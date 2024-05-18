<?php

session_start();
include_once('../../db_connection.php');
include_once('../../functions.php');




$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);


?>


  
        <?php
        $uid = $_SESSION['user']['uid'];

        // Query for request-related notifications
        $requestQuery = "SELECT CONCAT(fname, ' ',lname) as uname,
                                profile_picture,
                                type,
                                created_date_time,
                                component_id,
                                triggered_by
                            FROM notifications n
                            INNER JOIN users u ON triggered_by = u.uid
                            WHERE triggered_by <> '$uid' AND component_id = '$uid'
                            ORDER BY created_Date_time DESC";

        $result = mysqli_query($connection, $requestQuery);
        $requestNotification = mysqli_affected_rows($connection);
        $final = array();
        
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($final, $row);
            }
        
        // Query for other notifications (likes, comments)
        $otherQuery = "SELECT CONCAT(fname, ' ',lname) AS uname, 
                                profile_picture, 
                                type, 
                                created_date_time,
                                component_id  
                            FROM notifications n 
                            INNER JOIN users u ON triggered_by = u.uid 
                            WHERE triggered_by <> '$uid' AND component_id IN (SELECT post_id FROM posts WHERE author_id = '$uid') 
                            ORDER BY created_date_time DESC";

        $result = mysqli_query($connection, $otherQuery);
        $otherNotification = mysqli_affected_rows($connection);


        while ($row = mysqli_fetch_assoc($result)) {
            array_push($final, $row);
        }

        usort($final, function($a, $b){
            return strtotime($b['created_date_time'])- strtotime($a['created_date_time']);
        });
        if(count($final)>0)
        {
            echo json_encode($final);
        }else{
            echo json_encode(array(null));
        }
?>
