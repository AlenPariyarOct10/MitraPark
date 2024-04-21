
<script>
    // ----------------------------------------------------------------------//
    //  Toggle profile menu

        $("#nav-profile-img").click(() => {
        if ($("#profile-menu").hasClass("show")) {
       
            $("#profile-menu").removeClass("show");
            $("#profile-menu").hide().slideDown(500);
        } else {
           

            $("#profile-menu").show().slideUp(500);
            $("#profile-menu").addClass("show");
        }
       
    })

    $("#nav-profile-img").click(()=>{
        console.log("clice");
    })

    $(window).resize(() => {
        if (window.innerWidth <= 600) {
    
            $(".navbar-title")[0].innerText = "MP";
        } else {
            $(".navbar-title")[0].innerText = "MitraPark";

        }
    })


    // class name : 'nav-icon' for showing notifications || current-count='number'
    function updateNewNotificationStatus() {
        $.ajax({
            url: "./server/api/notification/getNewNotificationCount.php",
            success: function (getData) {
                let newState = JSON.parse(getData);
                console.log(newState);
                if (parseInt(newState.unseen) > 0) {

                    if (!$("#new-notifications-count").hasClass("nav-icon")) {
                        $("#new-notifications-count").addClass("nav-icon");
                        $("#new-notifications-count").attr("current-count", newState.unseen);
                        console.log("husss", $("#new-notifications-count").attr("current-count"));
                    } else {
                        $("#new-notifications-count").attr("current-count", newState.unseen);
                    }
                } else {
                    if ($("#new-notifications-count").hasClass("nav-icon")) {
                        $("#new-notifications-count").removeClass("nav-class");
                        $("#new-notifications-count").attr("current-count", 0);
                    }
                }

            }
        });
    }

    function update_activity_datetime() {
        $.ajax({
            url: "./server/api/update_activity_dateTime.php",
            success: function (lastActive) {
                
            }
        })
    }

    function update_strict_mode_timeout() {
        $.ajax({
            url: "./server/api/strict-mode/update_strictMode.php",
            success: function (msg) {
                console.log(msg);
                const strictModeStatus = JSON.parse(msg);
               console.log(strictModeStatus);

                // if (strictModeStatus['strict-mode'] == true && strictModeStatus['strict-lock'] == true) {
               
                //     window.location.href = "feed.php";
                   
                // }
            }
        })
    }

    function check_maintenance_mode()
    {
        $.ajax({
            url: "./server/api/check-maintenance-mode.php",
            success:function(status)
            {
                const maintenanceStatus = JSON.parse(status);
                if(maintenanceStatus['maintenance-mode']==true)
                {
                    window.location.href = "maintenance-mode.php";
                }
            }
        })
    }

    setInterval(() => {
     
        update_activity_datetime();
        update_strict_mode_timeout();
        updateNewNotificationStatus();
        // check_maintenance_mode();
        $.ajax({
            url: "./server/api/strict-mode/check_strict_mode.php",
            type: "POST",
        })
    }, 5000);

</script>