<?php include_once ("./server/api/strict-mode/redirect_strict_mode.php"); ?>
<script>
    let npi =document.getElementById("nav-profile-img");
npi.addEventListener("click",()=>{
    console.log("clicked");
})
</script>
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
            <img height="70px" style="border-radius: 50%;" class="profile-img" src="alen-profile.jpg" alt="">
        </div>
        <div class="profile-info">
            <p id="profile-info-uname">Alen Pariyar</p>
            <a class="profile-menu-item" href="">
                My profile
            </a>
            <a class="profile-menu-item" href="">
                Setting
            </a>
        </div>
    </div>
   
