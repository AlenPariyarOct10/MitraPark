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
        .mid-body > *{
            width: 70%;
        }
        #all-mitra-list {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
    </style>
    <?php include_once("../MitraPark/assets/css/dynamicColor.php"); ?>


</head>

<body>
    <?php include_once("./parts/navbar.php") ?>
    <div class="body">
    <?php include_once("./parts/leftSidebar.php");?>

        <div class="mid-body">
            <div>
                <div>
                    <a href="mitras.php" class="go-back">
                        <i class="bx bx-arrow-back"></i>
                        Go back
                    </a>
                </div>
                

                <span class="dim-label">
                    All Mitras
                    <hr>
                </span>
                <div class="search-field">
                    <input placeholder="Search" type="text" id="search-field-inp">
                    <i class="fas fa-search"></i>
                </div>
                <div id="searchResult" class="left-inner-body" style="width: 100%; text-align:center;">
                </div>
                <hr>
                <div id="all-mitra-list" class="mitra-request-list">

                </div>
            </div>
        </div>
        <?php
        include_once("./parts/rightSidebar.php")
        ?>
    </div>
</body>
<script src="./assets/scripts/jquery.js"></script>
<?php include_once("./parts/js-script-files/js-script.php");?>

<script>
    let searchBox = document.getElementById("search-field-inp");

    // function getFriendRequests() {
    //     let mitraRequestList = document.getElementById("mitra-request-list");

    //     $.ajax({
    //         url: "./server/api/getFriendRequests.php",
    //         success: function(success) {
    //             // console.log(success == "");
    //             if (success == "") {
    //                 mitraRequestList.innerHTML = "No requests found";

    //             } else {
    //                 mitraRequestList.innerHTML = success;
    //             }

    //         }
    //     })
    // }

    function getAllMitras() {
        let mitraRequestList = document.getElementById("all-mitra-list");

        $.ajax({
            url: "./server/api/mitras/getAllMitras.php",
            method: "POST",
            success: function(success) {
                // console.log(success);
                if (success == "") {
                    mitraRequestList.innerHTML = "No Mitra found";

                } else {
                    let mitrasObj = JSON.parse(success);
                    let searchField = document.getElementById("search-field-inp");
                    searchBox.addEventListener("input", () => {

                        filteredMitras = mitrasObj.filter((mitra) => mitra.uname.toLowerCase().includes(searchBox.value));
                        mitraRequestList.innerHTML = "";
                        filteredMitras.forEach((mitra) => {
                            mitraRequestList.innerHTML += `<div class="mitra-item left-inner-body">
                <div class="mitra-request-list-item" id="user-${mitra.uid}">
                    <a class="redirect-to-profile" href="user.php?id=${mitra.uid}">
                        <img class="mitra-request-profile-list" src="${mitra.profile_picture}">
                        <span class="uname">${mitra.uname}</span>
                    </a>
                </div>
            </div>`;
                        });
                    })
                    mitrasObj.forEach((mitra) => {
                        mitraRequestList.innerHTML += `<div class="mitra-item left-inner-body">
                                <div class="mitra-request-list-item" id="user-${mitra.uid}">
                                    <a class="redirect-to-profile" href="user.php?id=${mitra.uid}">
                                        <img class="mitra-request-profile-list" src="${mitra.profile_picture}">
                                        <span class="uname">
                                            ${mitra.uname}
                                        </span>
                                    </a>
                                </div>
                            </div>`;
                    });

                }

            }
        })
    }

    $(document).ready(getAllMitras);
</script>
<?php  include_once ("./parts/js-script-files/strict-and-activity-update.php"); ?>

</html>