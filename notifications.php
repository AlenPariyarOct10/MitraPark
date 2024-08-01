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

        #notifications-list{
            width: 100%;
        }

        .notifications-item
        {
            width: 100%;
        }

        .pop-up-notification {

position: absolute;
bottom: 2%;
z-index: 1;
width: 70%;
box-shadow: 0.5px 0.5px 5px 0.5px #6d6d6d;
border-radius: 2px;
display: flex;
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
        <div  class="left-inner-heading section-heading">
            <span class="dim-label">
                Notifications
            </span>
            <button id="clearAllNotifications" style="padding:0px 10px 0px 10px; border: none; cursor: pointer; background-color: rgb(237, 100, 100); color:white; border-radius: 50px 0px 0px 50px">Clear All</button>
            <hr class="label-underline">
            <div id="notifications-list"></div>
        </div>
        <?php
        $uid = $_SESSION['user']['uid'];
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
    function showSuccessNotification() {
                let div = document.createElement("div");
                div.innerHTML = `<div style="background-color: #D8EEBE; padding:10px; border-left:10px solid #75964A; display:flex;justify-content:space-between;" class="pop-up-notification">
                        <div class="label">
                            <p id="notification-text">Notifications deleted <b>Successfully </b>✅</p>
                        </div>
                    </div>`;
                div.style.width = "100%";
                document.getElementsByClassName("mid-body")[0].appendChild(div);
                div.setAttribute("class", "popup-notification");

                setTimeout(() => {
                    div.remove();
                }, 5000);
            }


    let clearNotificationsBtn = document.getElementById("clearAllNotifications");
    clearNotificationsBtn.addEventListener("click",()=>{
            // console.log("clicked");    
            $.ajax({
            url: "./server/api/notifications/deleteNotifications.php",
            type: "POST",
            success: (response)=>
            {
               
                showSuccessNotification();
                let res = JSON.parse(response);
                // console.log(res);
                if(res[0]==true)
                {
                    document.getElementById("notifications-list").innerHTML = "Notifications deleted";
                }
            },
            error: (response)=>{
                // console.log(response);
               
                let res = JSON.parse(response);

            }

        })
    })
    function getNotifications(){
    $.ajax({
        url: "./server/api/notifications/getNotifications.php",
        type: "POST",
        success: (res)=>{
            // console.log(res);
            let notifications = (JSON.parse(res));
            // console.log('length',notifications.length);
            // console.log('length',notifications);
            if(notifications.length==0 || notifications[0]==null)
            {
                $("#notifications-list")[0].innerHTML = " No Notifications";
            }else{
                $("#notifications-list")[0].innerHTML = "";
            notifications.map((item)=>{
                if(item.type=='like')
                {
                    $("#notifications-list")[0].innerHTML += `
                        <a class="right-nav-item notifications-item" href="./post.php?postId=${item.component_id}">
                                <img class="right-nav-item-img" src="./${item.profile_picture}">
                                <div class="notification-right-part" style="display:flex; flex-direction:column;">
                                    <span><b>${item.uname}</b> liked your post.</span>
                                    <span style="font-size: small; color: #373737;">💌${timeAgo(item.created_date_time)}</span>

                                </div>
                        </a>
                    `;
                }else if(item.type==='comment')
                {
                    $("#notifications-list")[0].innerHTML += `
                        <a class="right-nav-item notifications-item" href="./post.php?postId=${item.component_id}">
                                <img class="right-nav-item-img" src="./${item.profile_picture}">
                                <div class="notification-right-part" style="display:flex; flex-direction:column;">
                                    <span><b>${item.uname}</b> commented in your post.</span>
                                    <span style="font-size: small; color: #373737;">💬${timeAgo(item.created_date_time)}</span>
                                </div>
                        </a>
                    `;
                }else if(item.type==="request_received")
                {
                    $("#notifications-list")[0].innerHTML += `
                        <a class="right-nav-item notifications-item" href="./user.php?id=${item.triggered_by}">
                                <img class="right-nav-item-img" src="./${item.profile_picture}">
                                <div class="notification-right-part" style="display:flex; flex-direction:column;">
                                    <span><b>${item.uname}</b> sent you mitra request.</span>
                                    <span style="font-size: small; color: #373737;">➡️${timeAgo(item.created_date_time)}</span>
                                </div>
                        </a>
                    `;
                }else if(item.type === "request_accepted")
                {
                    $("#notifications-list")[0].innerHTML += `
                        <a class="right-nav-item notifications-item" href="./user.php?id=${item.triggered_by}">
                                <img class="right-nav-item-img" src="./${item.profile_picture}">
                                <div class="notification-right-part" style="display:flex; flex-direction:column;">
                                    <span><b>${item.uname}</b> accepted your mitra request.</span>
                                    <span style="font-size: small; color: #373737;">✅${timeAgo(item.created_date_time)}</span>
                                </div>
                        </a>
                    `;
                }
                
            })
        }

           
        }
    })
}
getNotifications();
setInterval(getNotifications, 5000);

</script>
<?php  include_once ("./parts/js-script-files/strict-and-activity-update.php"); ?>

</html>