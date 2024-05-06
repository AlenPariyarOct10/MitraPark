<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');

$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
include_once("./server/auto-routes.php");

?>



<?php 
if($_SERVER['REQUEST_METHOD']=='POST')
{

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

                    $totalMax = ((int)$_POST['setMaxHours']*60*60)+((int)$_POST['setMaxMinutes']*60)+((int)$_POST['setMaxSeconds']);
                    if($totalMax > 0)
                    {
                        $getNotifications = 0;
                        $autoRenew = 0;
            
                        if(isset($_POST['exceedTimeWarning']))
                        {
                            $getNotifications = 1;
                        }
                        if(isset($_POST['auto-renew']))
                        {
                            $autoRenew = 1;
                        }
    
                        $strictMode = 1;

                        $checkExisting = "SELECT * FROM `strict_mode` WHERE `uid`='$uid'";
                        $checkExisting = mysqli_query($connection, $checkExisting);
                        $checkExisting = mysqli_fetch_assoc($checkExisting);

                        // var_dump($checkExisting);

                        if($checkExisting !=null)
                        {
                            $insertStrictMode = "UPDATE `strict_mode` SET 
                            `getWarning`='$getNotifications', 
                            `endStrictDate`=CURDATE(), 
                            `maxAccessSeconds`='$totalMax',
                            `strictMode`='$strictMode',
                            `availableAccessSeconds`='$totalMax',
                            `autoRenew`='$autoRenew'
                        WHERE `uid`='$uid'";
                        }else{
                            $insertStrictMode = "INSERT INTO `strict_mode`(`uid`, `getWarning`, `endStrictDate`, `maxAccessSeconds`, `strictMode`, `availableAccessSeconds`, `autoRenew`) VALUES ('$uid','$getNotifications',CURDATE(),'$totalMax','$strictMode','$totalMax', '$autoRenew')";

                        }
                        $result = mysqli_query($connection, $insertStrictMode);
                    }

        }
    }else{
        if(isset($_POST['setMaxHours']) && isset($_POST['setMaxMinutes']) && isset($_POST['setMaxSeconds']))
            {

                    $totalMax = ((int)$_POST['setMaxHours']*60*60)+((int)$_POST['setMaxMinutes']*60)+((int)$_POST['setMaxSeconds']);
                    if($totalMax > 0)
                    {
                        $getNotifications = 0;
                        $autoRenew = 0;
            
                        if(isset($_POST['exceedTimeWarning']))
                        {
                            $getNotifications = 1;
                        }
                        if(isset($_POST['auto-renew']))
                        {
                            $autoRenew = 1;
                        }
    
                        $strictMode = 1;
                        $updateStrictMode = "UPDATE `strict_mode` SET `getWarning`='$getNotifications', `endStrictDate`=CURDATE(), `maxAccessSeconds`='$totalMax', `strictMode`='$strictMode', `availableAccessSeconds`='$totalMax', `autoRenew`='$autoRenew' WHERE `uid`='$uid'";
                        $result = mysqli_query($connection, $updateStrictMode);
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
    <link rel="shortcut icon" href="./<?php echo $aboutSite['system_logo']; ?>" type="image/x-icon">

    <title>Strict Mode -
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

        .mid-body{
            justify-content: flex-start;
        }

        .btn{
            border: none;
            padding: 10px;
            width: 100%;
            background-color: var(--mp-color-1);
            border-radius: 10px;
            cursor: pointer;

        }

        .btn:hover{
            box-shadow: 0.9px 0.9px 0.9px 0.5px rgb(118, 118, 118);
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
 

    <?php
        $getStrictModeInfo = "SELECT * FROM `strict_mode` WHERE `uid`='$uid' AND `endStrictDate`=CURDATE() AND `strictMode`=1";
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
                <input type="checkbox" name="exceedTimeWarning" id="exceedTimeWarning" disabled>
            </div>
            <br>
            <div>
                <input class="btn" id="submitBtn" type="submit" name="send" value="Enter Strict Mode" disabled>
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
                    <span id="showRemaining"></span> remaining for today.
                    <a style="background-color: crimson; color: white; padding:6px; border-radius: 20px;margin-top:10px;" href="./server/api/strict-mode/removeStrictMode.php">Exit Strict Mode</a>
                <?php
            }
            ?>
    </div>
    <?php
    include_once("./parts/rightSidebar.php");
    ?>

</body>
<script src='./assets/scripts/jquery.js'></script>
<?php include_once("./parts/js-script-files/strict-and-activity-update.php"); ?>
    <script>
        function getRemainingTime()
        {
            $.ajax({
            url: "./server/api/strict-mode/check_strict_mode.php",
            type: "POST",
            success: (result)=>{
                let resultObj =JSON.parse(result);
                if(resultObj['strict-mode']==true && resultObj['getWarning']=="1" && resultObj['availableAccessSeconds']<=900)
                {
                    window.location.href = "timeOutWarn.php";
                }
                let hours = parseInt(Math.floor(resultObj['availableAccessSeconds']/(60*60)));
                let minutes = Math.floor(resultObj['availableAccessSeconds']/(60) - (hours*60));
                let seconds = resultObj['availableAccessSeconds'] - minutes*60 - hours*60*60;
                $("#showRemaining")[0].innerHTML = "";
                if(hours>0)
                {
                    $("#showRemaining")[0].innerHTML += hours+" Hours ";
                }
                if(minutes>0)
                {
                    $("#showRemaining")[0].innerHTML +=  minutes+" Minutes ";
                }
                if(seconds >0)
                {
                    $("#showRemaining")[0].innerHTML +=  seconds+" Seconds ";
                }

                
            }
        })
        }
        getRemainingTime();
        setInterval(()=>{
            getRemainingTime();
        }, 5000);
      

        let submitBtn =document.getElementById("submitBtn");
       
       

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

        
        let selectors = [setMaxHours, setMaxMinutes, setMaxSeconds];
        selectors.forEach((selector)=>{
        
            selector.addEventListener("change",()=>{
                
                const totalMins = parseInt(document.getElementById("setMaxHours").value)*60+parseInt(document.getElementById("setMaxMinutes").value)+(parseInt(document.getElementById("setMaxSeconds").value)/60);
                
                // console.log("total->",totalMins);
                if(totalMins<20)
                {
                    document.getElementById("exceedTimeWarning").disabled = true;
                }else{
                    document.getElementById("exceedTimeWarning").disabled = false;

                }

                if(totalMins>1)
                {
                    submitBtn.disabled = false;
                }else{
                    submitBtn.disabled  =true;
                }
            })
        })

       




       
    </script>

</html>