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
    <link rel="shortcut icon" href="./<?php echo $aboutSite['system_logo']; ?>" type="image/x-icon">

    <link rel="stylesheet" href="./assets/css/all.min.css">
    <title>Setting -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <style>
        #share-btn {
            border: none;
            background-color: white;
            cursor: pointer;
        }

        .center-body {
            width: 40%;
        }

        #share-btn:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }
    </style>
    <?php echo "<script>localStorage.setItem('mp-uid','" . $_SESSION['user']['uid'] . "')</script>"; ?>
    <?php include_once("../MitraPark/assets/css/dynamicColor.php"); ?>

</head>

<body>
    <?php
    include_once("./parts/navbar.php");
    include_once("./parts/leftSidebar.php");
    ?>
    <div class='center-body'>
        <a class='right-nav-item' href='./changePassword.php'>
            <img class='right-nav-item-img' src='./assets/images/key.png'>
            <span>Change Password</span>
        </a>
        <!-- <a class='right-nav-item' href='./logout.php'>
            <img class='right-nav-item-img' src='./assets/images/trash.png'>
            <span>Delete Account</span>
        </a> -->
        <a class='right-nav-item' href='./strict-mode.php'>
            <img class='right-nav-item-img' src='./assets/images/time.png'>
            <span>Strict Mode</span>
        </a>
    </div>
    <?php
    include_once("./parts/rightSidebar.php");
    ?>
    <script src='./assets/scripts/jquery.js'></script>
    <?php include_once("./parts/js-script-files/js-script.php");?>
<?php include_once("./parts/js-script-files/strict-and-activity-update.php"); ?>


</body>

</html>