<?php

include_once("../server/db_connection.php");
include_once("../server/validation.php");
include_once("../server/functions.php");



if(session_status()!=PHP_SESSION_ACTIVE)
{
    session_start();    
}

if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['otp']) && isset($_POST['uid']))
{
    $formOTP = $_POST['otp'];
    $formUid = $_POST['uid'];
    $formOTP = htmlspecialchars($formOTP);
    $formUid = htmlspecialchars($formUid);

    $db_otp = "SELECT `code`, `created_timestamp` FROM OTP where `uid` = '$formUid'";
    $db_otp = mysqli_query($connection, $db_otp);
    $db_otp = mysqli_fetch_assoc($db_otp);

    $current_time = time();
    $created_time = strtotime($db_otp['created_timestamp']);
    $valid_time = 5*60;

    if(($current_time - $created_time < $valid_time))
    {
        if(password_verify($formOTP,$db_otp['code']))
        {
            $e_otp = base64_encode($formOTP);
            $e_uid = base64_encode($formUid);
            header("Location: changePassword.php?otp=".$e_otp."&uid=".$e_uid);
        }else{
            echo "<script>alert('Invalid OTP');</script>";

        }
    }
    else{
        echo "<script>alert('OTP Expired');</script>";
    }
    
}



if(isset($_SESSION['loggedInAdmin']))
{
  if($_SESSION['loggedInAdmin']==true)
  {
    header("Location: ./admin/");
  }
}

if(isset($_SESSION['loggedIn']))
{
    if($_SESSION['loggedIn']==true)
    {
        header("Location: feed.php");
    }
}

$aboutSite = $connection->query("SELECT * FROM `system_data`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);


$aboutSite['system_logo'];

if(isset($_POST['email']) && isset($_POST['password']))
{
    $email = htmlspecialchars($_POST['email']);
    $psw = htmlspecialchars($_POST['password']);
    loginUser($email, $psw);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="./assets/css/all.css">
  <link rel="stylesheet" href="./assets/css/fontawesome.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">

</head>

<body>
    <div class="left">
 
        <img id="logo" src="<?php echo "..".$aboutSite['system_logo']; ?>" alt="logo">
        <h1>
            <?php echo $aboutSite['system_name']; ?>
        </h1>
        <span id="description">
            <?php echo $aboutSite['system_description']; ?>
        </span>
    </div>
    <div class="right">
    <?php    
    if(isset($_GET['1'])){echo '
    <div class="signup-success">Account created Successfully. Please Login to continue.</div>
        ';}
    if(isset($_GET['loginFirst'])){
        echo '<div class="signup-success">Please Login to continue.</div>';
    }
    if(isset($_SESSION['userNotFound'])){
        if($_SESSION['userNotFound']==true)
        {
            echo '<div class="signup-error">Couldn"t find user.</div>';
        }
    }

    ?>
        <span class="page-title">Verify OTP</span>
        <p style="padding: 15px; color:#524C42;">Please enter the OTP we've sent in your Email address to reset your password.</p>
        <form action="verifyOTP.php" method="post">
            <input placeholder="OTP" class="inp-fields" type="number" name="otp" id="otp">

            <?php
                if(isset($_GET['user']))
                {
                    $opt_uid = base64_decode($_GET['user']);
                    echo '<input type="hidden" name="uid" value="'.$opt_uid.'">';
                }
            ?>
            <button type="submit" id="submit" class="btn login-btn">Verify</button>
            
        </form>
        
        <div id="underline"></div>
        <a class="btn" href="../signup.php">Create a account</a>
       
    </div>
</body>
<script>
    let otp = document.getElementById("otp");

    let submitBtn =document.getElementById("submit");

    // Rule for OTP Field
    let otpRule = /^(?=.*[1-9])[0-9]{6}$/;

    let allowOTP = false;

    submitBtn.disabled = true;
    submitBtn.style.cursor = "not-allowed";
    submitBtn.style.backgroundColor = "#6c757d";

    function controlSubmit()
    {
        if(allowOTP == true)
        {
            submitBtn.disabled = false;
            submitBtn.style.cursor = "pointer";
            submitBtn.style.backgroundColor = "#28a745";
        }else{
            submitBtn.disabled = true;
            submitBtn.style.cursor = "not-allowed";
            submitBtn.style.backgroundColor = "#6c757d";
        }
    }

    otp.addEventListener("keyup",()=>{
        if(otpRule.test(otp.value))
        {
            allowOTP = true;
        }else{
            allowOTP = false;
        }

        controlSubmit();
    });


</script>

</html>