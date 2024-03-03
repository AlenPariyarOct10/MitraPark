<?php

include_once("./server/db_connection.php");
include_once("./server/validation.php");
include_once("./server/functions.php");

$aboutSite = $connection->query("SELECT * FROM `system_data`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);


$mainLogo = 'http://' . $_SERVER['HTTP_HOST'] . $aboutSite['system_logo'];

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
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">

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
    <?php    
    if(isset($_GET['1'])){echo '
    <div class="signup-success">Account created Successfully. Please Login to continue.</div>
        ';}
    if(isset($_GET['loginFirst'])){
        echo '<div class="signup-success">Please Login to continue.</div>';
    }

    ?>
        <span class="page-title">Login</span>
        <form action="login.php" method="post">
            <input placeholder="Email" class="inp-fields" type="email" name="email" id="email">
            <input placeholder="Password" class="inp-fields" type="password" name="password" id="password">
            <button type="submit" id="submit" class="btn login-btn">Login</button>
        </form>
        
        <a href="">Forgot Password</a>
        <div id="underline"></div>
        <a class="btn" href="signup.php">Create a account</a>
       
    </div>
</body>
<script>
    let emailField = document.getElementById("email");
    let passwordField = document.getElementById("password");
    let submitBtn =document.getElementById("submit");

    // Rule for Email Field
    let emailRule = /^[a-z0-9._-]+@[a-z0-9]+\.[a-z0-9]{2,4}$/;

    let allowEmail = false;
    let allowPassword = false;

    submitBtn.disabled = true;
    submitBtn.style.cursor = "not-allowed";
    submitBtn.style.backgroundColor = "#6c757d";


    // Controls submit button by validating email and password field
    function controlSubmit()
    {
        if(allowEmail == true && allowPassword == true)
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

    emailField.addEventListener("keyup",()=>{
        if(emailRule.test(emailField.value))
        {
            allowEmail = true;
        }else{
            allowEmail = false;
        }

        controlSubmit();
    });


    passwordField.addEventListener("keyup",()=>{
        if(passwordField.value.length >= 8 && passwordField.value.length <=16 )
        {
            allowPassword = true;
        }else{
            allowPassword = false;
        }
        controlSubmit();
    });
</script>

</html>