<?php include_once("./server/api/strict-mode/redirect_strict_mode.php"); ?>

<div class='navbar'>
    <div class='left-nav-part'>
        <a href="./feed.php">
            <?php echo $aboutSite['system_name']; ?>
        </a>
    </div>
    <div class='center-nav-part'>
        <a href="feed.php"><i class='fa-solid fa-house <?php if (strpos($_SERVER['PHP_SELF'], "feed.php") != false) {
                                                            echo "active-tab";
                                                        } ?>'></i><span id="unseenNotification" style="color: red;">ꞏ</span></a>
        <a href="kurakani.php"><i class='fa-regular fa-message <?php if (strpos($_SERVER['PHP_SELF'], "kurakani.php") != false) {
                                                                    echo "active-tab";
                                                                } ?>'></i><span id="unseenNotification" style="color: red;">ꞏ</span></a>
        <a href="mitras.php"><i class='fa-solid fa-user-group <?php if (strpos($_SERVER['PHP_SELF'], "mitras.php") != false) {
                                                                    echo "active-tab";
                                                                } ?>'></i><span id="unseenNotification" style="color: red;">ꞏ</span></a>
        <a href="notifications.php"><i class='fa-solid fa-bell <?php if (strpos($_SERVER['PHP_SELF'], "notifications.php") != false) {
                                                                    echo "active-tab";
                                                                } ?>'></i><span id="unseenNotification" style="color: red;">ꞏ</span></a>
    </div>
    <a href="./profile.php">
        <img class='profile-picture-holder' src='<?php echo "./" . $_SESSION['user']['profile_picture']; ?>'>

    </a>
</div>

</div>
<script>
    <?php
    if (1) {
    ?>
        function update_activity_datetime() {
            $.ajax({
                url: "./server/api/update_activity_dateTime.php",
                success: function(lastActive) {

                }
            })
        }

        function update_strict_mode_timeout() {
            $.ajax({
                url: "./server/api/strict-mode/update_strictMode.php",
                success: function(msg) {
                    console.log(msg);
                }
            })
        }
        setInterval(() => {
            update_activity_datetime();
            update_strict_mode_timeout();
        }, 5000);
    <?php
    }
    ?>
</script>