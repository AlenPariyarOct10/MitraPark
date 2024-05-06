<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
include_once("./server/auto-routes.php");

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
    <link href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' rel='stylesheet'>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/navbar.css">
    <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">
    <title>Notifications -
        <?php echo $aboutSite['system_name']; ?>

    </title>
    <style>
        #share-btn {
            border: none;
            background-color: white;
            cursor: pointer;
        }

        #share-btn:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .right-nav-item {
            width: 60%;
            justify-content: space-between;
        }

        .notification-right-part {
            width: 100%;
        }

        .section-heading {
            width: 70%;
        }
    </style>
    <?php include_once("../MitraPark/assets/css/dynamicColor.php"); ?>

    <?php echo "<script>localStorage.setItem('mp-uid','" . $_SESSION['user']['uid'] . "')</script>"; ?>

</head>

<body>
    <?php
    include_once("./parts/navbar.php");
    include_once("./parts/leftSidebar.php");
    
    ?>
    <div class="mid-body">
        <div class="left-inner-heading section-heading">
            <span class="dim-label">
                Notifications
            </span>
            <hr class="label-underline">
        </div>
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
        
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['type'] == 'request_received') {
                    displayRequestNotification($row);
                } elseif ($row['type'] == 'request_accepted') {
                    displayAcceptedNotification($row);
                }
    
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
            if ($row['type'] == 'like') {
                displayLikeNotification($row);
            } elseif ($row['type'] == 'comment') {
                displayCommentNotification($row);
            } elseif ($row['type'] == 'request_received') {
                displayRequestNotification($row);
            }
        }

        if($otherNotification + $requestNotification == 0)
        {
            echo "<p>No notifications found.</p>";
        }

        // Function to display a request notification
        function displayRequestNotification($row)
        {
            echo '
                <a class="right-nav-item" href="./user.php?id=' . $row['triggered_by'] . '">
                    <img class="right-nav-item-img" src="./' . $row['profile_picture'] . '">
                    <div class="notification-right-part" style="display:flex; flex-direction:column;">
                        <span><b>' . $row['uname'] . '</b> sent you Mitra request.</span>
                        <span style="font-size: small; color: #373737;">' . timeAgo($row['created_date_time']) . ' </span>
                    </div>
                </a>
                ';
        }

        // Function to display an accepted notification
        function displayAcceptedNotification($row)
        {
            echo '
                <a class="right-nav-item" href="./user.php?id=' . $row['triggered_by'] . '">
                    <img class="right-nav-item-img" src="./' . $row['profile_picture'] . '">
                    <div class="notification-right-part" style="display:flex; flex-direction:column;">
                        <span><b>' . $row['uname'] . '</b> accepted your Mitra request.</span>
                        <span style="font-size: small; color: #373737;">' . timeAgo($row['created_date_time']) . ' </span>
                    </div>
                </a>
                ';
        }

        // Function to display a like notification
        function displayLikeNotification($row)
        {
            echo '
                <a class="right-nav-item" href="./post.php?postId=' . $row['component_id'] . '">
                    <img class="right-nav-item-img" src="./' . $row['profile_picture'] . '">
                    <div class="notification-right-part" style="display:flex; flex-direction:column;">
                        <span><b>' . $row['uname'] . '</b> liked your post.</span>
                        <span style="font-size: small; color: #373737;">' . timeAgo($row['created_date_time']) . ' </span>
                    </div>
                </a>
                ';
        }

        // Function to display a comment notification
        function displayCommentNotification($row)
        {
            echo '
                <a class="right-nav-item" href="./post.php?postId=' . $row['component_id'] . '">
                    <img class="right-nav-item-img" src="./' . $row['profile_picture'] . '">
                    <div class="notification-right-part" style="display:flex; flex-direction:column;">
                        <span><b>' . $row['uname'] . '</b> commented in your post.</span>
                        <span style="font-size: small; color: #373737;">' . timeAgo($row['created_date_time']) . ' </span>
                    </div>
                </a>
                ';
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
    <?php include_once("./parts/js-script-files/js-script.php");?>
<?php include_once("./parts/js-script-files/strict-and-activity-update.php"); ?>


</body>

</html>