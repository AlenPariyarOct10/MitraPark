<?php

include_once ('./parts/entryCheck.php');
include_once ('./server/db_connection.php');
include_once ('./server/validation.php');
include_once ('./server/functions.php');


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="./assets/css/navbar.css">
    
    <link
        href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap'
        rel='stylesheet'>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <title>Change Password -
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

        .inp-field-item {
            width: 100%;
            border: none;
            outline: none;
            margin-left: 5px;
            margin-right: 5px;

        }

        .inp-field {
            border: 1px solid black;
            padding: 5px;
            border-radius: 10px;
            margin-left: 5px;
            margin-right: 5px;
        }

        .contents {
            margin: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="submit"] {
            margin-top: 10px;
            padding: 8px 20px 8px 20px;
            border: none;
            cursor: pointer;
            border-radius: 15px;
            background-color: #C6EBC5;
        }

        input[type="submit"]:hover {
            background-color: #C6EBC5;
        }

        .fa-circle-xmark{
            color: red;
        }

        .fa-circle-check{
            color: green;
        }
    </style>
    <?php include_once("../MitraPark/assets/css/dynamicColor.php"); ?>

    <?php echo "<script>localStorage.setItem('mp-uid','" . $_SESSION['user']['uid'] . "')</script>"; ?>

</head>

<body>


    <?php
    include_once ("./parts/navbar.php");
    include_once ("./parts/leftSidebar.php");
    ?>
    <div class="mid-body">
        <div class="left-inner-heading">
            <span class="dim-label">
                Change password
            </span>
            <hr class="label-underline">
        </div>
        <?php
        if (isset ($_POST['currentPassword']) && isset ($_POST['newPassword1']) && isset ($_POST['newPassword2'])) {
            $currentPassword = htmlspecialchars($_POST['currentPassword']);
            $newPassword1 = htmlspecialchars($_POST['newPassword1']);
            $newPassword2 = htmlspecialchars($_POST['newPassword2']);

            if (validate_password($currentPassword) && validate_cpassword($newPassword1, $newPassword2)) {
                echo (changePassword($_SESSION['user']['uid'], $currentPassword, $newPassword1))?'<div class="signup-success">Password Changed Succesfully</div>':'<div class="signup-error">Unable to change password.</div>';
            } else {
                echo '<div class="signup-error">Invalid password.</div>';
            }
        }
        ?>
        <form class="contents" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-item">
                <label for="currentPassword">Current password</label>
                <div class="inp-field">
                    <input type="text" class="inp-field-item" name="currentPassword" id="currentPassword">
                </div>
            </div>
            <div class="form-item">

                <label for="newPassword1">New password</label>
                <div class="inp-field">
                    <input type="text" class="inp-field-item" name="newPassword1" id="newPassword1">
                </div>
            </div>
            <div class="form-item">

                <label for="newPassword2">Confirm password</label>
                <div class="inp-field">
                    <input type="text" class="inp-field-item" name="newPassword2" id="newPassword2">
                </div>
                
            </div>
            <span id="verification-status">
                <p><i id="checkCurrentPassword" class="fa-solid fa-circle-xmark"></i>
                    Valid current password
                </p>
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
            
            <div class="form-item">
                <input type="submit" id="submit" value="Change">
            </div>
        </form>
    </div>
    <?php
    include_once ("./parts/rightSidebar.php");
    ?>
    <script src='./assets/scripts/jquery.js'></script>
    <script>
    let currentPassword =document.getElementById("currentPassword");
    let passwordField = document.getElementById("newPassword1");
    let submitBtn = document.getElementById("submit");
    let confirmPasswordField =document.getElementById("newPassword2");
    let errorText = document.querySelectorAll('.errorText');

    let allowPassword = false;
    let allowCpassword = false;
    let allowCurrentPassword = false;

        currentPassword.addEventListener("keyup",()=>{
            checkCurrentPassword();
            controlSubmit();
        })

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


    passwordField.addEventListener("keyup", () => {
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

    function checkCurrentPassword()
    {
        $.ajax({
            url: "./server/api/other/check-password-api.php",
            type: "GET",
            data: {
                uid: <?php echo $uid; ?>,
                formPassword: currentPassword.value,
            },
            success: (response)=>{
                let currentPasswordStatus = JSON.parse(response);
                if(currentPasswordStatus.status === true)
                {
                    $("#checkCurrentPassword").removeClass("fa-circle-xmark");
                    $("#checkCurrentPassword").addClass("fa-circle-check");
                    allowCurrentPassword = true;
                    controlSubmit();
                }else{
                    $("#checkCurrentPassword").removeClass("fa-circle-check");
                    $("#checkCurrentPassword").addClass("fa-circle-xmark");
                    allowCurrentPassword = false;
                    controlSubmit();

                }
            },
            error: (response)=>{
                    $("#checkCurrentPassword").removeClass("fa-circle-check");
                    $("#checkCurrentPassword").addClass("fa-circle-xmark");
                    allowCurrentPassword = false;
                    controlSubmit();

            }
        })
    }
    

    function controlSubmit() {
        if ( allowPassword && allowCpassword && allowCurrentPassword) {
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
</body>

</html>