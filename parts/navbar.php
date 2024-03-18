<div class='navbar'>
        <div class='left-nav-part'>
            <?php echo $aboutSite['system_name']; ?>
        </div>
        <div class='center-nav-part'>
            <a href="feed.php"><i class='fa-solid fa-house <?php if(strpos($_SERVER['PHP_SELF'],"feed.php")!=false){echo "active-tab";} ?>'></i></a>
            <a href="kurakani.html"><i class='fa-regular fa-message <?php if(strpos($_SERVER['PHP_SELF'],"kurakani.php")!=false){echo "active-tab";} ?>'></i></a>
            <a href="mitras.php"><i class='fa-solid fa-user-group <?php if(strpos($_SERVER['PHP_SELF'],"mitras.php")!=false){echo "active-tab";} ?>'></i></a>
        </div>
        <div class='right-nav-part'>
            <img class='profile-picture-holder' src='<?php echo "./".$_SESSION['user']['profile_picture']; ?>'>
        </div>
</div>