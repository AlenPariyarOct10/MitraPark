<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');
include_once("./server/auto-routes.php");


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/mitras-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/navbar.css">
    <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">

    <title>Kurakani Station</title>
    <style>
        .mid-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .mitra-request-list-item:hover {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            margin: 1px;
        }
    </style>
        <?php include_once("../MitraPark/assets/css/dynamicColor.php"); ?>


</head>

<body>
    <?php include_once("./parts/navbar.php") ?>
    <div class="body">
        <div class="left-nav">
            <div class="left-top">
                <div class="left-inner-heading">
                    <span class="dim-label">
                        Suggested Mitras
                    </span>
                    <hr class="label-underline">
                </div>

                <!-- -------------------------------- -->
                <?php
                    $getUsers = "SELECT * FROM `users` WHERE `uid` NOT IN (SELECT `sender_id` as 'uid' FROM `friends` WHERE `sender_id`='$uid' or `acceptor_id`='$uid') AND `uid` <> '$uid'";

                
                    $result = mysqli_query($connection, $getUsers);
                    if($c=mysqli_affected_rows($connection))
                    {
                        

                        while($row = mysqli_fetch_assoc($result))
                        {
                     

                            ?>
                            <div class="left-inner-body">
                                <div class="mitra-request-list-item" id="user-<?php echo $row['uid'];?>">
                                    <a class="redirect-to-profile" href="user.php?id=<?php echo $row['uid']; ?>">
                                        <img class="mitra-request-profile-list" src="<?php echo "./". $row['profile_picture']; ?>">
                                        <span class="uname">
                                            <?php echo $row['fname']." ".$row['lname']; ?>
                                        </span>
                                    </a>
                                </div>
                            </div>
                <?php
                        }
                    }else{
                        echo "No users found";
                    }
                ?>

                <!-- -------------------------------- -->
                
            </div>
            <div class="left-bottom">
                <div class="left-inner-heading">
                    <span class="dim-label">
                        Mitra Requests
                    </span>
                    <hr class="label-underline">
                </div>
                <div id="mitraList" class="left-inner-body">
                    No requests found
                </div>
            </div>
        </div>
        <div class="mid-body">
            <div>
                <div class="search-field">
                    <input placeholder="Search" type="text" id="search-field-inp">
                    <i class="fas fa-search"></i>
                </div>
                <div id="searchResult" class="left-inner-body" style="width: 100%; text-align:center;">
                </div>
                <hr>
                <!-- <div class="mitra-request-list-item">
                    <a class="redirect-to-profile" href="./user.php?">
                        <span class="uname">
                           View all Mitras
                        </span>
                    </a>
                </div> -->
            </div>
        </div>
        <?php
        include_once("./parts/rightSidebar.php")
        ?>
    </div>
</body>
<script src="./assets/scripts/jquery.js"></script>
<script>
    let searchBox = document.getElementById("search-field-inp");

    searchBox.addEventListener("keyup", (() => {

        $.ajax({
            url: './server/api/getUsers.php',
            type: "POST",
            data: {
                search: searchBox.value
            },
            success: function(items) {
                let itemsArr = JSON.parse(items);
                let searchResultShow = document.getElementById("searchResult");
                console.log(JSON.parse(items));
                if (itemsArr.length == 0) {
                    searchResultShow.innerHTML = '<span style="text-align: center;" cl ass="uname">  No result found </span>';
                } else {
                    searchResultShow.innerHTML = "";
                    itemsArr.map((profile) => (
                        console.log(profile),

                        searchResultShow.innerHTML += `
                    <div class="mitra-request-list-item" id="result-${(profile.uid)}">
                    <a class="redirect-to-profile" href="./user.php?id=${profile.uid}">
                        <img class="mitra-request-profile-list" src="${(profile.profile_picture!=null)?profile.profile_picture:"./assets/images/user.png"}">
                        <span class="uname">
                            ${profile.name}
                        </span>
                    </a>
                </div>
                    `
                    ));
                }
            },
            error: function(x) {
                console.log("fail");
                console.log(x);
            }

        })
    }));


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

</html>