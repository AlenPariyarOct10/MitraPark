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
            width: 100%;
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
            <div id="notifications-list"></div>
        </div>
        <?php
        $uid = $_SESSION['user']['uid'];

        

        if(0)
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
<script>
    function timeAgo(postedTime) {
  const postedDate = new Date(postedTime);
  const currentDate = new Date();
  const timeDifference = currentDate - postedDate;

  const seconds = Math.floor(timeDifference / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);
  const months = Math.floor(days / 30);
  const years = Math.floor(days / 365);

  if (years > 0) {
      return `${years} year${years > 1 ? 's' : ''} ago`;
  } else if (months > 0) {
      return `${months} month${months > 1 ? 's' : ''} ago`;
  } else if (days > 0) {
      return `${days} day${days > 1 ? 's' : ''} ago`;
  } else if (hours > 0) {
      return `${hours} hour${hours > 1 ? 's' : ''} ago`;
  } else if (minutes > 0) {
      return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
  } else {
      return 'just now';
  }
}
    $.ajax({
        url: "./server/api/notifications/getNotifications.php",
        type: "POST",
        success: (res)=>{
            console.log(res);
            let notifications = (JSON.parse(res));
            notifications.map((item)=>{
                if(item.type=='like')
                {
                    $("#notifications-list")[0].innerHTML += `
                        <a class="right-nav-item" href="./post.php?postId=${item.component_id}">
                                <img class="right-nav-item-img" src="./${item.profile_picture}">
                                <div class="notification-right-part" style="display:flex; flex-direction:column;">
                                    <span><b>${item.uname}</b> liked your post.</span>
                                    <span style="font-size: small; color: #373737;">${timeAgo(item.created_date_time)}</span>

                                </div>
                        </a>
                    `;
                }else if(item.type==='comment')
                {
                    $("#notifications-list")[0].innerHTML += `
                        <a class="right-nav-item" href="./post.php?postId=${item.component_id}">
                                <img class="right-nav-item-img" src="./${item.profile_picture}">
                                <div class="notification-right-part" style="display:flex; flex-direction:column;">
                                    <span><b>${item.uname}</b> commented in your post.</span>
                                    <span style="font-size: small; color: #373737;">${timeAgo(item.created_date_time)}</span>
                                </div>
                        </a>
                    `;
                }else if(item.type==="request_received")
                {
                    $("#notifications-list")[0].innerHTML += `
                        <a class="right-nav-item" href="./user.php?id=${item.triggered_by}">
                                <img class="right-nav-item-img" src="./${item.profile_picture}">
                                <div class="notification-right-part" style="display:flex; flex-direction:column;">
                                    <span><b>${item.uname}</b> sent you mitra request.</span>
                                    <span style="font-size: small; color: #373737;">${timeAgo(item.created_date_time)}</span>
                                </div>
                        </a>
                    `;
                }else if(item.type === "request_accepted")
                {
                    $("#notifications-list")[0].innerHTML += `
                        <a class="right-nav-item" href="./user.php?id=${item.triggered_by}">
                                <img class="right-nav-item-img" src="./${item.profile_picture}">
                                <div class="notification-right-part" style="display:flex; flex-direction:column;">
                                    <span><b>${item.uname}</b> accepted your mitra request.</span>
                                    <span style="font-size: small; color: #373737;">${timeAgo(item.created_date_time)}</span>
                                </div>
                        </a>
                    `;
                }
                
            })
           
        }
    })
</script>

</html>