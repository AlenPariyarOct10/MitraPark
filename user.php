<?php
include_once ('./parts/entryCheck.php');
include_once ('./server/db_connection.php');
include_once ('./server/validation.php');
include_once ('./server/functions.php');
include_once ('./server/db_connection.php');

$aboutSite = $connection->query('SELECT * FROM `system_data`');

$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>

<?php
function noUser($aboutSite)
{

    echo '
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="assets/css/mitras-style.css" />
        <link rel="stylesheet" href="./assets/css/all.css" />
        <link rel="stylesheet" href="./assets/css/fontawesome.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet" />
        <link rel="stylesheet" href="./assets/css/profile.css" />
        <title>Profile - MitraPark</title>
    </head>

    <body>';

    include_once ("./parts/navbar.php");
    include_once ("./parts/leftSidebar.php");
    echo '
        <div class="mid-body">
            <div class="left-inner-body inner-mid-body">



                <span class="dim-label">

                </span>
                <hr class="label-underline" />

                <div style="
              display: flex;
              height: 40px;
              margin: 10px;
              justify-content: space-around;
              width: 100%;
            ">
                    User not found


                </div>
                <hr class="label-underline" />


            </div>
        </div>';
    include_once ("./parts/rightSidebar.php");
    echo '
    </body>
    <script src="./assets/scripts/jquery.js"></script>

    </html>';
}

?>

<?php
if (isset ($_GET['id'])) {

    //prevent from XSS [convert script tags to special chars]
    $profileUid = htmlspecialchars($_GET['id']);
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    ;
    if (isset ($_SESSION['user']['uid'])) {
        if ($_SESSION['user']['uid'] == $profileUid) {
            header("Location: profile.php");
        }
    }
   


    $result = mysqli_query($connection, "SELECT * FROM users WHERE uid='$profileUid'");
    $result = mysqli_query($connection, "SELECT CONCAT(u.fname, ' ', u.lname) AS uname, u.bio, lp.location_name as p_location_name, lt.location_name as t_location_name,institution_name, u.profile_picture, u.gender FROM users u LEFT JOIN locations lp ON lp.location_id = u.p_address_id LEFT JOIN locations lt ON lt.location_id = u.t_address_id LEFT JOIN academic_institution ai on ai.inst_id=u.academic_institution_id WHERE u.uid='$profileUid'");
    $result = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($result) {
        $uname = $result['uname'];
        $bio = $result['bio'];
        $p_address = $result['p_location_name'];
        $t_address = $result['t_location_name'];
        $inst_name = $result['institution_name'];
        $profile_pic = $result['profile_picture'];
        $gender = $result['gender'];

        if ($profile_pic == null) {
            $profile_pic = "/assets/images/user.png";
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="style.css" />
            <link rel="stylesheet" href="assets/css/mitras-style.css" />
            <link rel="stylesheet" href="./assets/css/all.css" />
            <link rel="stylesheet" href="./assets/css/fontawesome.css" />
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link
                href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
                rel="stylesheet" />
                <link rel="stylesheet" href="./assets/css/profile.css" />
  <link rel="stylesheet" href="./assets/css/navbar.css">
    <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">
            <title>Profile - MitraPark</title>
        </head>

        <body>

            <?php
            include_once ("./parts/navbar.php");
            include_once ("./parts/leftSidebar.php");
            ?>


            <div class="mid-body">
                <div class="left-inner-body inner-mid-body">
                    <label for="profileUpload">
                        <div id="profile-img-holder" class="image-holder">
                            <img src=".<?php echo "./MitraPark/" . $profile_pic; ?>" id="profile-img" class="profile-img" />
                        </div>

                    </label>

                    <span class="name-placeholder">
                        <?php echo $uname; ?>
                    </span>
                    <span class="dim-label">
                        <?php echo $bio; ?>
                    </span>
                    <hr class="label-underline" />
                    <div style="
              display: flex;
              height: 40px;
              margin: 10px;
              justify-content: space-around;
              width: 100%;
            ">
                        <!-- Check for Friendship state -->
                        <?php
                        //Sender Id = My Id
                        // Receiver Id = Another user
                        $senderId = $_SESSION['user']['uid'];

                        // Check Request State - If this user has sent friend request to other or not
                        $query = "SELECT * FROM `friend_requests` WHERE `sender_id`='$senderId' and `receiver_id`='$profileUid'";
                        $requestStatus = mysqli_query($connection, $query);
                        $requestStatus = mysqli_fetch_array($requestStatus, MYSQLI_ASSOC);


                        //Check Request State - If i have received request from other side
                        $query = "SELECT * FROM `friend_requests` WHERE `sender_id`='$profileUid' and `receiver_id`='$senderId'";
                        $received_requestStatus = mysqli_query($connection, $query);
                        $received_requestStatus = mysqli_fetch_array($received_requestStatus, MYSQLI_ASSOC);


                        // Check if is friend or not
                        $query = "SELECT * FROM `friends` WHERE `sender_id`='$senderId' AND `acceptor_id`='$profileUid' or `sender_id`='$profileUid' AND `acceptor_id`='$senderId'";
                        $IsFrientResult = mysqli_query($connection, $query);
                        $IsFrientResult = mysqli_fetch_array($IsFrientResult, MYSQLI_ASSOC);

                        


                        if ($IsFrientResult !== null) {
                            echo '<div style="display:flex;" id="mitraRequestHandleBtn" data-uid="' . $profileUid . '">
                                <div data-mode="removeMitra" class="mitra-request-control-btn">
                                    <img src="./assets/images/remove.png" height="30px" alt="" />
                                    <span>Remove Mitra</span>
                                </div>
                                </div>

                                <a href="chat.php?uid='.$profileUid.'" class="mitra-request-control-btn">
                                <img src="./assets/images/message-solid.svg" height="30px" alt="" />
                                </a>

                                ';
                        } else {
                            if ($received_requestStatus == null) {
                                if ($requestStatus === null) {
                                    echo '<div id="mitraRequestHandleBtn" data-uid="' . $profileUid . '">
                                <div  data-mode="sendRequest"  class="mitra-request-control-btn">
                                    <img src="./assets/images/add-mitra.png" height="30px" alt="" />
                                    <span>Add Mitra</span>
                                </div></div>';
                                } else {
                                    echo '<div id="mitraRequestHandleBtn" data-uid="' . $profileUid . '">
                                <div data-mode="cancelRequest"  class="mitra-request-control-btn">
                                    <img src="./assets/images/remove.png" height="30px" alt="" />
                                    <span>Cancel Request</span>
                                </div></div>';
                                }
                            } else {
                                echo '
                                <div id="mitraRequestHandleBtn" data-uid="' . $profileUid . '">
                                <div data-mode="acceptRequest"  class="mitra-request-control-btn accept-reject">
                                    <img src="./assets/images/accept-request.png" height="30px" alt="" />
                                    <span>Accept Request</span>
                                </div></div>
                                ';
                            }
                        }
                        ?>
                    </div>
                    <hr class="label-underline" />

                    <div style="display:flex; flex-direction:column;">
                        <?php if ($p_address) {
                            echo '<span class="dim-label"><i class="fa-solid fa-location-dot"></i> From <b>' . $p_address . '</b></span>';
                        } ?>
                        <?php if ($t_address) {
                            echo '<span class="dim-label"><i class="fa-solid fa-location-dot"></i> Lives in <b>' . $t_address . '</b></span>';
                        } ?>
                        <?php if ($inst_name) {
                            echo '<span class="dim-label"><i class="fa-solid fa-graduation-cap"></i> Studied in <b>' . $inst_name . '</b></span>';
                        } ?>
                        <?php if ($gender) {
                            echo '<span class="dim-label">Gender <b>' . ucfirst($gender) . '</b></span>';
                        } ?>
                    </div>
                </div>
            </div>
            <?php include_once ("./parts/rightSidebar.php") ?>


            <?php 

                        echo "Sender : ".$profileUid;
                        echo "Receiver : ".$senderId;
?>
        </body>
        <script src="./assets/scripts/jquery.js"></script>
        <script>
            console.log(document.getElementById("mitraRequestHandleBtn").childNodes[1].dataset.mode);
            function updateMitraBtn() {
                $.ajax({
                    url: "./server/api/handleRequest.php",
                    type: 'post',
                    data: {
                        messageTo: <?php echo $profileUid; ?>,
                        mode: requestHandleBtn.childNodes[1].dataset.mode
                    },
                    success: function (success) {
                        let mitraRequestHandleBtn = document.getElementById("mitraRequestHandleBtn");
                        mitraRequestHandleBtn.innerHTML = success;
                    },
                    error: function (fail) {
                        console.log("failed", fail);
                    }
                })
            }
            let requestHandleBtn = document.getElementById("mitraRequestHandleBtn");
            requestHandleBtn.addEventListener("click", () => {
                updateMitraBtn();
            })


        </script>

        </html>

        <?php

    } else {
        noUser($aboutSite);
    }
} else {
    noUser($aboutSite);
} ?>