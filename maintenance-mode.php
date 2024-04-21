<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');



     $checkMaintenanceMode = "SELECT `maintenance_mode` FROM `system_data` WHERE 1";
     $checkMaintenanceMode = mysqli_query($connection, $checkMaintenanceMode);
     $checkMaintenanceMode = mysqli_fetch_assoc($checkMaintenanceMode);
     if($checkMaintenanceMode['maintenance_mode']==='0')
     {
         header("Location: feed.php");
     }


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>
<!doctype html>
<title><?php echo $aboutSite['system_name']; ?> ~ Under Maintenance</title>
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
</style>

<article>
    <img height="100px" src="./assets/images/work-in-progress.png" alt="">
    <h1>We'll be back soon!</h1>
    <div>
        <p>Sorry for the inconvenience. We&rsquo;re performing some maintenance at the moment. 
        <p>- The <b><?php echo $aboutSite['system_name']; ?></b> Team</p>
    </div>
</article>