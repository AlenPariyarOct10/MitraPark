<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');

$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>

<?php 
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];
    if(isset($_POST['setMaxHours']))
    {
        $maxSeconds = $_POST['setMaxHours'];
        $getNotifications = false;

        if(isset($_POST['exceedTimeWarning']))
        {
            $getNotifications = true;
        }

        $strictMode = true;

        $insertStrictMode = "INSERT INTO `strict_mode`(`uid`, `getWarning`, `endStrictDate`, `maxAccessSeconds`, `strictMode`, `availableAccessSeconds`) VALUES ('$uid','$getNotifications',CURDATE(),'$maxSeconds','$strictMode','$maxSeconds')";
        $result = mysqli_query($connection, $insertStrictMode);
    }

?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='./style.css'>
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/fontawesome.css">
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' rel='stylesheet'>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <title>Feed -
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

        .getEndDate {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid black;
        }

        .time-item
        {
            background-color: rebeccapurple;
        }
        #setMaxHours{
            padding: 8px;
            border: none;
        }

    </style>
    <?php echo "<script>localStorage.setItem('mp-uid','" . $_SESSION['user']['uid'] . "')</script>"; ?>

</head>

<body>
    <?php
    include_once("./parts/navbar.php");
    include_once("./parts/leftSidebar.php");
    ?>

    <?php
        $getStrictModeInfo = "SELECT * FROM `strict_mode` WHERE `uid`='$uid' AND `endStrictDate`=CURDATE()";
        $result = mysqli_query($connection, $getStrictModeInfo);
        $result = mysqli_fetch_assoc($result);
    ?>
    <div class='mid-body'>
        <?php 
            if($result==null)
            {
        ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="left-inner-heading">
                <span class="dim-label">
                    <b>Strict Mode</b>
                </span>
                <hr class="label-underline">
                <span class="dim-label">
                    Strict Mode helps you to better focus on your work.
                </span>
            </div>
            <br>

            <br>
            <div>
                <label for="getEndDate">Set max access hours :</label>
                <select name="setMaxHours" id="setMaxHours"></select>
            </div>
            <p id="getBaki"></p>
            <br>
            <div class="warningWrapper">
                <label for="exceedTimeWarning">Get notified before 15 minutes of access limit time :</label>
                <input type="checkbox" name="exceedTimeWarning" id="exceedTimeWarning">
            </div>
            <br>
            <div>
                <button id="" style="width:100%;padding:5px;" type="submit">Enter Strict Mode</button>
            </div>
        </form>
        <?php
            }else{
                
                ?>
                <div class="left-inner-heading">
                <span class="dim-label">
                    <b>Strict Mode</b>
                </span>
                <hr class="label-underline">
                <span class="dim-label">
                    Strict Mode helps you to better focus on your work.
                </span>
            </div>
                    Strict Mode is Running
                    <?php echo number_format((float)($result['availableAccessSeconds']/60),2). " minutes left till end of ".$result['endStrictDate']; ?>
                <?php
            }
            ?>
    </div>
    <?php
    include_once("./parts/rightSidebar.php");
    ?>

</body>
<script src='./assets/scripts/jquery.js'></script>
    <script>
        let dateObj = new Date();
        let currentTime = dateObj.toLocaleDateString();
        let setMaxHours =document.getElementById("setMaxHours");
        let timeCount = 0;
        for (let currentHour = dateObj.getHours(); currentHour <= 23; currentHour++) {
            timeCount += 1;
            setMaxHours.innerHTML += `
                <option class="time-item" value="${timeCount*60*60}">${timeCount} Hours</option>
            `
        }



        $.ajax({
            url: "./server/api/strict-mode/check_strict_mode.php",
            type: "POST",
            success:function (getStatus)
            {
                console.log(getStatus);
            },
            error:function()
            {
                console.log("failed");
            }
        })
    </script>

</html>