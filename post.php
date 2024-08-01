<?php

include_once ('./parts/entryCheck.php');
include_once ('./server/db_connection.php');
include_once ('./server/validation.php');
include_once ('./server/functions.php');

$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
include_once ("./server/auto-routes.php");

if (!isset($_GET['postId'])) {

    header("Location: feed.php");
    exit();
}
$pid = $_GET['postId'];
$hasPost = "SELECT * FROM `posts` WHERE post_id='$pid'";
$hasPost = mysqli_query($connection, $hasPost);
if (mysqli_affected_rows($connection) == 0) {
    header("Location: feed.php");
    exit();
}
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
    <link rel="stylesheet" href="./assets/css/profile.css">
    <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">

    <link rel="stylesheet" href="./assets/css/navbar.css">

    <title>Post -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <link rel="stylesheet" href="">

    <style>
        #share-btn {
            border: none;
            background-color: white;
            cursor: pointer;
        }

        #share-btn:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .comment-inp {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
        }

        .comment-inp button {
            padding: 0px 5px 0px 5px;
        }

        .comment-inp input {
            width: 100%;
        }


        .comment-inp {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            border: 1px solid black;
            padding: 2px;
            border-radius: 5px;
        }

        .comment-inp button {
            padding: 0px 5px 0px 5px;
            border: none;
            background-color: white;
        }

        .comment-inp input {
            width: 100%;
            border: none;
            outline: none;
        }

        .comment-inp input:focus {
            outline: none;
        }


        .post-comment-inp {
            height: 30px;
            margin: 1px;
            border: 1px solid grey;
        }

        #view-likes-comments button {
            padding: 5px;
            border: none;
            cursor: pointer;
        }

        #view-likes-comments button:hover {
            background-color: bisque;
        }

        .controlBtn {
            padding: 5px;
            border: none;
            cursor: pointer;
        }

        .softRed:hover {
            background-color: lightcoral;

        }

        .softGreen:hover {
            background-color: lightgreen;
        }


        .active-btn {
            background-color: bisque;
        }

        .post-comment {
            height: 30px;
        }

        .modal-content {
            width: 50%;
        }

        .post-item {
            margin-top: 5px;
            margin-left: 0px;
            margin-bottom: 5px;
            margin-right: 0px;
        }

        #heart-flow {
            position: absolute;
            height: 200px;
            bottom: -100%;
        }

        #mid-body {
            width: 35%;
            height: 90vh;
        }

        #popup-comment {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40%;
            border-radius: 20px;
            background-color: var(--mp-theme-bg);
            box-shadow: 0px 0px 20px 1px #fffbfb66;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #popup-upload-post {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40%;
            border-radius: 20px;
            background-color: var(--mp-theme-bg);
            box-shadow: 0px 0px 20px 1px #fffbfb66;
            display: flex;
            flex-direction: column;
            align-items: center;
            display: none;
        }

        .modal-position {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40%;
            border-radius: 20px;
            background-color: var(--mp-theme-bg);
            box-shadow: 0px 0px 20px 1px #fffbfb66;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #modal-wrapper {

            background: rgba(0, 0, 0, 0.7);
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: none;
        }

        .modal-wrapper {
            background: rgba(0, 0, 0, 0.7);
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: none;
        }

        #closeModal {
            top: 0;
            left: 98%;
            width: 9px;
            height: 9px;
            background-color: red;
            padding: 10px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.5;
            position: absolute;
            cursor: pointer;
            color: white;
        }

        .closeModal {
            top: 0;
            left: 98%;
            width: 9px;
            height: 9px;
            background-color: red;
            padding: 10px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.5;
            position: absolute;
            cursor: pointer;
            color: white;
        }

        .modal-content {
            position: relative;
        }

        #editPostModal {
            position: absolute;
        }

        #addImg {
            background-color: crimson;
            padding: 3px;
            display: block;
            color: white;
        }

        .post-image-holder {
            display: none;
        }

        .btn {
            width: 40px;
            border: none;
            margin: 3px;
            text-align: center;
            cursor: pointer;
            border-radius: 3px;
            color: white;
        }

        .btn-green {
            background-color: darkcyan;
        }

        .btn-red {
            background-color: tomato;
            cursor: pointer;
            border-radius: 3px;
            color: white;
        }

        #caption {
            width: 100%;
            height: 100%;
            resize: none;
            outline: none;
            background-color: transparent;
            border: none;
            color: white;
            font-size: medium;
        }
    </style>
    <?php echo "<script>localStorage.setItem('mp-uid','" . $_SESSION['user']['uid'] . "')</script>"; ?>
    <?php include_once ("../MitraPark/assets/css/dynamicColor.php"); ?>


</head>

<body>
    <?php
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
        $uid = $_SESSION['user']['uid'];
    }
    $uid = $_SESSION['user']['uid'];
    include_once ("./parts/navbar.php");
    include_once ("./parts/leftSidebar.php");
    ?>

    <?php



    $postId = htmlspecialchars($_GET['postId']);

    $getPost = "SELECT *, concat(fname,' ',lname) as uname FROM `posts` INNER JOIN users u ON author_id=u.uid WHERE post_id='$postId'";
    $getAuthor = "SELECT `author_id` FROM `posts` WHERE post_id='$postId' AND `status`='active' ";

    $getAuthor = mysqli_query($connection, $getAuthor);

    $getAuthor = mysqli_fetch_assoc($getAuthor);
    if ($getAuthor) {
        $authorId = $getAuthor['author_id'];

        $getPost = mysqli_query($connection, $getPost);

        $getPost = mysqli_fetch_assoc($getPost);

        $authorMitras = "SELECT * FROM `friends` WHERE (`sender_id`='$uid' AND `acceptor_id`='$authorId') OR (`sender_id`='$authorId' AND `acceptor_id`='$uid')";
        $authorMitras = mysqli_query($connection, $authorMitras);
        $authorMitras = mysqli_fetch_assoc($authorMitras);
        $isMitra = false;
        if ($authorMitras) {
            $isMitra = true;
        }

        ?>

        <div id="mid-body" class="mid-body">

            <?php
            if ($getPost && ($getPost['visibility'] == "private" && $getAuthor['author_id'] == $uid) || ($getPost['visibility'] == "public") || ($getPost['visibility'] == "mitras" && ($isMitra || $getAuthor['author_id'] == $uid))) {
                ?>
                <!-- ALEN Report post modal -->
                <div id="modal-wrapper">
                    <div id="popup-upload-post">
                        <img class="modal-popup-head" height="80px" src="./assets/images/warning.png" alt="" srcset="">
                        <div class="post-uploader">
                            <div class="closeModal">
                                <p>x</p>
                            </div>
                            <div class="post-uploader-head">
                                <h3>Report post</h3>
                            </div>
                            <hr class="section-break-hr">
                            <form id="reportPostForm" method="POST" enctype="multipart/form-data">
                                <div class="row-caption-container">
                                    <input type="hidden" name="postId" value="<?php echo $postId; ?>">
                                    <textarea name="reportContent" style="color: #222831;"
                                        placeholder="Specify about the problem." id="post-caption" required></textarea>
                                </div>
                                <div class="row-upload-controls post-upload-control">
                                    <input id="post-share-btn" type="submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Report post modal -->

              

                <!-- ALEN action result modal -->
                <div id="action-result" class="modal-wrapper">
                    <div class="modal-position">
                        <img class="modal-popup-head" id="resultModalImg" height="80px" src="" alt="" srcset="">
                        <div class="post-uploader">
                            <div class="closeModal">
                                <p>x</p>
                            </div>
                            <div class="post-uploader-head">
                                <h3 id="resultActionStatus"></h3>
                                <span id="resultActionMessage"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Action result modal -->

                <img id="heart-flow" src="./assets/images/heart-flow.png" alt="">

                <div class="left-inner-heading">
                    <span class="dim-label">
                        <?php echo "<b>" . $getPost['uname'] . "</b>'s post."; ?>
                    </span>
                    <hr class="label-underline">
                </div>
                <div class="post-item">
                    <div class="post-item-head">
                        <div class="post-item-head-left">
                            <img class="profile-picture-holder" src="<?php echo './' . $getPost['profile_picture']; ?>" alt=""
                                srcset="">
                        </div>
                        <div class="post-item-head-right">
                            <div class="post-user">
                                <span>
                                    <?php echo $getPost['uname']; ?>
                                </span>
                            </div>
                            <div class="post-details">
                                <span>
                                    <?php echo $getPost['visibility']; ?>
                                </span>
                                <span>|</span>
                                <span>
                                    <?php echo $getPost['created_date_time']; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="post-item-body">
                        <span style="margin:5px;">
                            <?php echo $getPost['content']; ?>
                        </span>

                        <img id="post-img" style="border-radius:10px;" src="<?php echo "." . $getPost['media']; ?>" alt=""
                            srcset="">
                    </div>
                    <div class="post-item-footer">

                        <div data-id=<?php echo $postId; ?> class="like-container">
                            <img id="likeState" onclick="reactAnimation()" height="30px" src="">
                            <span id="like-count" class="like-count">0</span>
                        </div>
                        <div class="comment-container">
                            <img height="30px" src="./assets/images/comment-outline.png">
                        </div>

                    </div>

                    <div class="comment-inp">
                        <input maxlength="254" class="post-comment-inp" id="post-comment-<?php echo $postId; ?>"
                            placeholder="Write comment" type="text" />
                        <button style="cursor:pointer;" class="post-comment" onclick="postComment(<?php echo $postId; ?>)"
                            id="comment-btn-<?php echo $postId; ?>"> <i id="sendBtn" class="fa fa-paper-plane"
                                aria-hidden="true"></i> </button>
                    </div>
                </div>

                <div class="post-item">
                    <div id="view-likes-comments" style="margin:5px;">
                        <?php
                        if ($getAuthor['author_id'] === $uid) {
                            ?>
                            <button id="editPost">Edit Post</button>
                            <button id="deletePost">Delete Post</button>
                            <?php
                        }
                        ?>
                        <?php
                        if ($getAuthor['author_id'] !== $uid) {
                            ?>
                            <button id="reportPost">Report Post</button>
                        <?php } ?>

                    </div>
                </div>


                <div class="post-item">
                    <div id="view-likes-comments" style="margin:5px;">
                        <button id="getLikes">Likes</button>
                        <button id="getComments">Comments</button>
                    </div>
                    <hr class="label-underline">

                    <div id="like-comment-container" class="post-item-body">
                        <?php
                        $postId = htmlspecialchars($_GET['postId']);
                        $getLikesQuery = "SELECT uid, profile_picture, concat(fname,' ', lname) as uname FROM `users` WHERE `uid` IN ( SELECT `liked_by` FROM `likes` WHERE `post_id`='$postId')";
                        $getLikers = mysqli_query($connection, $getLikesQuery);
                        $getLikers = mysqli_fetch_all($getLikers, MYSQLI_ASSOC);

                        foreach ($getLikers as $likes) {
                            echo '<a class="right-nav-item" href="user.php?id=' . $likes['uid'] . '">
            <img class="right-nav-item-img" src="' . $likes['profile_picture'] . '">
            <span>' . $likes['uname'] . '</span>
        </a>';
                        }


                        ?>
                    </div>
                </div>

                <!-- Edit Post Modal -->
                <div id="editPostModal" class="modal">
                    <div class="modal-content">
                        <span class="closeModal" class="close">&times;</span>
                        <div>
                            <span style="text-decoration: underline;">Edit Post</span><label id="form-submit-failed"></label>
                            <form class="form-datas post-update-form" id="post-update-form" action="./server/api/updatePost.php"
                                method="post" enctype="multipart/form-data">
                                <input type="file" style="display:none" name="file" id="post-img-uploader"
                                    value="<?php echo $getPost['media']; ?>" />
                                <input type="hidden" id="file-operation" name="file-operation" value="none" />
                                <div class="form-innner-row">
                                    <div class="inner-form-element">
                                        <label id="fname-label" for="fname">Edit Text<span id="fname-error"></span> </label>
                                        <div class="row-caption-container">
                                            <textarea name="caption" id="caption" style="color: #222831;" maxlength="999"
                                                placeholder="Write something"><?php echo $getPost['content']; ?></textarea>
                                        </div>

                                        <input type="hidden" name="postId" value="<?php echo $postId; ?>">
                                        <label class="length-validate" id="caption-length" for="caption">
                                    </div>

                                    <div class="inner-form-element">
                                        <label for="visibility">Visibility<span id="fname-error"></span> </label>
                                        <select name="visibility" id="visibility">
                                            <option value="public" <?php echo ($getPost['visibility'] == "public") ? "selected" : ""; ?>>public</option>
                                            <option value="mitras" <?php echo ($getPost['visibility'] == "mitras") ? "selected" : ""; ?>>mitras</option>
                                            <option value="private" <?php echo ($getPost['visibility'] == "private") ? "selected" : ""; ?>>private</option>
                                        </select>
                                    </div>


                                    <div class="post-item-body">
                                        <label id="fname-label" for="fname">Media<span id="fname-error"></span> </label>

                                    </div>


                                    <div class="post-image-holder">
                                        <div class="inner-post-image-holder">
                                            <img id="selected-post-img" class="post-upload-image"
                                                src="<?php echo "./" . $getPost['media']; ?>" alt="">
                                            <div id="remove-post-image">
                                                <p>x</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row-upload-controls post-upload-control">
                                        <input style="display: none;" type="file" accept=".jpg, .jpeg, .png" name="file"
                                            id="post-upload-file">
                                        <button type="button"><label style="color:white; cursor:pointer;"
                                                for="post-upload-file">Photo</label></button>
                                    </div>

                                    <div class="form-inner-row">
                                        <div class="inner-form-element">
                                            <button id="profile-form-submit" type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Delete Post Modal -->
                <div id="deletePostModal" class="modal">
                    <div class="modal-content">

                        <span class="closeModal closeDelModal">×</span>
                        <div>
                            <span style="text-decoration: underline;">Are you sure, you want to delete this post?</span><label
                                id="form-submit-failed"></label>
                            <form action="./server/deletePost.php" method="post">
                                <input type="file" style="display: none" id="post-img-uploader" />
                                <div class="form-innner-row">
                                    <div class="form-inner-row">
                                        <div style="display: flex; flex-direction: row;" class="inner-form-element">
                                            <input type="hidden" name="postId" value="<?php echo $postId; ?>">
                                            <input type="hidden" name="authorId" value="<?php echo $getAuthor['author_id']; ?>">
                                            <button class="closeDelModal btn btn-red" type="button">No</button>
                                            <input class="btn btn-green" value="Yes" type="submit" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Delete Comment Modal -->
                <div id="deleteCommentModal" class="modal">
                    <div class="modal-content">
                        <span class="closeModalBtn" class="close">&times;</span>
                        <div>
                            <span style="text-decoration: underline;">Are you sure, you want to delete this
                                comment?</span><label id="form-submit-failed"></label>
                            <form action="./server/deleteComment.php" method="post">
                                <input type="file" style="display: none" id="post-img-uploader" />
                                <div class="form-innner-row">
                                    <div class="form-inner-row">
                                        <div style="display: flex; flex-direction: row;" class="inner-form-element">
                                            <input style="background-color:tomato;" id="profile-form-submit" value="Yes"
                                                type="submit" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            } else {
                ?>
            <div id="mid-body" class="mid-body">


                <div class="post-item">
                    <?php
                    $activeStatus = "SELECT `status` FROM `posts` WHERE `post_id`='$postId'";
                    $activeStatus = mysqli_query($connection, $activeStatus);
                    $aboutPost = mysqli_fetch_assoc($activeStatus);


                    if ($aboutPost['status'] == "restricted") {
                        echo "This post has been restricted due to violation of community guidelines and standards.";
                    } else {
                        echo "Post not found.";
                    }
                    ?>
                </div>

            </div>
            </div>

            <?php
            }
    } else {
        ?>
        <div id="mid-body" class="mid-body">


            <div class="post-item">
                <?php
                $activeStatus = "SELECT `status` FROM `posts` WHERE `post_id`='$postId'";
                $activeStatus = mysqli_query($connection, $activeStatus);
                $aboutPost = mysqli_fetch_assoc($activeStatus);


                if ($aboutPost['status'] == "restricted") {
                    echo "This post has been restricted due to violation of community guidelines and standards.";
                } else {
                    echo "Post not found.";
                }
                ?>
            </div>
        </div>


        <?php
    }
    include_once ("./parts/rightSidebar.php");
    ?>


    <script src='./assets/scripts/jquery.js'></script>
    <script>


        let closeModala = document.getElementById("closeModal");

        $(".closeModal").click(()=>{
            $("#action-result").hide();
        })

        $("#post-upload-file").change((event) => {
            const file = event.target.files[0];
            if (file) {
                const imgUrl = URL.createObjectURL(file);

                $("#selected-post-img").attr("src", imgUrl);

            }
        });

        $("#remove-post-image").click(() => {
            $("#selected-post-img").attr("src", null);
            $(".post-image-holder")[0].style.display = "none";
            $("#file-operation")[0].value = "delete";
        })

        $(".closeModal").click(() => {
            // console.log("clicked--");
            
            $("#modal-wrapper").hide();
            $("#modal-position").slideUp();

        })

        // ALEN : API - Report Post
        $("#reportPostForm").submit((form) => {
            // console.log("submit");
            form.preventDefault();
            const formData = $(form.target).serializeArray();
            const postId = formData[0].value;
            const reportContent = formData[1].value;
            $.ajax({
                url: "./server/api/posts/report-post.php",
                type: "POST",
                data: {
                    postId: postId,
                    reportContent: reportContent,
                },
                success: function (success) {
                    $("#reportPostForm")[0].reset();
                    $("#popup-upload-post").hide();
                    $("#modal-wrapper").slideUp();
                    $("#action-result").slideDown();
                    $("#resultModalImg").attr("src", "./assets/images/accept-request.png");
                    $("#resultActionStatus").text("Success");
                    $("#resultActionMessage").text("Post reported succesfully.");
                },
                error: function () {
                    $("#popup-upload-post").hide();
                    $("#reportPostForm")[0].reset();
                    $("#modal-wrapper").slideUp();
                    $("#action-result").slideDown();
                    $("#resultModalImg").attr("src", "./assets/images/remove.png");
                    $("#resultActionStatus").text("Failed");
                    $("#resultActionMessage").text("Unable to report the post.");
                }
            })
        })
        


        $("#caption").on('input', function () {
            var captionValue = $(this).val().trim();
            if (captionValue.length > 0) {
                $("#profile-form-submit").prop("disabled", false);
            } else {
                $("#profile-form-submit").prop("disabled", true);
            }
        });


        $("#reportPost").click(() => {
            $("#modal-wrapper").slideDown();
            $("#popup-upload-post").slideDown();

        })


        $("#post-upload-file").change((event) => {
            const file = event.target.files[0];
            if (file) {
                const imgUrl = URL.createObjectURL(file);

                $("#post-upload-file").attr("src", imgUrl);
                $(".post-image-holder").show();
            }
        });



        $("#post-text").click(() => {
            $("#modal-wrapper").slideDown();
            if ($("#selected-post-img").attr("src") || $("#post-caption")[0].value.length > 0) {
                $("#post-share-btn").prop('disabled', false);
            } else {
                $("#post-share-btn").prop('disabled', true);
            }

        });

        let modalWrapper = document.getElementById("modal-wrapper");



        function postComment(id) {
            let commentText = document.getElementById("post-comment-" + id);
            $.ajax({
                url: "./server/api/insertComment.php",
                type: "POST",
                data: {
                    postId: id,
                    commentAuthor: localStorage.getItem("mp-uid"),
                    commentContent: commentText.value
                },
                success: (response) => {
                    // console.log("success", response);
                },
                error: (response) => {
                    // console.log("failed", response);
                }
            })
            commentText.value = null;
        }



        <?php

        if ($getAuthor['author_id'] === $uid) {
            ?>
            const editPostTriggerBtn = document.getElementById("editPost");
            const deletePostTriggerBtn = document.getElementById("deletePost");

            editPostTriggerBtn.addEventListener("click", () => editModal());
            deletePostTriggerBtn.addEventListener("click", () => deletePostAlertModal());

            const deletePostAlertModal = () => {
                $("#deletePostModal").slideToggle();
                const closeModalBtn = document.getElementById("closeDelModal");
                // console.log("clicked");
                $(".closeDelModal").click(() => {
                    $("#deletePostModal").slideUp(500);
                    // console.log("clicked delete");
                })
            }

            const editModal = () => {
                $("#editPostModal").slideToggle(500);


                if ($("#selected-post-img").attr("src") != null && $("#selected-post-img").attr("src") != './') {
                    $(".post-image-holder").show();
                }

                $(".closeModal").click(() => {
                    $("#editPostModal").slideUp(500);

                })
            }

            <?php
        }
        ?>

        $("#post-img-uploader").change(() => {
            // console.log($("#post-img-uploader").val());
        })

        function reactAnimation() {
            $("#heart-flow").animate({
                bottom: "-100%"
            }, 800);
            $("#heart-flow").animate({
                bottom: "40%",
                height: "300px"
            }, 500);
            $("#heart-flow").animate({
                bottom: "100%",
                height: "150px"
            }, 800);
            $("#heart-flow").animate({
                bottom: "-100%",
                height: "150px"
            }, 0);
        }

        if (window.location.hash === "#edit") {

            editModal();
            window.location.hash = "";
        } else if (window.location.hash === "#delete") {

            deletePostAlertModal();
            window.location.hash = "";

        }
        let getLikes = document.getElementById("getLikes");
        getLikes.classList.add("active-btn");
        let getComments = document.getElementById("getComments");
        let likedStateImg = document.getElementById("likeState");
        let likeCount = document.getElementById("like-count");
        let likeCommentContainer = document.getElementById("like-comment-container");


        function fetchComments() {
            let postId = <?php echo $postId; ?>;
            let commentsContainer = document.getElementById("like-comment-container");

            $(document).ready(() => {
                let commentBody = "";
                $.ajax({
                    url: "./server/api/getComments.php",
                    type: "POST",
                    data: {
                        postId: postId
                    },
                    success: function (response) {
                        const responseObj = JSON.parse(response);

                        responseObj.forEach((item) => {
                            commentBody += `
                    <div class="post-item">
                        <div class="post-item-head">
                            <div class="post-item-head-left">
                                <img class="profile-picture-holder" src="./${item.profile_picture}" alt="" srcset="">
                            </div>
                            <div class="post-item-head-right">
                                <div class="post-user">
                                    <span>${item.fname} ${item.lname}</span>
                                </div>
                                <div class="post-details">
                                    <span>${item.created_date_time}</span>
                                </div>
                            </div>
                        </div>
                        <div class="post-item-body">
                            <span id="content-${item.comment_id}" style="margin:5px;">${item.content}</span> 
                        </div>
                        ${(item.comment_by == <?php echo $uid; ?>) ? `<div class="controlBtns" style="margin:5px;"><button class="softGreen controlBtn editComment" data-id="${item.comment_id}" id="editComment-${item.comment_id}">Edit Comment</button><button class="softRed controlBtn deleteComment" data-id="${item.comment_id}" id="deleteComment-${item.comment_id}">Delete Commment</button></div>` : ""}
                        <button class="softRed controlBtn replyComment" data-mode="enter-comment" data-id="${item.comment_id}" id="replyComment-${item.comment_id}">Reply Commment</button>
                        <div id="rcomment-${item.comment_id}">
                        </div>
                    </div>`;



                            $.ajax({
                                url: "./server/api/comments/getReplyComments.php",
                                type: "POST",
                                data: {
                                    parentCommentId: item.comment_id
                                },
                                success: (response) => {
                                    let resObj = JSON.parse(response);
                                    // console.log(resObj);
                                    let div = document.getElementById("rcomment-" + item.comment_id);

                                    resObj.forEach((rcomment) => {
                                        // console.log(rcomment);
                                        div.innerHTML += `<div style="border-left: 1px solid black; margin: 10px;">
                        <div class="post-item-head">
                            <div style="margin:10px;" class="post-item-head-left">
                                <img class="profile-picture-holder" src="./${rcomment.profile_picture}" alt="" srcset="">
                            </div>
                            <div class="post-item-head-right">
                                <div class="post-user">
                                    <span>${rcomment.fname} ${rcomment.lname}</span>
                                </div>
                                <div class="post-details">
                                    <span>${rcomment.created_timestamp}</span>
                                </div>
                            </div>
                        </div>
                        <div class="post-item-body">
                            <span id="reply-content-${rcomment.reply_comment_id}" style="margin:5px;">${rcomment.comment_content}</span> 
                        </div>
                        ${(rcomment.comment_author == <?php echo $uid; ?>) ? `<div class="controlBtns" style="margin:5px;"><button class="softGreen controlBtn editRComment" data-id="${rcomment.reply_comment_id}" id="editRComment-${rcomment.reply_comment_id}">Edit</button><button class="softRed controlBtn deleteRComment" data-id="${rcomment.reply_comment_id}" id="deleteRComment-${rcomment.reply_comment_id}">Delete Commment</button></div>` : ""}                        
                    </div>`;

                                        // ALEN : Delete Reply Comment API
                                        $(".deleteRComment").click(function (event) {
                                            // console.log("delete reply");
                                            const commentId = $(this).data("id");

                                            if (this.innerText != "Confirm Delete") {
                                                this.innerText = "Confirm Delete";
                                            } else {
                                                $.ajax({
                                                    url: "./server/api/comments/deleteReplyComment.php",
                                                    type: 'POST',
                                                    data: {
                                                        reply_comment_id: commentId
                                                    },
                                                    success: function (data) {
                                                        $("#action-result").slideDown();
                                                        $("#resultModalImg").attr("src", "./assets/images/accept-request.png");
                                                        $("#resultActionStatus").text("Success");
                                                        $("#resultActionMessage").text("Comment deleted.");
                                                        fetchComments();
                                                    }
                                                })
                                            }
                                        });
                                        // ALEN : Edit Reply Comment API
                                        $(".editRComment").click(function (event) {
                                            const commentId = $(this).data("id");
                                            if (this.innerText != "Save") {
                                                this.innerText = "Save";
                                                let rcommentContent = $(`#reply-content-${commentId}`)[0].innerText;
                                                $(`#reply-content-${commentId}`).append(`<input maxlength='254' value='${rcommentContent}' type='text' id='updateText'/>`);


                                            } else if (this.innerText == "Save") {
                                                $.ajax({
                                                    url: "./server/api/comments/updateReplyComment.php",
                                                    type: 'POST',
                                                    data: {
                                                        reply_comment_id: commentId,
                                                        updated_comment_content: document.getElementById("updateText").value
                                                    },
                                                    success: function (data) {
                                                        fetchComments();
                                                    }
                                                });
                                            }
                                        });



                                    })

                                }

                            })
                        });

                        if (commentBody.length == 0) {
                            commentsContainer.innerHTML = "<p>No comments</p>";
                        } else {

                            commentsContainer.innerHTML = commentBody;
                        }

                        // ALEN : Edit Comment API
                        $(".editComment").click(function (event) {
                            const commentId = $(this).data("id");
                            if (this.innerText != "Save") {
                                this.innerText = "Save";
                                console.log(this);
                                let commentContent = $(`#content-${commentId}`)[0].innerText;
                                $(`#content-${commentId}`).hide();

                                const inputElement = `<input maxlength='254' type='text' value='${commentContent}' id='updateText'/>`;

                                $(inputElement).insertAfter($(`#content-${commentId}`));

                            } else if (this.innerText == "Save") {
                                $.ajax({
                                    url: "./server/api/comments/updateComment.php",
                                    type: 'POST',
                                    data: {
                                        commentId: commentId,
                                        newComment: document.getElementById("updateText").value
                                    },
                                    success: function (data) {
                                        $(`content-${commentId}`).show();
                                        fetchComments();
                                    }
                                });
                            }
                        });

                        // ALEN : Delete Comment API
                        $(".deleteComment").click(function (event) {
                            const commentId = $(this).data("id");
                            // console.log(commentId);

                            if (this.innerText != "Confirm Delete") {
                                this.innerText = "Confirm Delete";
                            } else {
                                $.ajax({
                                    url: "./server/api/comments/deleteComment.php",
                                    type: 'POST',
                                    data: {
                                        commentId: commentId
                                    },
                                    success: function (data) {
                                        fetchComments();
                                    }
                                })
                            }
                        });

                        $("#post-upload-file").change((event) => {
                            const file = event.target.files[0];
                            if (file) {
                                const imgUrl = URL.createObjectURL(file);
                                $("#selected-post-img").attr("src", imgUrl);
                                $(".post-image-holder")[0].style.display = "block";
                                $("#file-operation").value = "changed";

                            }
                        });



                        $("#post-text").click(() => {
                            $("#modal-wrapper").slideDown();
                            if ($("#selected-post-img").attr("src") || $("#post-caption").value.length > 0) {
                                $("#post-share-btn").prop('disabled', false);
                            } else {
                                $("#post-share-btn").prop('disabled', true);
                            }

                        });

                        $(".closeModal").click(() => {
                            $(".modal-wrapper").slideUp();
                        })





                        $(".replyComment").click(function () {
                            const commentId = $(this).data("id");
                            let commentContainer = `<input maxlength='254' type='text' min-length='1' max-length='255' id='replyCommentField-${commentId}'/>`;
                            
                            $(`#replyCommentField-${commentId}`).keyup(() => {
                                if ($(`#replyCommentField-${commentId}`).val().length > 0) {
                                    $(`#replyComment-${commentId}`).prop('disabled', false);
                                } else {
                                    $(`#replyComment-${commentId}`).prop('disabled', true);
                                }
                            });
                           
                           

                            console.log(document.getElementById(`replyComment-${commentId}`).dataset.mode);
                            if (document.getElementById(`replyComment-${commentId}`).dataset.mode == "enter-comment") {
                                $(commentContainer).insertAfter($(`#replyComment-${commentId}`));
                                document.getElementById(`replyComment-${commentId}`).dataset.mode = "save-comment"
                                document.getElementById(`replyComment-${commentId}`).innerText = "save comment"
                            } else if (document.getElementById(`replyComment-${commentId}`).dataset.mode == "save-comment") {
                                
                                const commentContent = document.getElementById(`replyCommentField-${commentId}`).value;
                                $.ajax({
                                    url: "./server/api/comments/insertReplyComment.php",
                                    type: "POST",
                                    data: {
                                        parent_comment_id: commentId,
                                        comment_content: commentContent,
                                        comment_author: <?php echo $uid; ?>

                                    },
                                    success: function (success) {
                                        document.getElementById(`replyComment-${commentId}`).dataset.mode = "enter-comment";
                                        
                                        fetchComments();
                                    },
                                    error: function (error) {
                                        document.getElementById(`replyComment-${commentId}`).dataset.mode = "enter-comment";
                                        fetchComments();

                                    }
                                })
                            }

                            // $(`#replyComment-${commentId}`).append(`<input maxlength='254' type='text' id='replyCommentField-${commentId}'/>`);

                            console.log(commentId);
                            $("#parentCommentIdHolder").val(commentId);
                        });

                    },
                    error: function (error) {
                        // console.log("Error fetching comments:", error);
                    }
                });
            });
        }

        getComments.addEventListener("click", () => {
            let getLikes = document.getElementById("getLikes");
            getLikes.classList.remove("active-btn");
            getComments.classList.add("active-btn");
            fetchComments();
        })

        getLikes.addEventListener("click", () => {
            getLikes.classList.add("active-btn");
            getComments.classList.remove("active-btn");
            getPostsLikes();
        })

        $.ajax({
            url: "./server/api/getLikes.php",
            type: "POST",
            data: {
                postId: <?php echo $postId; ?>
            },
            success: function (data) {
                let likesObj = JSON.parse(data);
                // console.log("likes", likesObj);
                let liked_byObj = likesObj.map((item) => item.liked_by);
                // console.log(liked_byObj);

                let likedState = (liked_byObj.indexOf(localStorage.getItem("mp-uid")) != -1) ? "./assets/images/heart.png" : "./assets/images/heart-outline.png";
                // console.log("index", likedState);
                likedStateImg.src = likedState;
                likeCount.innerText = likesObj.length;

                let likesHtml = "";
                likesObj.forEach((item) => {
                    likesHtml += `
                <a class="right-nav-item" href="user.php?id=${item.uid}">
            <img class="right-nav-item-img" src="${item.profile_picture}">
            <span>${item.fname} ${item.lname}</span>
        </a>
                `;

                })

                if (likesHtml.length == 0) {
                    likeCommentContainer.innerHTML = "<p>No likes</p>";
                } else {
                    likeCommentContainer = likesHtml;

                }

            },
            error: function (data) {
                // console.log("failed");
            }
        })


        function getPostsLikes() {
            let getLikes = document.getElementById("getLikes");
            let getComments = document.getElementById("getComments");
            let likedStateImg = document.getElementById("likeState");
            let likeCount = document.getElementById("like-count");
            let likeCommentContainer = document.getElementById("like-comment-container");
            $.ajax({
                url: "./server/api/getLikes.php",
                type: "POST",
                data: {
                    postId: <?php echo $postId; ?>
                },
                success: function (data) {
                    let likesObj = JSON.parse(data);
                    // console.log("likes", likesObj);
                    let liked_byObj = likesObj.map((item) => item.liked_by);
                    // console.log(liked_byObj);

                    let likedState = (liked_byObj.indexOf(localStorage.getItem("mp-uid")) != -1) ? "./assets/images/heart.png" : "./assets/images/heart-outline.png";
                    // console.log("index", likedState);
                    likedStateImg.src = likedState;
                    likeCount.innerText = likesObj.length;

                    let likesHtml = "";
                    likesObj.forEach((item) => {
                        likesHtml += `
                                    <a class="right-nav-item" href="user.php?id=${item.uid}">
                                            <img class="right-nav-item-img" src="${item.profile_picture}">
                                            <span>${item.fname} ${item.lname}</span>
                                    </a>
                                    `;
                    })

                    likeCommentContainer.innerHTML = likesHtml;

                },
                error: function (data) {
                    // console.log("failed");
                }
            })
        }








        likedStateImg.addEventListener("click", () => {
            let likeCommentContainer = document.getElementById("like-comment-container");

            let src = likedStateImg.src;
            let likeCount = document.getElementById("like-count");

            if (src.includes("assets/images/heart.png")) {
                likeCount.innerHTML = parseInt(likeCount.innerHTML) - 1;

                likedStateImg.src = "./assets/images/heart-outline.png";
            } else {
                likeCount.innerHTML = parseInt(likeCount.innerHTML) + 1;

                likedStateImg.src = "./assets/images/heart.png";
            }

            $.ajax({
                url: "./server/api/addLike.php",
                type: "POST",
                data: {
                    postId: <?php echo $postId; ?>
                },
                success: (msg) => {
                    // console.log("return " + msg);
                    getPostsLikes();
                },
                error: (msg) => {
                    // console.log(msg);
                    localStorage.getItem("mp-uid");
                }
            });
        });


        function postComment(id) {
            let myUid = <?php echo $_SESSION['user']['uid']; ?>;
            let commentText = document.getElementById("post-comment-" + id);
            $.ajax({
                url: "./server/api/insertComment.php",
                type: "POST",
                data: {
                    postId: id,
                    commentAuthor: myUid,
                    commentContent: commentText.value
                },
            })
            commentText.value = null;
            fetchComments();
        }
    </script>
    <?php include_once ("./parts/js-script-files/js-script.php"); ?>
    <?php include_once ("./parts/js-script-files/strict-and-activity-update.php"); ?>

</body>

</html>