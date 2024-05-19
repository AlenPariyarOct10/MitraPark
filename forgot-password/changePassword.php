<?php
include_once("../server/db_connection.php");
include_once("../server/validation.php");
include_once("../server/functions.php");
$aboutSite = $connection->query("SELECT * FROM `system_data`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);

if($_SERVER['REQUEST_METHOD']==="POST" && $_POST['uid'] && $_POST['otp'] && $_POST['password'] && $_POST['cpassword'])
{
    $formOTP = base64_decode($_POST['otp']);
    $formUid = base64_decode($_POST['uid']);
    $formOTP = htmlspecialchars($formOTP);
    $formUid = htmlspecialchars($formUid);
    $formPassword = htmlspecialchars($_POST['password']);
    $formCpassword = htmlspecialchars($_POST['cpassword']);

    $db_otp = "SELECT `code`, `created_timestamp` FROM OTP where `uid` = '$formUid'";
    $db_otp = mysqli_query($connection, $db_otp);
    $db_otp = mysqli_fetch_assoc($db_otp);

    $current_time = time();
    $created_time = strtotime($db_otp['created_timestamp']);
    $valid_time = 5*60;

    if($formPassword!==$formCpassword)
    {
        echo "<script>alert('Please enter valid Password and Confirm password');</script>";
    }else{
    

    if(($current_time - $created_time < $valid_time))
    {
        if(password_verify($formOTP,$db_otp['code']))
        {
            $newPassword = password_hash($formPassword, PASSWORD_DEFAULT);
            $updatePassword = "UPDATE `users` SET `password`='$newPassword' WHERE `uid`='$formUid'";
            $updateStatus = mysqli_query($connection, $updatePassword);
            header("Location: ../login.php?change_password_status=1");
            
        }else{
            echo "<script>alert('Invalid OTP');</script>";
            header("Location: ../login.php?change_password_status=0 ");
        }
    }else{
        header("Location: ../login.php?change_password_status=0");

    }
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/signup.css">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.css">

</head>

<body>
    <div class="left">
        <img id="logo" src=" <?php echo "..".$aboutSite['system_logo']; ?>" alt="logo">
       

        <h1>
            <?php echo $aboutSite['system_name']; ?>
        </h1>
        <span id="description">
            <?php echo $aboutSite['system_description']; ?>
        </span>
    </div>
    <div class="right">
        <span class="page-title">Change Password</span>
        <?php
            if(isset($_GET['userExists'])){echo '<div class="signup-error">User already exists.</div>';}else
            if(isset($check)){if(!$check){echo '<div class="signup-error">Unable to signup. Please check your input and try again later.</div>';}}
        ?>
        
        <form action="changePassword.php" autocomplete="false" method="post">
            <?php
                if(isset($_GET['uid']))
                {
                    echo '<input type="hidden" name="uid" value="'.$_GET['uid'].'">';
                }

                if(isset($_GET['otp']))
                {
                    echo '<input type="hidden" name="otp" value="'.$_GET['otp'].'">';
                }
            ?>
            <input class="inp-fields" type="password" placeholder="Password" name="password" id="password">
            <input class="inp-fields" type="password" placeholder="Confirm Password" name="cpassword" id="cpassword">
            <span id="verification-status">
                <p><i id="checkLowerCase" class="fa-solid fa-circle-xmark"></i>
                    At least one lower case letter
                </p>
                <p><i id="checkUpperCase" class="fa-solid fa-circle-xmark"></i>
                    At least one upper case letter
                </p>
                <p><i id="checkNumber" class="fa-solid fa-circle-xmark"></i>
                    At least one number
                </p>
                <p><i id="checkSpecialChar" class="fa-solid fa-circle-xmark"></i>
                    At least one special character
                </p>
                <p><i id="checkLength" class="fa-solid fa-circle-xmark"></i>
                    Be at least 12 characters
                </p>
                <p><i id="checkCpassword" class="fa-solid fa-circle-xmark"></i>
                    Password and Confirm password must match
                </p>
            </span>
            <button type="submit" name="submit" id="submit" class="btn login-btn">Change Password</button>
        </form>
        <div id="underline"></div>
        <a href="../signup.php" class="btn">Signup</a>
    </div>
</body>
<script>
    let passwordField = document.getElementById("password");
    let submitBtn = document.getElementById("submit");
    let confirmPasswordField =document.getElementById("cpassword");


    let allowPassword = false;
    let allowCpassword = false;

    confirmPasswordField.addEventListener("keyup",()=>{
        if(passwordField.value === confirmPasswordField.value && allowPassword==true)
        {
            allowCpassword = true;
            document.getElementById("checkCpassword").classList.remove("fa-circle-xmark");
            document.getElementById("checkCpassword").classList.add("fa-circle-check");
        }else{
            allowCpassword = false;
            document.getElementById("checkCpassword").classList.add("fa-circle-xmark");
            document.getElementById("checkCpassword").classList.remove("fa-circle-check");
        }
        controlSubmit();
    })
   

    submitBtn.disabled = true;
    submitBtn.style.cursor = "not-allowed";
    submitBtn.style.backgroundColor = "#6c757d";

    passwordField.addEventListener("input", () => {
        if (passwordField.value.length >= 12 && passwordField.value.length <= 18) {
            document.getElementById("checkLength").classList.remove("fa-circle-xmark");
            document.getElementById("checkLength").classList.add("fa-circle-check");
            allowPassword = true;
        } else {
            allowPassword = false;
            document.getElementById("checkLength").classList.remove("fa-circle-check");
            document.getElementById("checkLength").classList.add("fa-circle-xmark");
            
        }

        let specialCharRule = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        if(specialCharRule.test(passwordField.value))
        {
            
            document.getElementById("checkSpecialChar").classList.remove("fa-circle-xmark");
            document.getElementById("checkSpecialChar").classList.add("fa-circle-check");
            allowPassword = true;

        }else{
            document.getElementById("checkSpecialChar").classList.add("fa-circle-xmark");
            document.getElementById("checkSpecialChar").classList.remove("fa-circle-check");
            allowPassword = false;

        }

        let checkNumberRule = /[0-9]/;
        if(checkNumberRule.test(passwordField.value))
        {
            document.getElementById("checkNumber").classList.remove("fa-circle-xmark");
            document.getElementById("checkNumber").classList.add("fa-circle-check");
            allowPassword = true;

        }else{
            document.getElementById("checkNumber").classList.add("fa-circle-xmark");
            document.getElementById("checkNumber").classList.remove("fa-circle-check");
            allowPassword = false;

        }

        let checkUpperCase = /[A-Z]/;
        if(checkUpperCase.test(passwordField.value))
        {
            document.getElementById("checkUpperCase").classList.remove("fa-circle-xmark");
            document.getElementById("checkUpperCase").classList.add("fa-circle-check");
            allowPassword = true;
        }else{
            document.getElementById("checkUpperCase").classList.add("fa-circle-xmark");
            document.getElementById("checkUpperCase").classList.remove("fa-circle-check");
            allowPassword = false;
        }

        let checkLowerCase = /[a-z]/;
        if(checkLowerCase.test(passwordField.value))
        {
            document.getElementById("checkLowerCase").classList.remove("fa-circle-xmark");
            document.getElementById("checkLowerCase").classList.add("fa-circle-check");
            allowPassword = true;
            
        }else{
            document.getElementById("checkLowerCase").classList.add("fa-circle-xmark");
            document.getElementById("checkLowerCase").classList.remove("fa-circle-check");
            allowCpassword = false;
        }

        if(passwordField.value === confirmPasswordField.value && allowPassword==true)
        {
            allowCpassword = true;
            document.getElementById("checkCpassword").classList.remove("fa-circle-xmark");
            document.getElementById("checkCpassword").classList.add("fa-circle-check");
        }else{
            allowCpassword = false;
            document.getElementById("checkCpassword").classList.add("fa-circle-xmark");
            document.getElementById("checkCpassword").classList.remove("fa-circle-check");
        }

        controlSubmit();
    });

    function controlSubmit() {
        if (allowPassword && allowCpassword ) {
            submitBtn.disabled = false;
            submitBtn.style.cursor = "pointer";
            submitBtn.style.backgroundColor = "#28a745";
        } else {
            submitBtn.disabled = true;
            submitBtn.style.cursor = "not-allowed";
            submitBtn.style.backgroundColor = "#6c757d";
        }
    }
</script>

</html>