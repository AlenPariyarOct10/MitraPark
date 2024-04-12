<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');

$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>

<?php 
$uid = $_SESSION['user']['uid'];
$getStrictModeInfo = "SELECT * FROM `strict_mode` WHERE `uid`='$uid' AND `endStrictDate`=CURDATE()";
$result = mysqli_query($connection, $getStrictModeInfo);
$result = mysqli_fetch_assoc($result);

    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    if($result==null)
    {
            if(isset($_POST['setMaxHours']) && isset($_POST['setMaxMinutes']) && isset($_POST['setMaxSeconds']))
            {

                if(isset($_POST['setMaxHours']) && isset($_POST['setMaxMinutes']) && isset($_POST['setMaxSeconds']))
                {
                    $totalMax = ((int)$_POST['setMaxHours']*60*60)+((int)$_POST['setMaxMinutes']*60)+((int)$_POST['setMaxSeconds']);
                    if($totalMax > 0)
                    {
                        $getNotifications = 0;
            
                        if(isset($_POST['exceedTimeWarning']))
                        {
                            $getNotifications = 1;
                        }
    
                        $strictMode = 1;
                        $insertStrictMode = "INSERT INTO `strict_mode`(`uid`, `getWarning`, `endStrictDate`, `maxAccessSeconds`, `strictMode`, `availableAccessSeconds`) VALUES ('$uid','$getNotifications',CURDATE(),'$totalMax','$strictMode','$maxSeconds')";
                        $result = mysqli_query($connection, $insertStrictMode);
                    }else{

                    }

                }
        }
    }
    
    

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
    <link rel="stylesheet" href="./assets/css/all.min.css">
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
        .timeSelector{
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
                <select name="setMaxHours" class="timeSelector" id="setMaxHours"></select>
                <select name="setMaxMinutes" class="timeSelector" id="setMaxMinutes"></select>
                <select name="setMaxSeconds" class="timeSelector" id="setMaxSeconds"></select>
            </div>
            
            <p id="getBaki"></p>
            <br>
            <div class="warningWrapper">
                <label for="auto-renew">Automatically activate Strict Mode everyday :</label>
                <input type="checkbox" name="auto-renew" id="auto-renew">
            </div>
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

        // Populating hours
        let setMaxHours = document.getElementById("setMaxHours");
        for (let currentHour = 0; currentHour <= 24; currentHour++) {
            setMaxHours.innerHTML += `<option value="${currentHour}">${currentHour} Hours</option>`;
        }

        // Populating minutes
        let setMaxMinutes = document.getElementById("setMaxMinutes");
        for (let currentMinute = 0; currentMinute <= 60; currentMinute++) {
            setMaxMinutes.innerHTML += `<option value="${currentMinute}">${currentMinute} Minutes</option>`;
        }

        // Populating seconds
        let setMaxSeconds = document.getElementById("setMaxSeconds");
        for (let currentSecond = 0; currentSecond <= 60; currentSecond++) {
            setMaxSeconds.innerHTML += `<option value="${currentSecond}">${currentSecond} Seconds</option>`;
        }




        // $.ajax({
        //     url: "./server/api/strict-mode/check_strict_mode.php",
        //     type: "POST",
        //     success:function (getStatus)
        //     {
        //         console.log(getStatus);
        //     },
        //     error:function()
        //     {
        //         console.log("failed");
        //     }
        // })
    </script>

</html>