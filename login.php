<?php

include_once("./server/db_connection.php");

$aboutSite = $connection->query("SELECT * FROM `about_system`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);

$mainLogo = 'http://' . $_SERVER['HTTP_HOST'] . $aboutSite['logo'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login -
        <?php echo $aboutSite['name']; ?>
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
            <?php echo $aboutSite['name']; ?>
        </h1>
        <span>
            <?php echo $aboutSite['description']; ?>
        </span>
    </div>
    <div class="right">
        <span class="page-title">Login</span>
        <form action="get_login.php" method="post">
            <input placeholder="Email" class="inp-fields" type="email" name="email" id="email">
            <input placeholder="Password" class="inp-fields" type="password" name="password" id="password">
            <button type="submit" id="submit" class="btn login-btn">Login</button>
        </form>
        
        <a href="">Forgot Password</a>
        <div id="underline"></div>
        <a class="btn" href="">Create a account</a>
    </div>
</body>
<script>
    let emailField = document.getElementById("email");
    let passwordField = document.getElementById("password");
    let submitBtn =document.getElementById("submit");

    
</script>

</html>