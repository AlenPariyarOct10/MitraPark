<?php

include_once("./server/db_connection.php");
include_once("./server/validation.php");
include_once("./server/functions.php");

if(session_status()!=PHP_SESSION_ACTIVE)
{
    session_start();
}

$aboutSite = $connection->query("SELECT * FROM `system_data`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);




if(isset($_POST['email']) && isset($_POST['password']))
{
    $email = htmlspecialchars($_POST['email']);
    $psw = htmlspecialchars($_POST['password']);
    loginUser($email, $psw);
}

$uid = $_SESSION['user']['uid'];

$updateWarningNotified = "SELECT * FROM `strict_mode` WHERE `uid`='$uid' AND `strictMode`=1";
$updateWarningNotified = mysqli_query($connection, $updateWarningNotified);

if(mysqli_affected_rows($connection)>0)
{
    $updateWarningNotified = "UPDATE `strict_mode` SET `getWarning`=0 WHERE `uid`='$uid' AND `strictMode`=1";
    $updateWarningNotified = mysqli_query($connection, $updateWarningNotified);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeout Warning -
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
        <img id="logo" src="<?php echo ".".$aboutSite['system_logo']; ?>" alt="logo">
        <h1>
            <?php echo $aboutSite['system_name']; ?>
        </h1>
        <span id="description">
            <?php echo $aboutSite['system_description']; ?>
        </span>
    </div>
    <div class="right">
  
        <span class="page-title">Strict Mode - Remainder for Timeout</span>
        <div class="signup-error">15 minutes left for to start strict mode lock.</div>
        <button id="goBack">< Go Back</button>
        <a style="padding: 20px; margin:20px;background-color:lightgreen;" href="logout.php">Logout</a>
    </div>
</body>
<script>
    document.getElementById("goBack").addEventListener("click",()=>{
        window.location.href = history.back();
    })
</script>

</html>