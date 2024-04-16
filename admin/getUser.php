<?php
include_once("../server/db_connection.php");
include_once('../parts/entryCheck.php');
include_once('../server/validation.php');
include_once('../server/functions.php');


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
if (isset($_GET['id'])) {

    $profileUid = htmlspecialchars($_GET['id']);
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    };

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
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
            <link rel="stylesheet" href="./assets/css/profile.css" />
            <link rel="stylesheet" href="./assets/css/navbar.css">
            <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">
            <title>Profile - MitraPark</title>
            <style>
             

                .modal-wrapper {
                    background: rgba(0, 0, 0, 0.7);
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    top: 0;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    z-index: 1;
                    display: flex;
                    align-items: center;
                    justify-content: center;

                }

                .modal-body {
                    display: flex;
                    flex-direction: row;
                    width: 50%;
                    height: 25%;
                    background-color: #bcbcbcf6;
                    border-radius: 20px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-direction: column;
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
        </head>

        <body>
            <?php

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
                    </div>

                    <hr class="label-underline" />
                   
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
  

        </body>
        <script src="./assets/scripts/jquery.js"></script>
        <script>


        </script>

        </html>

<?php

    } else {
        noUser($aboutSite);
    }
} else {
    noUser($aboutSite);
} ?>