<?php
include_once ('./parts/entryCheck.php');
include_once ('./server/db_connection.php');
include_once ('./server/validation.php');
include_once ('./server/functions.php');
include_once ('./server/db_connection.php');
$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/kurakani-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="assets/css/mitras-style.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/all.min.css">

    <title>Kurakani Station</title>
    <style>
        .mitra-request-list-item:hover {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            margin: 1px;
        }

        .for-mobile{
            display: none;
            visibility: hidden;
        }

        @media screen and (max-width: 600px)
        {
            .hide-mobile{
                visibility: hidden;
                display: none;
            }

            .for-mobile{
                display: block;
                visibility: visible;
            }
        }
    </style>
</head>

<body>
    <?php include_once ("./parts/navbar.php"); ?>
    <div class="body">
        <?php include_once ("./parts/kurakani/leftNavPart.php") ?>
        <div class="mid-body hide-mobile">
            <img src="assets/images/community-img.svg" alt="" srcset="">
            <span>
                Let's have Kurakani with mitras
            </span>
        </div>
        <div id="chatUsersContainerMobile" class="mid-body for-mobile">
        </div>

        <?php include_once ("./parts/rightSidebar.php") ?>
    </div>
</body>

<script src="./assets/scripts/jquery.js"></script>
<script>
    let chatUsersContainer = document.getElementById("chatUsersContainer");
    let chatUsersContainerMobile = document.getElementById("chatUsersContainerMobile");
    $.ajax({
        url: "./server/api/kurakani/getKurakaniUsers.php",
        success: function (response) {
            console.log(response);
            let responseObj = JSON.parse(response);
            responseObj.forEach((item) => {
                chatUsersContainer.innerHTML += `<div class="mitra-request-list-item" id="request-1">
                        <a class="redirect-to-profile" href="chat.php?uid=${(item.uid)}">
                            <img class="mitra-request-profile-list" src="${(item.profile_picture) ? (item.profile_picture) : "/MitraPark/assets/images/user.png"}">
                            <span class="uname">
                                ${item.uname}
                            </span>
                        </a>
                    </div>`;
                    chatUsersContainerMobile.innerHTML += `<div class="mitra-request-list-item" id="request-1">
                        <a class="redirect-to-profile" href="chat.php?uid=${(item.uid)}">
                            <img class="mitra-request-profile-list" src="${(item.profile_picture) ? (item.profile_picture) : "/MitraPark/assets/images/user.png"}">
                            <span class="uname">
                                ${item.uname}
                            </span>
                        </a>
                    </div>`;
            })
        }
    })
</script>

</html>