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
    <link rel="stylesheet" href="./assets/css/navbar.css">
    <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">
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

        /* ALEN : Kurakani-Style */
        .recent-message{
            font-size: small;
            padding-left: 5px;
        }

        .chat-item-container{
            color: rgb(62, 62, 62);
            display: flex;
            padding-left: 5px;
            flex-direction: column;
        }

        .new-msg-dot {
            height: 12px;
            width: 12px;
            background-color: #3da5ff;
            border-radius: 50%;
            display: inline-block;
            }
        .active-user-dot {
            height: 15px;
            width: 15px;
            background-color: #2bff19;
            border-radius: 50%;
            display: inline-block;
            position: absolute;
            bottom: 5px;
            right: 1px;
            box-shadow: 0.5px 0.5px 2px 0.5px #78787892;
            }

        .text-time-label{
            padding-left: 5px;
            font-size: x-small;
        }

        .profile-holder{
            position: relative;
        }
    </style>
        <?php include_once("../MitraPark/assets/css/dynamicColor.php"); ?>
  
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

<?php
// ALEN : JS scripts to get chat history and suggested users
?>
<?php include_once("./parts/kurakani/kurakani-scripts.php"); ?>
<?php
        include_once("./parts/js-script-files/js-script.php");
    ?>

</html>