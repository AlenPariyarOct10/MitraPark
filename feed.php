<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite= $aboutSite->fetch_array(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='style.css'>
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/fontawesome.css">
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link
        href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap'
        rel='stylesheet'>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <title>Feed -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <link rel="stylesheet" href="./assets/css/profile.css">
    <style>
        
        #share-btn{
            border: none; 
            background-color: white;
            cursor: pointer;
        }

        #share-btn:hover{
            background-color: rgba(0, 0, 0, 0.2);
        }

        .comment-inp{
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            border: 1px solid black;
            padding: 2px;
            border-radius: 5px;
        }

        

        .comment-inp button{
            padding: 0px 5px 0px 5px;
            border: none;
            background-color: white;
        }
        .comment-inp input{
            width: 100%;
            border: none;
            outline: none;
        }

        .comment-inp input:focus{
            outline: none;
        }


        .post-comment-inp{
            height: 30px;
            margin: 1px;
            border: 1px solid grey;
        }

        .post-comment{
            height: 30px;    
        }
    </style>
    <?php echo "<script>localStorage.setItem('mp-uid','".$_SESSION['user']['uid']."')</script>";?>

</head>

<body>
    <?php
        include_once("./parts/navbar.php");
        include_once("./parts/leftSidebar.php");
        
        include_once("./parts/feed-midbody.php");
        ?>
           
        <?php
        include_once("./parts/rightSidebar.php");
    ?>
    <script src='./assets/scripts/jquery.js'></script>

    <script>
        let modal =document.getElementById("myModal");
        let closeModal =document.getElementById("closeModal");
        closeModal.addEventListener("click",()=>{
            modal.style.display = "none";
        })



    </script>
    <script>
    function getFriendRequests() {
        let mitraRequestList = document.getElementById("mitraList");
        $.ajax({
            url: "./server/api/getFriendRequests.php",
            success: function(success) {
                mitraRequestList.innerHTML = success;
            }
        })
    }

    $(document).ready(getFriendRequests);
    setInterval(() => {
        getFriendRequests();
    }, 5000);
</script>
    <script src='posts.js'></script>
</body>
</html>