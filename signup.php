<?php
include_once("./server/db_connection.php");
include_once("./server/validation.php");
include_once("./server/functions.php");
$aboutSite = $connection->query("SELECT * FROM `system_data`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
$mainLogo = 'http://' . $_SERVER['HTTP_HOST'] . $aboutSite['system_logo'];

if (isset($_POST['submit'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);
    $check = false;
    $check = validate_signup($fname, $lname, $email, $phone, $password, $cpassword);

    if($check && !isExistingUser($email, $phone))
    {
        createUser($fname, $lname, $email, $phone, $password);
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
    <link rel="stylesheet" href="./assets/css/signup.css">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="left">
        <img id="logo" src="<?php echo $mainLogo; ?>" alt="mitrapark-logo">
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
            if(isset($email) && isset($phone)){if(isExistingUser($email, $phone)){echo "User Already Exists";}}
            if(isset($check)){if(!$check){echo '<div class="signup-error">Unable to signup. Please check your input and try again later.</div>';}}
        ?>
        
        <form action="signup.php" autocomplete="false" method="post">
            <div class="single-line">
                <input placeholder="First Name" class="inp-fields nameFields" type="text" name="fname" id="fname">
                <input placeholder="Last Name" class="inp-fields nameFields" type="text" name="lname" id="lname">
            </div>
            <span id="namingError"></span>
            <input class="inp-fields" type="email" placeholder="Email" name="email" id="email">
            <span id="emailError"></span>
            <input class="inp-fields" type="number" placeholder="Phone" name="phone" id="phone">
            <span id="phoneError"></span>
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
            </span>
            <button type="submit" name="submit" id="submit" class="btn login-btn">Signup</button>
        </form>
    </div>
</body>
<script>
    let emailField = document.getElementById("email");
    let passwordField = document.getElementById("password");
    let submitBtn = document.getElementById("submit");
    let nameFields = document.querySelectorAll(".nameFields");
    let phoneField = document.getElementById("phone");
    let confirmPasswordField =document.getElementById("cpassword");

    let nameRule = /^[a-zA-Z]{3,10}$/;
    let emailRule = /^[a-z0-9._-]+@[a-z0-9]+\.[a-z0-9]{2,4}$/;
    let errorText = document.querySelectorAll('.errorText');
    let phoneRule = /[0-9]\d{9}/;

     // Rule for Email Field
     let allowEmail = false;
    let allowPassword = false;
    let allowName = false;
    let allowPhone = false;
    let allowCpassword = false;

    nameFields.forEach((item) => {
        item.addEventListener("keyup", () => {
            let currentDiv = document.querySelector('.single-line');
            if (nameRule.test(item.value) == false) {
                allowName = false;
                document.getElementById("namingError").innerHTML = "Numbers and Special characters aren't allowed.";
            } else {
                allowName = true;
                document.getElementById("namingError").innerHTML = "";
            }
            controlSubmit();
        })
    })

    phoneField.addEventListener("keyup",()=>{
        if(!phoneRule.test(phoneField.value))
        {
            allowPhone = false;
            document.getElementById("phoneError").innerText = "Invalid Phone number";
        }else{
            allowPhone = true;
            document.getElementById("phoneError").innerText = "";

        }
        controlSubmit();
    });

    confirmPasswordField.addEventListener("keyup",()=>{
        if(passwordField.value == confirmPasswordField.value)
        {
            allowCpassword = true;
        }else{
            allowCpassword = false;
        }
        controlSubmit();
    })
   

    submitBtn.disabled = true;
    submitBtn.style.cursor = "not-allowed";
    submitBtn.style.backgroundColor = "#6c757d";

    // Controls submit button by validating email and password field
    function controlSubmit() {
        if (allowEmail && allowPassword && allowName && allowPhone && allowCpassword ) {
            submitBtn.disabled = false;
            submitBtn.style.cursor = "pointer";
            submitBtn.style.backgroundColor = "#28a745";
        } else {
            submitBtn.disabled = true;
            submitBtn.style.cursor = "not-allowed";
            submitBtn.style.backgroundColor = "#6c757d";
        }
    }

    emailField.addEventListener("keyup", () => {
        if (emailRule.test(emailField.value)) {
            allowEmail = true;
            document.getElementById("emailError").innerHTML = "";
        } else {
            document.getElementById("emailError").innerHTML = "Invalid email";
            allowEmail = false;
        }
        controlSubmit();
    });

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
        }else{
            document.getElementById("checkSpecialChar").classList.add("fa-circle-xmark");
            document.getElementById("checkSpecialChar").classList.remove("fa-circle-check");
        }

        let checkNumberRule = /[0-9]/;
        if(checkNumberRule.test(passwordField.value))
        {
            document.getElementById("checkNumber").classList.remove("fa-circle-xmark");
            document.getElementById("checkNumber").classList.add("fa-circle-check");
        }else{
            document.getElementById("checkNumber").classList.add("fa-circle-xmark");
            document.getElementById("checkNumber").classList.remove("fa-circle-check");
        }

        let checkUpperCase = /[A-Z]/;
        if(checkUpperCase.test(passwordField.value))
        {
            document.getElementById("checkUpperCase").classList.remove("fa-circle-xmark");
            document.getElementById("checkUpperCase").classList.add("fa-circle-check");
        }else{
            document.getElementById("checkUpperCase").classList.add("fa-circle-xmark");
            document.getElementById("checkUpperCase").classList.remove("fa-circle-check");
        }

        let checkLowerCase = /[a-z]/;
        if(checkLowerCase.test(passwordField.value))
        {
            document.getElementById("checkLowerCase").classList.remove("fa-circle-xmark");
            document.getElementById("checkLowerCase").classList.add("fa-circle-check");
        }else{
            document.getElementById("checkLowerCase").classList.add("fa-circle-xmark");
            document.getElementById("checkLowerCase").classList.remove("fa-circle-check");
        }
        controlSubmit();
    });
</script>

</html>