<div class='navbar'>
    <div class='left-nav-part'>
        <a href="./feed.php">
        <?php echo $aboutSite['system_name']; ?>
        </a>
    </div>
    <div class='center-nav-part'>
        <a href="feed.php"><i class='fa-solid fa-house <?php if (strpos($_SERVER['PHP_SELF'], "feed.php") != false) {
            echo "active-tab";
        } ?>'></i></a>
        <a href="kurakani.php"><i class='fa-regular fa-message <?php if (strpos($_SERVER['PHP_SELF'], "kurakani.php") != false) {
            echo "active-tab";
        } ?>'></i></a>
        <a href="mitras.php"><i class='fa-solid fa-user-group <?php if (strpos($_SERVER['PHP_SELF'], "mitras.php") != false) {
            echo "active-tab";
        } ?>'></i></a>
        <a href="notifications.php"><i class='fa-solid fa-bell <?php if (strpos($_SERVER['PHP_SELF'], "notifications.php") != false) {
            echo "active-tab";
        } ?>'></i></a>
    </div>
    <a href="./profile.php">
    <img class='profile-picture-holder' src='<?php echo "./" . $_SESSION['user']['profile_picture']; ?>'>
        
    </a>
</div>
</div>
<script>
   
    function update_activity_datetime()
    {
        $.ajax({
                url: "./server/api/update_activity_dateTime.php",
                success: function (lastActive)
                {
                    
                }
            })
    }
    setInterval(()=>{
            update_activity_datetime();
        },5000);
</script>