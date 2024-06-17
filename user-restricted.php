<?php

// include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
// include_once('./server/validation.php');
// include_once('./server/functions.php');

    if(session_status()!==PHP_SESSION_ACTIVE)
    {
        session_start();
    }
    $uid = $_SESSION['user']['uid'];
     $checkRestricted = "SELECT `status` FROM `users` WHERE `uid`='$uid'";
     $checkRestricted = mysqli_query($connection, $checkRestricted);
     $checkRestricted = mysqli_fetch_assoc($checkRestricted);
     if($checkRestricted['status']==='active')
     {
         header("Location: feed.php");
     }


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>
<!doctype html>
<html>
    <head>
<title><?php echo "🚫".$aboutSite['system_name']; ?> ~ Restricted</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
<link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">

<style>
    html,
    body {
        padding: 0;
        margin: 0;
        width: 100%;
        height: 100%;
    }

   

    body {
        text-align: center;
        padding: 0;
        background: #d6433b;
        color: #fff;
        font-family: Open Sans;
    }

    h1 {
        font-size: 50px;
        font-weight: 100;
        text-align: center;
    }

    body {
        font-family: Open Sans;
        font-weight: 100;
        font-size: 20px;
        color: #fff;
        text-align: center;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    article {
        display: block;
        width: 700px;
        padding: 50px;
        margin: 0 auto;
    }

    a {
        color: #fff;
        font-weight: bold;
    }

    a:hover {
        text-decoration: none;
    }

    svg {
        width: 75px;
        margin-top: 1em;
    }

    .logout-btn{
        background-color: rgb(0, 199, 7);
        padding: 8px 15px 8px 15px;
        border-radius: 20px;
    }

    .logout-btn:hover{
        background-color: rgb(100, 199, 7);
        cursor: pointer;

    }
</style>
</head>
<body>
    

<article>
    <img height="100px" src="./assets/images/blocked.png" alt="">
    <h1>You're restricted from this platform!</h1>
    <div>
        <p>This is to inform you that we have identified a violation of our community standards associated with your account. This action has resulted in a restriction. 
        <p>- The <b><?php echo $aboutSite['system_name']; ?></b> Team</p>
        <div>
            <a style="text-decoration: none;" href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</article>
<script src="./assets/scripts/jquery.js"></script>

<script>
       function check_user_restricted_status()
    {
        $.ajax({
            url: "./server/api/other/check-user-restricted.php",
            type: "POST",
            data: {
                userId: <?php echo $_SESSION['user']['uid']; ?>,
            },
            success: function(status)
            {
                
                let statusOBJ = JSON.parse(status);

                if(statusOBJ["restricted-status"]==true)
                {
                    console.log(statusOBJ)
                    window.location.href = "user-restricted.php";
                }else{
                    window.location.href = "feed.php";
                }
            }
        })
    }

    setInterval(check_user_restricted_status, 5000);
</script>
</body>
