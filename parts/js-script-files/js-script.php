
<script>
    // ----------------------------------------------------------------------//
    //  Toggle profile menu

        $("#nav-profile-img").click(() => {
        if ($("#profile-menu").hasClass("show")) {
            console.log("removing");
            $("#profile-menu").removeClass("show");
       
            
            $("#profile-menu").show().slideUp(500);
        } else {
            console.log("showing");
            $("#profile-menu").addClass("show");

            $("#profile-menu").hide().slideDown(500);
        }
       
    })

    $("#nav-profile-img").click(()=>{
        console.log("clice");
    })

    $(window).resize(() => {
        if (window.innerWidth <= 600) {
    
            $(".navbar-title")[0].innerText = "<?php $aboutSite['system_name']; ?>";
        } else {
            $(".navbar-title")[0].innerText = "<?php $aboutSite['system_name']; ?>";

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

    function updateNewMessagesStatus()
    {
        console.log("new--text");
        $.ajax({
            url: "./server/api/kurakani/new-message-count.php",
            success: function (getData) {
                let newState = JSON.parse(getData);
                console.log(newState);
                if (parseInt(newState.messages_count) > 0) {

                    if (!$("#new-kurakani-count").hasClass("nav-icon")) {
                        $("#new-kurakani-count").addClass("nav-icon");
                        $("#new-kurakani-count").attr("current-count", (newState.messages_count<10)?newState.messages_count:'9+');
                    } else {
                        $("#new-kurakani-count").attr("current-count", newState.messages_count);
                    }
                } else {
                    if ($("#new-kurakani-count").hasClass("nav-icon")) {
                        $("#new-kurakani-count").removeClass("nav-class");
                        $("#new-kurakani-count").attr("current-count", 0);
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

                if (strictModeStatus['strict-mode'] == true && strictModeStatus['strict-lock'] == true) {
                    window.location.href = "feed.php";  
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
        updateNewMessagesStatus();
        // check_maintenance_mode();
        $.ajax({
            url: "./server/api/strict-mode/check_strict_mode.php",
            type: "POST",
        })
    }, 5000);


    if($("#mitraList").length!==0)
    {
        function getFriendRequests() {
            let mitraRequestList = document.getElementById("mitraList");
            $.ajax({
                url: "./server/api/getFriendRequests.php",
                success: function(success) {
                    console.log("requests->",(success));
                    mitraRequestList.innerHTML = (success!=="")?success:"No requests found";
                     
                }
            })
        }

        $(document).ready(getFriendRequests);
        setInterval(() => {
            getFriendRequests();
        }, 5000);
    }
    



</script>