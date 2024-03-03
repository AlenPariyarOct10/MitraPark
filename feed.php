<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['loggedIn'])) {
    header('Location: login.php?loginFirst1');
}
if (isset($_SESSION['loggedIn'])) {
    if ($_SESSION['loggedIn'] == false) {
        header('Location: login.php?loginFirst2');
    }
}

include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
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

</head>

<body>
    <div class='navbar'>
        <div class='left-nav-part'>
            <?php echo $aboutSite['system_name']; ?>
        </div>
        <div class='center-nav-part'>
            <a href="feed.php"><i class='fa-solid fa-house active-tab'></i></a>
            <a href="kurakani.html"><i class='fa-regular fa-message'></i></a>
            <a href="mitras.html"><i class='fa-solid fa-user-group'></i></a>
        </div>
        <div class='right-nav-part'>
            <img class='profile-picture-holder' src='alen-profile.jpg'>
        </div>
    </div>
    <div class='body'>
        <div class='left-nav'>
            <div class='left-top'>
                <div class='left-inner-heading'>
                    <span class='dim-label'>
                        Mitra's Requests
                    </span>
                    <hr class="label-underline">
                </div>
                <div class="left-inner-body">
                    <div class="mitra-request-list-item" id="request-1">
                        <a class="redirect-to-profile" href="#profile-link">
                            <img class="mitra-request-profile-list" src="anjali.jpg">
                            <span class="uname">
                                Anjali Thapa
                            </span>
                        </a>
                        <a class="mitra-request-control-btn">
                            <img src="add-mitra.png" height="30px" alt="">
                            <span>Add Mitra</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="left-bottom">
                <div class="left-inner-heading">
                    <span class="dim-label">
                        Kurakani Station
                    </span>
                    <hr class="label-underline">
                </div>
                <div class="left-inner-body">
                    <div class="mitra-request-list-item" id="request-1">
                        <a class="redirect-to-profile" href="#profile-link">
                            <img class="mitra-request-profile-list" src="kpoli.jpg">
                            <span class="uname">
                                KP Oli
                            </span>
                        </a>
                        <a class="mitra-request-control-btn">
                            <span>🙏</span>
                            <span>Namaste</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="mid-body" class="mid-body">
            <form id="postForm" method="POST" action="./server/api/uploadPost.php" class="add-post"
                enctype="multipart/form-data">
                <div class="post-upper">
                    <img class="profile-picture-holder" src="alen-profile.jpg">
                    <textarea name="post-text" id="post-text"></textarea>
                </div>
                <hr>
                <div class="post-bottom">
                    <select name="visibile-mode" class="post-bottom-element" id="reach-select">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                        <option value="mitras">Mitra's</option>
                    </select>
                    <div class="post-bottom-element">
                        <label for='file'>Photo / Video</label>
                        <input type='file' accept=".jpg, .jpeg, .png" style='display: none;' name='file' id='file'>
                    </div>
                    <button type="submit" id="share-btn" class="post-bottom-element">
                        Share
                    </button>
                </div>
            </form>


        </div>
        <div class='right-nav'>
            <a class='right-nav-item' id='my-profile' href='#my-profile'>
                <img class='right-nav-item-img' src='alen-profile.jpg'>
                <span>My Profile</span>
            </a>
            <hr>
            <a class='right-nav-item' href='#setting'>
                <img class='right-nav-item-img' src='./assets/images/settings.png'>
                <span>Setting</span>
            </a>
        </div>
    </div>

    <script src='./assets/scripts/jquery.js'></script>
    <script src='posts.js'></script>
    <script>
       

    </script>


</body>

</html>