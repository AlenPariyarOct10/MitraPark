<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite= $aboutSite->fetch_array(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='style.css'>
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/fontawesome.css">
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link
        href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap'
        rel='stylesheet'>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/navbar.css">
    <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">
    <title>Feed -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <style>
        
        #share-btn{
            border: none; 
            background-color: white;
            cursor: pointer;
        }

        #share-btn:hover{
            background-color: rgba(0, 0, 0, 0.2);
        }
    </style>
    <?php echo "<script>localStorage.setItem('mp-uid','".$_SESSION['user']['uid']."')</script>";?>

</head>

<body>
    <?php
        include_once("./parts/navbar.php");
        include_once("./parts/leftSidebar.php");
        function timeAgo($postedTime) {
            // Get current timestamp
            $currentTime = time();
            
            // Convert posted time to timestamp
            $postedTimestamp = strtotime($postedTime);
            
            // Calculate time difference in seconds
            $timeDifference = $currentTime - $postedTimestamp;
            
            // Convert time difference to minutes, hours, days, months, or years
            $minutes = floor($timeDifference / 60);
            $hours = floor($timeDifference / (60 * 60));
            $days = floor($timeDifference / (60 * 60 * 24));
            $months = floor($timeDifference / (60 * 60 * 24 * 30));
            $years = floor($timeDifference / (60 * 60 * 24 * 365));
            
            // Return time ago string
            if ($years > 0) {
                return $years . ($years > 1 ? ' years' : ' year') . ' ago';
            } elseif ($months > 0) {
                return $months . ($months > 1 ? ' months' : ' month') . ' ago';
            } elseif ($days > 0) {
                return $days . ($days > 1 ? ' days' : ' day') . ' ago';
            } elseif ($hours > 0) {
                return $hours . ($hours > 1 ? ' hours' : ' hour') . ' ago';
            } elseif ($minutes > 0) {
                return $minutes . ($minutes > 1 ? ' minutes' : ' minute') . ' ago';
            } else {
                return 'just now';
            }
        }
    ?>
    <div class="mid-body">
    <div class="left-inner-heading">
                    <span class="dim-label">
                        Notifications
                    </span>
                    <hr class="label-underline">
                </div>
            <?php 
            $uid = $_SESSION['user']['uid'];
                $getNotificationQuery = "SELECT CONCAT(fname, ' ', lname) AS uname, 
                                profile_picture, 
                                type, 
                                created_date_time,
                                triggered_by  
                         FROM notifications n 
                         INNER JOIN users u ON triggered_by = u.uid 
                         WHERE n.type='like' 
                               AND u.uid<>'$uid' 
                               AND component_id IN (SELECT post_id FROM posts WHERE author_id='$uid') 
                         ORDER BY created_date_time ASC";

                $result = mysqli_query($connection, $getNotificationQuery);
                while($row = mysqli_fetch_assoc($result))
                {
                
                    if($row['type']=='like')
                    {
                        echo '
                        <a class="right-nav-item" id="my-profile" href="./user.php?id='.$row['triggered_by'].'">
                            <img class="right-nav-item-img" src="./'.$row['profile_picture'].'">
                            <div style="display:flex; flex-direction:column;">
                                <span><b>'.$row['uname'].'</b> liked your post.</span>
                                <span style="font-size: small; color: #373737;">'.timeAgo($row['created_date_time']).' ago</span>
                            </div>
                        </a>
                        ';
                    }else if($row['type']=='comment')
                    {
                        echo '
                        <a class="right-nav-item" id="my-profile" href="./user.php?id='.$row['triggered_by'].'">
                            <img class="right-nav-item-img" src="./'.$row['profile_picture'].'">
                            <div style="display:flex; flex-direction:column;">
                                <span><b>'.$row['uname'].'</b> commented in your post.</span>
                                <span style="font-size: small; color: #373737;">'.timeAgo($row['created_date_time']).' ago</span>
                            </div>
                        </a>
                        ';
                    }
                }
                ?>
                
</div>

<?php
    $setSeenNotifications = "UPDATE `notifications` SET `seen_status`=1 WHERE `author_id`='$uid'";
    $result = mysqli_query($connection, $setSeenNotifications);
?>
    
    <?php
        include_once("./parts/rightSidebar.php");
    ?>
    
    <script src='./assets/scripts/jquery.js'></script>
    <script src='posts.js'></script>
</body>
</html>