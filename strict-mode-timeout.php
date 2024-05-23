<?php

include_once("./server/db_connection.php");
include_once("./server/validation.php");
include_once("./server/functions.php");

session_start();

$aboutSite = $connection->query("SELECT * FROM `system_data`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);


$mainLogo = 'http://' . $_SERVER['HTTP_HOST'] . $aboutSite['system_logo'];

if(isset($_POST['email']) && isset($_POST['password']))
{
    $email = htmlspecialchars($_POST['email']);
    $psw = htmlspecialchars($_POST['password']);
    loginUser($email, $psw);
}

    $uid = $_SESSION['user']['uid'];
    $checkStrictMode = "SELECT * FROM `strict_mode` WHERE `uid`='$uid'";

    $result = mysqli_query($connection, $checkStrictMode);
    if(!$result){
        header("Location: feed.php");
        exit();
    }
    $result = mysqli_fetch_assoc($result);

   

    if($result['strictMode']==1 && $result['autoRenew']==1)
    {
        $today = date("Y-m-d");
        if(strtotime($result['today_date'])!=strtotime($today))
        {
            $renewStrictMode = "UPDATE `strict_mode` SET `today_date`='$today',`endStrictDate`='$today', `availableAccessSeconds`=`maxAccessSeconds` WHERE `uid`='$uid'";
            mysqli_query($connection, $renewStrictMode);
            header("Location: feed.php");

        }
    }else if($result['strictMode']==1 && $result['autoRenew']==0)
    {
        $today = date("Y-m-d");
        if(strtotime($result['today_date'])!=strtotime($today))
        {
            $delete = "DELETE FROM `strict_mode` WHERE `uid`='$uid'";
            mysqli_query($connection, $delete);
            header("Location: feed.php");
        }
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
    <style>
          /* ALEN : Content Space -----------------------*/
          .body{
            height: 80vh;
            position: relative;
        }

        .wrapper{
            position: absolute;
            background-color: #295fff5e;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            display: none;
        }

        .modal{
            background-color: #ffffff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            width: 50%;
            position: relative;

        }

        .modal-close{
            height: 30px;
            width: 30px;
            position: absolute;
            top: 0;
            right: 0;
            background-color: #FF204E;
            
            cursor: pointer;
        }

        .modal-close:hover{
            background-color: red;
        }

        .btn{
            border: none;
        }

        .btn-green{
            background-color: cadetblue;
        }

        .btn-red{
            background-color: #FF204E;
        }

    </style>

</head>

<body>
         <!-- Modal Wrapper -->
        <div class="wrapper">
        <div class="modal">
            <span class="modal-close">x</span>
            <form action="./server/api/strict-mode/removeStrictMode.php" method="POST">
            <div class="modal-head">
                <p class="modal-title">Are you sure you want to exit Strict mode?</p>
            </div>
            <hr>
            <div>
                <input class="btn btn-green" type="submit" value="Yes">
                <button class="btn btn-red closeModal" type="button">No</button>
            </div>
            
            </form>
        </div>
    </div>
    <div class="left">
        <img id="logo" src="./<?php echo $aboutSite['system_logo']; ?>" alt="logo">
        <h1>
            <?php echo $aboutSite['system_name']; ?>
        </h1>
        <span id="description">
            <?php echo $aboutSite['system_description']; ?>
        </span>
    </div>
    <div class="right">
    
        <span class="page-title">Strict Mode - Timeout</span>
        <div class="signup-error">Strict Mode is Active till the end of <?php echo date("M d, Y"); ?>.</div>
        <a href="feed.php">Reload</a>
        <a style="padding: 20px; margin:20px;background-color:lightgreen;" href="logout.php">Logout</a>
        <button id="exitStrictMode" style="border:none;padding: 5px; margin:20px;background-color: rgba(255, 0, 0, 0.45); border-radius:20px;cursor:pointer;">Exit Strict mode</button>
    </div>
</body>
<script src="./assets/scripts/jquery.js"></script>
<script>
      // ALEN : Update Modal Button -> Show Modal
      $("#exitStrictMode").click(()=>{
        $(".wrapper").css({"display":"flex"});
    })

    // ALEN : Hide Modal
    $(".modal-close").click(()=>{
        $(".wrapper").css({"display":"none"});
    })
    $(".closeModal").click(()=>{
        $(".wrapper").css({"display":"none"});
    })
</script>

</html>