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
    <title>Timeout -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="./assets/css/all.css">
  <link rel="stylesheet" href="./assets/css/fontawesome.css">
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
    if(isset($_SESSION['userNotFound'])){
        if($_SESSION['userNotFound']==true)
        {
            echo '<div class="signup-error">Couldn"t find user.</div>';
        }
    }

    ?>
        <span class="page-title">Strict Mode - Timeout</span>
        <div class="signup-error">Strict Mode is Active till the end of <?php echo date("M d, Y"); ?>.</div>
        <a href="feed.php">Reload</a>
        <a style="padding: 20px; margin:20px;background-color:lightgreen;" href="logout.php">Logout</a>
    </div>
</body>
<script>
    
</script>

</html>