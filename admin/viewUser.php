<?php
if(session_status()!=PHP_SESSION_ACTIVE)
{
    session_start();
}
include_once('../server/functions.php');
include_once('../server/db_connection.php');

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
        <link rel="stylesheet" href="../style.css" />
        <link rel="stylesheet" href="assets/css/mitras-style.css" />
        <link rel="stylesheet" href="./assets/css/all.css" />
        <link rel="stylesheet" href="./assets/css/fontawesome.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet" />
        <link rel="stylesheet" href="./assets/css/profile.css" />
        <title>Profile - '.$aboutSite['system_name'].'</title>
    </head>

    <body>';



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
  
    echo '
    </body>
    <script src="./assets/scripts/jquery.js"></script>

    </html>';
}

?>

<?php
if (isset($_GET['uid'])) {

    $profileUid = htmlspecialchars($_GET['uid']);
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    };

    $reportIdQuery = "SELECT `report_id` FROM `reports` WHERE `component_id`='$profileUid' AND type='user'";
    $reportId = mysqli_query($connection, $reportIdQuery);
    $reportId = mysqli_fetch_assoc($reportId);
    $reportId = $reportId['report_id'];
 


    $result = mysqli_query($connection, "SELECT * FROM users WHERE uid='$profileUid'");
    $result = mysqli_query($connection, "SELECT CONCAT(u.fname, ' ', u.lname) AS uname,createdDateTime as joined_date, u.bio, lp.location_name as p_location_name, lt.location_name as t_location_name,institution_name, u.profile_picture, u.gender FROM users u LEFT JOIN locations lp ON lp.location_id = u.p_address_id LEFT JOIN locations lt ON lt.location_id = u.t_address_id LEFT JOIN academic_institution ai on ai.inst_id=u.academic_institution_id  WHERE u.uid='$profileUid'");
    $result = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $totalFriends = "SELECT COUNT(*) AS total_friends FROM friends WHERE sender_id = '$profileUid' OR acceptor_id = '$profileUid'";
    $totalSentRequests = "SELECT COUNT(*) AS sent_request_friends FROM friends WHERE sender_id = '$profileUid'";
    $totalAcceptedRequests = "SELECT COUNT(*) AS accepted_request_friends FROM friends WHERE acceptor_id = '$profileUid'";

    $totalFriends = mysqli_query($connection, $totalFriends);
    $totalFriends = mysqli_fetch_assoc($totalFriends);

    $totalSentRequests = mysqli_query($connection, $totalSentRequests);
    $totalSentRequests = mysqli_fetch_assoc($totalSentRequests);

    $totalAcceptedRequests = mysqli_query($connection, $totalAcceptedRequests);
    $totalAcceptedRequests = mysqli_fetch_assoc($totalAcceptedRequests);

    $totalPostsCount = "SELECT COUNT(*) as total_posts FROM `posts` WHERE `author_id`='$profileUid'";
    $totalPostsCount = mysqli_query($connection, $totalPostsCount);
    $totalPostsCount = mysqli_fetch_assoc($totalPostsCount);

    // $hasReportedUsersCount = "SELECT `report_id`, `type`, `component_id`, `report_content`, `report_response`, `submitted_timestamp`, `reported_by` FROM `reports` WHERE 1"
    // To get How many users has been reported by this user  
    $hasReportedUsersCountQuery = "SELECT COUNT(DISTINCT component_id) AS hasReportedUsers FROM `reports` WHERE reported_by = '$profileUid' AND type = 'user'";
    $hasReportedUsersCountResult = mysqli_query($connection, $hasReportedUsersCountQuery);
    $hasReportedUsersCount = mysqli_fetch_assoc($hasReportedUsersCountResult);

    // Yo user lai chai kati jana le report garey
    $getsReportedByUsersCountQuery = "SELECT COUNT(DISTINCT reported_by) AS getsReportedByUsers FROM `reports` WHERE type = 'user' AND `component_id` = '$profileUid'";
    $getsReportedByUsersCountResult = mysqli_query($connection, $getsReportedByUsersCountQuery);
    $getsReportedByUsersCount = mysqli_fetch_assoc($getsReportedByUsersCountResult);



    if ($result) {
        $uname = $result['uname'];
        $bio = $result['bio'];
        $p_address = $result['p_location_name'];
        $t_address = $result['t_location_name'];
        $inst_name = $result['institution_name'];
        $profile_pic = $result['profile_picture'];
        $gender = $result['gender'];

        if ($profile_pic == null) {
            $profile_pic = "../assets/images/user.png";
        }
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="../style.css" />
            <link rel="stylesheet" href="../assets/css/mitras-style.css" />
            <link rel="stylesheet" href="../assets/css/all.css" />
            <link rel="stylesheet" href="../assets/css/fontawesome.css" />
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
            <link rel="stylesheet" href="../assets/css/profile.css" />
            <link rel="stylesheet" href="../assets/css/navbar.css">
            <link rel="stylesheet" href="../assets/css/boxicons/css/boxicons.min.css">
            <title>Profile - <?php echo $aboutSite['system_name']; ?></title>
            <style>
                body{
                    color: black;
                }                
                *{
                    font-family: 'poppins';
                    font-size: 1rem;
                }
                .row-caption-container {
                    width: 100%;
                }

                .text-area {
                    width: 80%;
                }

                .closeModal {
                    position: relative;
                    top: -40%;
                    left: 97%;
                    background-color: rgb(255, 0, 25);
                    width: 20px;
                    text-align: center;
                    border-radius: 50%;
                    cursor: pointer;

                }

                .post-details > span{
                    font-size: small;
                }
                .text-area {
                    border: none;
                    resize: none;
                    justify-content: center;
                    align-items: center;
                    padding: 5px;
                    border-radius: 10px;
                }

                .pop-up-notification{
                    
                    position: absolute;
                    bottom: 2%;
                    z-index: 1;
                    width: 70%;
                    box-shadow: 0.5px 0.5px 5px 0.5px #6d6d6d;
                    border-radius: 2px;
                    display: flex;
                }

               

            </style>
            <link rel="stylesheet" href="./assets/css/style.css">
            <style>
                body{
                    /* height: 100vh; */
                    display: flex;
                    flex-direction: row;
                    width: 100%;
                }

                .sidebar{
                    height: 100vh;
                }

                .mid-body{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                   
                }
                #profile-img{
                    height: 150px;
                }

                .inner-mid-body{
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    height: 100vh;
                    overflow: scroll;
                }

                .dim-label{
                    font-size: medium;
                }

                .label-underline{
                    border: 1px solid rgb(163, 163, 163);
                    width: 100%;
                }
                a{
                    color: black;
                }
                .post-item-footer{
                    display: flex;
                  justify-content: space-evenly;
                  align-items: center;
                  align-items: center;
                }
                .like-count{
                    width: 30px;
                }

                .post-item-footer a{
                    width: 30px;
                }

            </style>
             

        </head>

        <body>
        <?php include_once("./parts/sidebar.php"); ?>


            <div class="mid-body">
                <div class="left-inner-body inner-mid-body">
                
                    <label for="profileUpload">
                        <div id="profile-img-holder" class="image-holder">
                            <img src="<?php echo "/MitraPark/" . $profile_pic; ?>" id="profile-img" class="profile-img" />
                        </div>
                    </label>

                    <span class="name-placeholder">
                        <?php echo $uname; ?>
                    </span>
                    <span class="dim-label">
                        <?php echo $bio; ?>
                    </span>
                    <hr class="label-underline" />
                    <button id="reportUser">Loading...</button> 
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
                        }
                      
                 
                        echo '<span class="dim-label">Total Friends <b>' .$totalFriends['total_friends'] . '</b></span>';
                        echo '<span class="dim-label">Accepted Requests <b>' .$totalAcceptedRequests['accepted_request_friends'] . '</b></span>';
                        echo '<span class="dim-label">Sent Requests <b>' .$totalSentRequests['sent_request_friends'] . '</b></span>';
                        echo '<span class="dim-label">Total Posts <b>' .$totalPostsCount['total_posts'] . '</b></span>';
                        $joineddate = date("d".'\t\h'." M, Y",strtotime($result['joined_date']));
                        
                        echo '<span class="dim-label">Joined <b>'.$aboutSite['system_name'].'</b> in <b>' .$joineddate . '</b></span>';
                        echo '<span class="dim-label">Has reported to <b>' .$hasReportedUsersCount['hasReportedUsers'] . '</b> users.</span>';
                        echo '<span class="dim-label">Has reported by <b>' .$getsReportedByUsersCount['getsReportedByUsers'] . '</b> users.</span>';
                        
                            ;
                        ?>

                        
                    </div>
                    <div id="post-container">
                <hr class="label-underline" />

                    </div>
                </div>
            </div>
        </body>
        <script src="../assets/scripts/jquery.js"></script>
        <?php
            include_once("./api/posts/posts.php");
        ?>
        <script>
            $.ajax({
                url: "./api/restriction/get-restricted-status.php",
                type: "POST",
                data: {
                    uid: <?php echo $profileUid; ?>,
                },
                success: async(status) => {
           
                    const restrictedStatus = await JSON.parse(status);
                    // console.log(restrictedStatus);

                    if(restrictedStatus.status == "active")
                    {
                        $("#reportUser")[0].innerHTML = "Restrict User";

                    }else{
                        $("#reportUser")[0].innerHTML = "Unrestrict User";
                    }
                }
            })

            

            $("#reportUser").click(()=>{
                if($("#reportUser")[0].innerHTML=="Restrict User")
                {
                    restrictUser(<?php echo  $reportId; ?>);
                }else if($("#reportUser")[0].innerHTML=="Unrestrict User")
                {
                    unstrictUser(<?php echo  $reportId; ?>);
                }
            })

            function restrictUser(reportId)
            {
                // console.log(reportId);
                $.ajax({
                    url: "./api/restrictUser.php",
                    type: "GET",
                    data: {
                        reportId : reportId
                    },
                    success: (response)=>{
                        // console.log(response);
                        $("#reportUser")[0].innerHTML="Unrestrict User";  
                    }
                })
            }

            function unstrictUser(reportId)
            {
                $.ajax({
                    url: "./api/unrestrictUser.php",
                    type: "GET",
                    data: {
                        reportId : reportId
                    },
                    success: (response)=>{
                        $("#reportUser")[0].innerHTML="Restrict User";
                    }
                })
            }

        </script>
       

        </html>

<?php

    } else {
        noUser($aboutSite);
    }
} else {
    noUser($aboutSite);
} ?>