<?php
include_once("./server/db_connection.php");
include_once("./server/validation.php");
include_once("./server/functions.php");
$aboutSite = $connection->query("SELECT * FROM `system_data`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);


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
    <link rel="stylesheet" href="./assets/css/signup.css">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/fontawesome.css">

</head>

<body>
    <div class="left">
        <img id="logo" src=" <?php echo ".".$aboutSite['system_logo']; ?>" alt="logo">
       

        <h1>
            <?php echo $aboutSite['system_name']; ?>
        </h1>
        <span id="description">
            <?php echo $aboutSite['system_description']; ?>
        </span>
    </div>
    <div class="right">
        <span class="page-title">Signup</span>
        <?php
            if(isset($_GET['userExists'])){echo '<div class="signup-error">User already exists.</div>';}else
            if(isset($check)){if(!$check){echo '<div class="signup-error">Unable to signup. x Please check your input and try again later.</div>';}}
        ?>
        
        <form action="./auth/verify-email.php" autocomplete="false" method="post">
            <div class="single-line">
                <input placeholder="First Name" class="inp-fields nameFields" type="text" name="fname" id="fname">
                <input placeholder="Last Name" class="inp-fields nameFields" type="text" name="lname" id="lname">
            </div>
            <span id="namingError"></span>
            <input class="inp-fields" type="email" placeholder="Email" name="email" id="email">
            <span id="emailError"></span>
           
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
            <button type="submit" name="check" id="submit" class="btn login-btn">Signup</button>
        </form>
        <div id="underline"></div>
        <a href="login.php" class="btn">Login</a>
    </div>
</body>
<script>
    let emailField = document.getElementById("email");
    let passwordField = document.getElementById("password");
    let submitBtn = document.getElementById("submit");
    let nameFields = document.querySelectorAll(".nameFields");
    let confirmPasswordField =document.getElementById("cpassword");
    let fname =document.getElementById("fname");
    let lname =document.getElementById("lname");

    let nameRule = /^[a-zA-Z]{2,10}$/;
    let lnameRule = /^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/;
    let emailRule = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    let errorText = document.querySelectorAll('.errorText');

     // Rule for Email Field
    let allowEmail = false;
    let allowPassword = false;
    let allowName = false;
    let allowCpassword = false;

    fname.addEventListener("input", ()=>{
        let currentDiv = document.querySelector('.single-line');
            if (nameRule.test(fname.value) == false) {
                allowName = false;
                document.getElementById("namingError").innerHTML = "Numbers, Spaces, Special characters aren't allowed.";
            } else {
                allowName = true;
                document.getElementById("namingError").innerHTML = "";
            }
            controlSubmit();
    })

    lname.addEventListener("input",()=>{
        let currentDiv = document.querySelector('.single-line');
            if (lnameRule.test(lname.value) == false) {
                allowName = false;
                document.getElementById("namingError").innerHTML = "Numbers and Special characters aren't allowed.";
            } else {
                allowName = true;
                document.getElementById("namingError").innerHTML = "";
            }

            function countOccurrences(str, char) {
                const regex = new RegExp(char, 'g');
                return (str.match(regex) || []).length;
            }

            if(countOccurrences(lname.value, " ")>1)
            {
                allowName = false;
                document.getElementById("namingError").innerHTML = "Only one space is allowed.";
            }
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

   
   

    emailField.addEventListener("input", () => {
        if (emailRule.test(emailField.value)) {
            allowEmail = true;
            document.getElementById("emailError").innerHTML = "";
        } else {
            document.getElementById("emailError").innerHTML = "Invalid email";
            allowEmail = false;
        }
        controlSubmit();
    });

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
        if (allowEmail && allowPassword && allowName && allowCpassword ) {
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