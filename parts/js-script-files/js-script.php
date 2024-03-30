<script>
    // ----------------------------------------------------------------------//
    //  Toggle profile menu

        $("#nav-profile-img").click(() => {
        if ($("#profile-menu").hasClass("show")) {
            console.log("has class");
            $("#profile-menu").removeClass("show");
            $("#profile-menu").hide().slideDown(500);
        } else {
            console.log("no class class");

            $("#profile-menu").show().slideUp(500);
            $("#profile-menu").addClass("show");
        }
        console.log("clicked");
    })

    $("#nav-profile-img").click(()=>{
        console.log("clice");
    })

    $(window).resize(() => {
        if (window.innerWidth <= 600) {
            console.log($(".navbar-title")[0]);
            $(".navbar-title")[0].innerText = "MP";
        } else {
            $(".navbar-title")[0].innerText = "MitraPark";

        }
    })
    setInterval(() => {
        console.log("aaaaaaaaaaaaa00");
    }, 1000);

    setInterval(() => {
        console.log("aaaaaaaaaaaaa00");
    }, 1000);


    // class name : 'nav-icon' for showing notifications || current-count='number'
    function updateNewNotificationStatus() {
        $.ajax({
            url: "./server/api/notification/getNewNotificationCount.php",
            success: function (getData) {
                let newState = JSON.parse(getData);
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
                console.log("check", lastActive);
            }
        })
    }

    function update_strict_mode_timeout() {
        $.ajax({
            url: "./server/api/strict-mode/update_strictMode.php",
            success: function (msg) {
                const strictModeStatus = JSON.parse(msg);
                console.log("finish");

                if (strictModeStatus['strict-mode'] == true && strictModeStatus['strict-lock'] == true) {
                    console.log("finish");
                    window.location.href = "feed.php";
                    console.log("finish--");

                }
            }
        })
    }

    setInterval(() => {
        console.log("trigger");
        update_activity_datetime();
        update_strict_mode_timeout();
        updateNewNotificationStatus();
        console.log("trigger");
    }, 5000);

    


    

</script>