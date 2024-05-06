<?php
include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');
include_once('./server/db_connection.php');

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
        <title>Profile - '.$aboutSite['system_name'].'</title>
    </head>

    <body>';

    include_once("./parts/navbar.php");
    include_once("./parts/leftSidebar.php");
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
    include_once("./parts/rightSidebar.php");
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
    if (isset($_SESSION['user']['uid'])) {
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
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
            <link rel="stylesheet" href="./assets/css/profile.css" />
            <link rel="stylesheet" href="./assets/css/navbar.css">
            <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">
            <title>Profile - <?php echo $aboutSite['system_name']; ?></title>
            <style>
                #reportUser {
                    margin: 5px;
                    border: none;
                    padding: 5px 15px 5px 15px;
                    cursor: pointer;
                    font-size: medium;
                    border-radius: 20px;
                }

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

                .reportUserForm {
                    display: flex;
                    align-items: center;
                    justify-content: center;
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

                .pop-up-notification {

                    position: absolute;
                    bottom: 2%;
                    z-index: 1;
                    width: 70%;
                    box-shadow: 0.5px 0.5px 5px 0.5px #6d6d6d;
                    border-radius: 2px;
                    display: flex;
                }

                #post-container {
                    width: 60%;
                }

                .left-inner-body.inner-mid-body {
                    width: 90%;
                }
            </style>
            <?php include_once("../MitraPark/assets/css/dynamicColor.php"); ?>


        </head>

        <body>
            <?php
            include_once("./parts/navbar.php");
            include_once("./parts/leftSidebar.php");
            ?>


            <div class="mid-body">
                <div class="left-inner-body inner-mid-body">

                    <!-- ALEN Report user modal -->
                    <div class="modal-wrapper reportUserModal">
                        <div id="popup-report-user" class="modal-body">
                            <img class="modal-popup-head" height="80px" src="./assets/images/warning.png" alt="" srcset="">
                            <div class="post-uploader">
                                <div class="closeModal">
                                    <p>x</p>
                                </div>
                                <div class="post-uploader-head">
                                    <h3>Report user</h3>
                                </div>
                                <hr class="section-break-hr">
                                <form id="reportUserForm" method="POST" enctype="multipart/form-data">
                                    <div class="row-caption-container">
                                        <input type="hidden" name="postId" value="<?php echo $profileUid; ?>">
                                        <textarea class="text-area" name="reportContent" style="color: #222831;" placeholder="Specify about the problem." required></textarea>
                                    </div>
                                    <div class="row-upload-controls post-upload-control">
                                        <input class="submitBtn" type="submit" value="Submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Report user modal -->

                    <!-- ALEN Report user modal -->



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

                                <a href="chat.php?uid=' . $profileUid . '" class="mitra-request-control-btn">
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
                    <button id="reportUser">Report User</button>
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
                    <div id="post-container"></div>
                </div>
            </div>
            <?php include_once("./parts/rightSidebar.php") ?>


            <?php

            echo "Sender : " . $profileUid;
            echo "Receiver : " . $senderId;
            ?>
        </body>
        <script src="./assets/scripts/jquery.js"></script>


        <script>
            var profileUid = <?php echo $profileUid; ?>

            // console.log(profileUid);

            // ---------------------------------------------------------

            function timeAgo(postedTime) {
                const postedDate = new Date(postedTime);
                const currentDate = new Date();
                const timeDifference = currentDate - postedDate;

                const seconds = Math.floor(timeDifference / 1000);
                const minutes = Math.floor(seconds / 60);
                const hours = Math.floor(minutes / 60);
                const days = Math.floor(hours / 24);
                const months = Math.floor(days / 30);
                const years = Math.floor(days / 365);

                if (years > 0) {
                    return `${years} year${years > 1 ? 's' : ''} ago`;
                } else if (months > 0) {
                    return `${months} month${months > 1 ? 's' : ''} ago`;
                } else if (days > 0) {
                    return `${days} day${days > 1 ? 's' : ''} ago`;
                } else if (hours > 0) {
                    return `${hours} hour${hours > 1 ? 's' : ''} ago`;
                } else if (minutes > 0) {
                    return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
                } else {
                    return 'just now';
                }
            }

            async function fetchPosts() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: "./server/api/posts/get-user-posts.php",
                        type: "POST",
                        data: {
                            profileUid: profileUid
                        },
                        success: (data) => {
                            // console.log(data);
                            // console.log("posts ",JSON.parse(data));
                            resolve(JSON.parse(data));
                        },
                        error: (error) => {
                            reject(error);
                        }
                    });
                });
            }

            function likeHandeler() {
                let postLikes = document.querySelectorAll(".like-container");

                postLikes.forEach((item) => {
                    item.addEventListener("click", () => {
                        let id = item.dataset.id;
                        let src = item.childNodes[1].src;
                        let likeCount = item.childNodes[3];

                        if (src.includes("assets/images/heart.png")) {
                            likeCount.innerHTML = parseInt(likeCount.innerHTML) - 1;

                            item.childNodes[1].src = "./assets/images/heart-outline.png";
                        } else {
                            likeCount.innerHTML = parseInt(likeCount.innerHTML) + 1;

                            item.childNodes[1].src = "./assets/images/heart.png";
                        }

                        $.ajax({
                            url: "./server/api/addLike.php",
                            type: "POST",
                            data: {
                                postId: id
                            },
                            success: (msg) => {
                                // console.log(msg);

                            },
                            error: (msg) => {
                                // console.log(msg);
                                localStorage.getItem("mp-uid");
                            }
                        });
                    })
                    // console.log(item);
                })
            }

            async function renderPosts() {
                try {
                    const postData = await fetchPosts();
                    // console.log("has1 -> ", postData);

                    const postPlace = document.querySelector(".mid-body");
                    // console.log("has2");

                    // console.log(postData);
                    if (postData.length > 0) {
                        // console.log("has3");

                        postData.forEach(postItem => {

                            if (postItem.profile_picture == null) {
                                postItem.profile_picture = "/MitraPark/assets/images/user.png";
                            }
                            $.ajax({
                                url: "./server/api/getLikes.php",
                                type: "POST",
                                data: {
                                    postId: postItem.post_id
                                },
                                success: function(data) {
                                    let likesObj = JSON.parse(data);
                                    // console.log("likes", likesObj);
                                    let liked_byObj = likesObj.map((item) => item.liked_by);
                                    // console.log(liked_byObj);

                                    let likedState = (liked_byObj.indexOf(localStorage.getItem("mp-uid")) != -1) ? "./assets/images/heart.png" : "./assets/images/heart-outline.png";
                                    // console.log("index", likedState);
                                    generatePostHTML(postItem, likedState);
                                },
                                error: function(data) {
                                    // console.log("failed");
                                }
                            })

                        });
                        return;

                    } else {
                        postPlace.innerHTML += "No Posts";
                        return;
                    }



                } catch (error) {

                    console.error("Error fetching or rendering posts:", error);
                }
            }




            // Each Post Card parameters(postId, likedState)
            function generatePostHTML(postItem, likedState) {
                const postHTML = `
              <div class="post-item">
                <div style="display:flex; justify-content:end;">
                  <button style="border-radius:50%; border:none; padding:5px; background-color:white; cursor:pointer;">...</button>
                </div>
                <div class="post-item-head">
                  <div class="post-item-head-left">
                    <img class="profile-picture-holder" src="${postItem.profile_picture}" alt="" srcset="">
                  </div>
                  <div class="post-item-head-right">
                    <div class="post-user">
                      <span>${postItem.fname + " " + postItem.lname}</span>
                    </div>
                    <div class="post-details">
                      <span>${postItem.visibility}</span>
                      <span>|</span>
                      <span>${timeAgo(postItem.created_date_time)} </span>
                    </div>
                  </div>
                </div>
                <a href="./post.php?postId=${postItem.post_id}" class="post-item-body">
                  <span style="margin:5px;">${postItem.content}</span>
                  <img style="border-radius:10px;" src=".${postItem.media}" alt="" srcset="">
                </a>
                <div class="post-item-footer">
                  <div data-id=${postItem.post_id} class="like-container">
                    <img height="30px" src=${likedState}>
                    <span class="like-count">${postItem.like_count}</span>
                  </div>
                  <div class="comment-container">
                    <a href="./post.php?postId=${postItem.post_id}">
                    <img height="30px" src="./assets/images/comment-outline.png"></a>
                  </div>
                </div>
              </div>
            `;

                // Append the post HTML to the postPlace element
                document.querySelector("#post-container").innerHTML += postHTML;
                likeHandeler();
            }

            setTimeout(renderPosts, 1000);
            // renderPosts().catch(error => {
            //     console.error("Error rendering posts:", error);
            // });



            // ---------------------------------------------------------

            //  ALEN Report user modal 
            function showSuccessNotification() {
                let div = document.createElement("div");
                div.innerHTML = `<div style="background-color: #D8EEBE; padding:10px; border-left:10px solid #75964A; display:flex;justify-content:space-between;" class="pop-up-notification">
                        <div class="label">
                            <p id="notification-text">Report sent <b>Successfully </b>✅</p>
                        </div>
                    </div>`;
                div.style.width = "100%";
                document.getElementsByClassName("mid-body")[0].appendChild(div);
                div.setAttribute("class", "popup-notification");

                setTimeout(() => {
                    div.remove();
                }, 5000);
            }

            function showFailedNotification() {
                let div = document.createElement("div");
                div.innerHTML = `<div style="background-color: #F2CECE; padding:10px; border-left:10px solid #C94744; class="pop-up-notification">
                        <div class="label">
                            <p id="notification-text">Report sent succesfully.</p>
                        </div>
                    </div>`;
                div.style.width = "100%";

                document.getElementsByClassName("inner-mid-body")[0].appendChild(div);

                setTimeout(() => {
                    div.remove();
                }, 5000);
            }

            $(".reportUserModal").css({
                "display": "none"
            });

            $("#reportUserForm").submit((form) => {
                form.preventDefault();
                let formData = $(form.target).serializeArray();
                const userId = formData[0].value;
                const reportContent = formData[1].value;
                $.ajax({
                    url: "./server/api/other/report-user.php",
                    type: "POST",
                    data: {
                        userId: userId,
                        content: reportContent,
                    },
                    success: function(success) {
                        showSuccessNotification("Report submitted.");
                        $(".reportUserModal").css({
                            "display": "none"
                        });

                    },
                    error: function(fail) {
                        showFailedNotification("Unable to submit report.");
                        $(".reportUserModal").css({
                            "display": "none"
                        });

                    }
                })
            })

            $(".closeModal").click(() => {
                $("#reportUserForm")[0].reset();

                $(".reportUserModal").css({
                    "display": "none"
                });
            })
            $("#reportUser").click(() => {
                $(".modal-body").slideDown();

                $(".reportUserModal").show();

            })
            // console.log(document.getElementById("mitraRequestHandleBtn").childNodes[1].dataset.mode);

            function updateMitraBtn() {
                $.ajax({
                    url: "./server/api/handleRequest.php",
                    type: 'post',
                    data: {
                        messageTo: <?php echo $profileUid; ?>,
                        mode: requestHandleBtn.childNodes[1].dataset.mode
                    },
                    success: function(success) {
                        let mitraRequestHandleBtn = document.getElementById("mitraRequestHandleBtn");
                        mitraRequestHandleBtn.innerHTML = success;
                    },
                    error: function(fail) {
                        // console.log("failed", fail);
                    }
                })
            }
            let requestHandleBtn = document.getElementById("mitraRequestHandleBtn");
            requestHandleBtn.addEventListener("click", () => {
                updateMitraBtn();
            })
        </script>
    <?php include_once("./parts/js-script-files/js-script.php");?>
        

        </html>

<?php

    } else {
        noUser($aboutSite);
    }
} else {
    noUser($aboutSite);
} ?>