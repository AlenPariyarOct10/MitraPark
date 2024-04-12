<?php include_once ("./server/api/strict-mode/redirect_strict_mode.php"); ?>

<div id="user-nav">
    <div class="left-part">
        <p class="navbar-title">MitraPark</p>
    </div>
    <div class="center-part">
        <a href="feed.php" class="<?php if (strpos($_SERVER['PHP_SELF'], "feed.php") != false) {
            echo "active";
        } ?>">
            <i class="bx bxs-home"></i>
        </a>
        <a href="kurakani.php" class="<?php if (strpos($_SERVER['PHP_SELF'], "kurakani.php") != false) {
            echo "active";
        } ?>">
            <i id="new-kurakani-count" class="bx bxs-chat"></i>

        </a>
        <a href="notifications.php" class="<?php if (strpos($_SERVER['PHP_SELF'], "notifications.php") != false) {
            echo "active";
        } ?>">
            <i id="new-notifications-count" class="bx bxs-bell-ring"></i>
        </a>
        <a href="mitras.php" class="<?php if (strpos($_SERVER['PHP_SELF'], "mitras.php") != false) {
            echo "active";
        } ?>">
            <i id="new-mitra-count" class="bx bxs-group"></i>
        </a>
    </div>
    <div class="right-part">
        <img id="nav-profile-img" class="profile-img" src="<?php echo "./" . $_SESSION['user']['profile_picture']; ?>">
    </div>
</div>
    <!-- Profile Menu Start -->
    <div id="profile-menu" class="profile-menu">
        <div class="image-holder">
            <img style="border-radius: 50%; height:80px;" class="profile-img" src="<?php echo "./" . $_SESSION['user']['profile_picture']; ?>" alt="">
        </div>
        <div class="profile-info">
            <p id="profile-info-uname"><?php echo $_SESSION['user']['fname']." ".$_SESSION['user']['lname']; ?></p>
            
            <a class="profile-menu-item" href="">
                My profile
            </a>
            <a class="profile-menu-item" href="">
                Setting
            </a>
        </div>
    </div>


   
