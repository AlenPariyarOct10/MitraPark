<?php

// include_once('./parts/entryCheck.php');
include_once('../server/db_connection.php');
// include_once('./server/validation.php');
include_once('../server/functions.php');

$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);

session_start();
?>



<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
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



    <title>Feed -
        <?php echo $aboutSite['system_name']; ?>
    </title>

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

            height: 100%;
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

        body {
            color: black;
        }

        * {
            font-family: 'poppins';
            font-size: 1rem;
        }

        .row-caption-container {
            width: 100%;
        }

        .text-area {
            width: 80%;
        }



        .post-details>span {
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

        .pop-up-notification {

            position: absolute;
            bottom: 2%;
            z-index: 1;
            width: 70%;
            box-shadow: 0.5px 0.5px 5px 0.5px #6d6d6d;
            border-radius: 2px;
            display: flex;
        }

        .comment-container-row {
            display: flex;
            flex-direction: column;
            padding: 3px;

            border: 1px solid #a7a7a7;
        }
    </style>
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            flex-direction: row;
            width: 100%;
        }

        .sidebar {
            height: 100vh;
        }

        .mid-body {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
            padding: 20px;
            overflow: scroll;
            height: 150vh;


        }

        #profile-img {
            height: 150px;
        }

        .inner-mid-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            overflow: scroll;
        }

        .dim-label {
            font-size: medium;
        }

        .label-underline {
            border: 1px solid rgb(163, 163, 163);
            width: 100%;
        }

        a {
            color: black;
        }

        .post-item {
            width: 40%;
        }

        .post-item-footer {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            align-items: center;
        }

        .like-count {
            width: 30px;
        }

        .post-item-footer a {
            width: 30px;
        }

        .wrapper {
            height: 100vh;
            width: 100%;
            overflow: scroll;
        }
    </style>

</head>

<body>
    <?php include_once("./parts/sidebar.php"); ?>

    <?php
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    ?>

    <?php
    $postId = htmlspecialchars($_GET['postId']);
    $getPost = "SELECT *, concat(fname,' ',lname) as uname FROM `posts` INNER JOIN users u ON author_id=u.uid WHERE post_id='$postId'";
   
    if (1) {
      

        $getPost = mysqli_query($connection, $getPost);
        $getPost = mysqli_fetch_assoc($getPost);

        $reportIdQuery = "SELECT `report_id` FROM `reports` WHERE `component_id`='$postId' AND type='post'";
        $reportId = mysqli_query($connection, $reportIdQuery);
        $reportId = mysqli_fetch_assoc($reportId);
        // $reportId = $reportId['report_id'];

        $isMitra = true;

    ?>

        <div id="mid-body" class="mid-body">

            <?php
            if ($_SESSION['loggedInAdmin'] == true) {
            ?>

                <div class="wrapper">
                    <div class="left-inner-heading">
                        <span class="dim-label">
                            <?php echo "<b>" . $getPost['uname'] . "</b>'s post."; ?>
                        </span>
                        <hr class="label-underline">
                    </div>
                    <div class="post-item">
                        <div class="post-item-head">
                            <div class="post-item-head-left">
                                <img class="profile-picture-holder" src="<?php echo '../' . $getPost['profile_picture']; ?>" alt="" srcset="">
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

                            <img id="post-img" style="border-radius:10px;" src="<?php echo ".." . $getPost['media']; ?>" alt="" srcset="">
                        </div>
                        <div class="post-item-footer">

                            <div data-id=<?php echo $postId; ?> class="like-container">
                                <img id="likeState" height="30px" src="">
                                <span id="like-count" class="like-count">0</span>
                            </div>
                            <div class="comment-container">
                                <img height="30px" src="../assets/images/comment-outline.png">
                            </div>

                        </div>
                    </div>

                    <div class="post-item">
                        <div id="view-likes-comments" style="margin:5px;">
                            <button id="restrictPost">Loading ....</button>
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
            <img class="right-nav-item-img" src="../' . $likes['profile_picture'] . '">
            <span>' . $likes['uname'] . '</span>
        </a>';
                            }


                            ?>
                        </div>
                    </div>
                </div>
        </div>
    <?php
            } else {
    ?>
        <div id="mid-body" class="mid-body">


            <div class="post-item">
                Post not found
            </div>
        </div>
        </div>

    <?php
            }
        } else {
    ?>
    <div id="mid-body" class="mid-body">


        <div class="post-item">
            Post not found
        </div>
    </div>


<?php
        }

?>


<script src='../assets/scripts/jquery.js'></script>
<script>
    let getLikes = document.getElementById("getLikes");
    getLikes.classList.add("active-btn");
    let getComments = document.getElementById("getComments");
    let likedStateImg = document.getElementById("likeState");
    let likeCount = document.getElementById("like-count");
    let likeCommentContainer = document.getElementById("like-comment-container");


    function updateRestrict() {
        $.ajax({
            url: "./api/restriction/get-post-restriction-status.php",
            type: "POST",
            data: {
                post_id: <?php echo $postId; ?>,
            },
            success: async (status) => {

                const restrictedStatus = await JSON.parse(status);
                console.log(restrictedStatus);


                if (restrictedStatus.status == "active") {
                    $("#restrictPost")[0].innerHTML = "Restrict Post";

                } else {
                    $("#restrictPost")[0].innerHTML = "Unrestrict Post";
                }
            }
        })
    }

    $("#restrictPost").click(() => {
        if ($("#restrictPost")[0].innerText == "Restrict Post") {
            restrictPost(<?php echo $reportId; ?>);
            updateRestrict();
        } else if ($("#restrictPost")[0].innerText == "Unrestrict Post") {
            unrestrictPost(<?php echo $reportId; ?>);
            updateRestrict();

        }
    })






    function fetchComments() {
        let postId = <?php echo $postId; ?>;
        let commentsContainer = document.getElementById("like-comment-container");

        $(document).ready(() => {
            let commentBody = "";
            $.ajax({
                url: "../server/api/getComments.php",
                type: "POST",
                data: {
                    postId: postId
                },
                success: function(response) {
                    const responseObj = JSON.parse(response);

                    responseObj.forEach((item) => {
                        commentBody += `
                    <div class="comment-container-row">
                        <div class="post-item-head">
                            <div class="post-item-head-left">
                                <img class="profile-picture-holder" src="../${item.profile_picture}" alt="" srcset="">
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
                            
                        </div>
                        <div id="rcomment-${item.comment_id}">
                        </div>
                    </div>`;



                        $.ajax({
                            url: "../server/api/comments/getReplyComments.php",
                            type: "POST",
                            data: {
                                parentCommentId: item.comment_id
                            },
                            success: (response) => {
                                let resObj = JSON.parse(response);
                                console.log(resObj);
                                let div = document.getElementById("rcomment-" + item.comment_id);

                                resObj.forEach((rcomment) => {
                                    console.log(rcomment);
                                    div.innerHTML += `<div style="border-left: 1px solid black; margin: 10px;">
                        <div class="post-item-head">
                            <div style="margin:10px;" class="post-item-head-left">
                                <img class="profile-picture-holder" src="../${rcomment.profile_picture}" alt="" srcset="">
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
                           
                        </div>
                       
                    </div>`;
                                })

                            }

                        })
                    });

                    if (commentBody.length == 0) {
                        commentsContainer.innerHTML = "<p>No comments</p>";
                    } else {

                        commentsContainer.innerHTML = commentBody;
                    }


                    // ALEN : Delete Comment API
                    $(".deleteComment").click(function(event) {
                        const commentId = $(this).data("id");
                        console.log(commentId);

                        if (this.innerText != "Confirm Delete") {
                            this.innerText = "Confirm Delete";
                        } else {
                            $.ajax({
                                url: "../server/api/comments/deleteComment.php",
                                type: 'POST',
                                data: {
                                    commentId: commentId
                                },
                                success: function(data) {
                                    fetchComments();
                                }
                            })
                        }
                    });

                },
                error: function(error) {
                    console.log("Error fetching comments:", error);
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
        url: "../server/api/getLikes.php",
        type: "POST",
        data: {
            postId: <?php echo $postId; ?>
        },
        success: function(data) {
            console.log(data);
            let likesObj = JSON.parse(data);
            console.log("likes", likesObj);
            let liked_byObj = likesObj.map((item) => item.liked_by);
            console.log(liked_byObj);

            let likedState = (liked_byObj.indexOf(localStorage.getItem("mp-uid")) != -1) ? "../assets/images/heart.png" : "../assets/images/heart-outline.png";
            console.log("index", likedState);
            likedStateImg.src = likedState;
            likeCount.innerText = likesObj.length;

            let likesHtml = "";
            likesObj.forEach((item) => {
                likesHtml += `
                <a class="right-nav-item" href="user.php?id=${item.uid}">
            <img class="right-nav-item-img" src="../${item.profile_picture}">
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
        error: function(data) {
            console.log("failed");
        }
    })


    function getPostsLikes() {
        let getLikes = document.getElementById("getLikes");
        let getComments = document.getElementById("getComments");
        let likedStateImg = document.getElementById("likeState");
        let likeCount = document.getElementById("like-count");
        let likeCommentContainer = document.getElementById("like-comment-container");
        $.ajax({
            url: "../server/api/getLikes.php",
            type: "POST",
            data: {
                postId: <?php echo $postId; ?>
            },
            success: function(data) {
                let likesObj = JSON.parse(data);
                console.log("likes", likesObj);
                let liked_byObj = likesObj.map((item) => item.liked_by);
                console.log(liked_byObj);

                let likedState = (liked_byObj.indexOf(localStorage.getItem("mp-uid")) != -1) ? "../assets/images/heart.png" : "../assets/images/heart-outline.png";
                console.log("index", likedState);
                likedStateImg.src = likedState;
                likeCount.innerText = likesObj.length;

                let likesHtml = "";
                likesObj.forEach((item) => {
                    likesHtml += `
                                    <a class="right-nav-item" href="user.php?id=${item.uid}">
                                            <img class="right-nav-item-img" src=".${item.profile_picture}">
                                            <span>${item.fname} ${item.lname}</span>
                                    </a>
                                    `;
                })

                likeCommentContainer.innerHTML = likesHtml;

            },
            error: function(data) {
                console.log("failed");
            }
        })
    }

    updateRestrict();
</script>
</body>

</html>