<script>
    <?php
    if(session_status()!==PHP_SESSION_ACTIVE)
    {
        session_start();
    }
    ?>
function update_activity_datetime() {
        $.ajax({
            url: "./server/api/update_activity_dateTime.php",
            success: function (lastActive) {
                console.log(lastActive);
            }
        })
    }

    function update_strict_mode_timeout() {
        $.ajax({
            url: "./server/api/strict-mode/update_strictMode.php",
            success: function (msg) {
                // console.log(msg);
                const strictModeStatus = JSON.parse(msg);
               console.log("alen->",strictModeStatus);

                if (strictModeStatus['strict-mode'] == true && strictModeStatus['strict-lock'] == true) {
                    window.location.href = "feed.php";  
                }


                if(strictModeStatus['strict-mode']==true && strictModeStatus['getWarning']=="1" && parseInt(strictModeStatus['availableAccessSeconds']) <= 900)
                {
                    // console.log("out of time");
                    window.location.href = "timeOutWarn.php";
                }
            }
        })
    }

    function check_maintenance_mode()
    {
        $.ajax({
            url: "./server/api/check-maintenance-mode.php",
            success:function(status)
            {
                console.log("maintenance -> "+status);
                const maintenanceStatus = JSON.parse(status);
                if(maintenanceStatus['maintenance-mode']==true)
                {
                    window.location.href = "maintenance-mode.php";
                }
            }
        })
    }

    function check_user_restricted_status()
    {
        $.ajax({
            url: "./server/api/other/check-user-restricted.php",
            type: "POST",
            data: {
                userId: <?php echo $_SESSION['user']['uid']; ?>,
            },
            success: function(status)
            {
                
                let statusOBJ = JSON.parse(status);

                if(statusOBJ["restricted-status"]==true)
                {
     console.log(statusOBJ)
                    window.location.href = "user-restricted.php";
                }
            }
        })
    }

    setInterval(()=>{
        check_maintenance_mode();
        update_strict_mode_timeout();
        update_activity_datetime();
        check_user_restricted_status();
    },5000)
    
    </script>