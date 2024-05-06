<script src="./assets/scripts/jquery.js"></script>
<script>
$("#search-field-inp").focus(() => {
    let resultContainer = document.getElementById("filter-search-result");
    $.ajax({
        url: "./server/api/kurakani/getAllMitras.php",
        success: function(response) {
            // console.log(response);
            let responseObj = JSON.parse(response);
            responseObj = responseObj.filter(item => item.uid != <?php echo $_SESSION['user']['uid']; ?>);
            // console.log("filter 1 , ", responseObj);
            // console.log("filter 1 , ", <?php echo $_SESSION['user']['uid']; ?>);

            $("#search-field-inp").keyup(() => {
                let searchTerm = $("#search-field-inp").val().toLowerCase(); // Convert input to lowercase
                let filteredResults = responseObj.filter(item => item.uname.toLowerCase().includes(searchTerm)); // Convert text to lowercase before comparison
                // console.log(filteredResults);
                // console.log("len->",filteredResults.length);
                if (filteredResults.length !== 0 && searchTerm.length!=0) {
                    resultContainer.innerHTML = "";
                    filteredResults.forEach((item) => {
                        resultContainer.innerHTML += `<div class="mitra-request-list-item" id="request-${item.uid}">
                            <a class="redirect-to-profile" href="chat.php?uid=${item.uid}">
                                <img class="mitra-request-profile-list" src="${item.profile_picture ? item.profile_picture : '/MitraPark/assets/images/user.png'}">
                                <span class="uname">${item.uname}</span>
                            </a>
                        </div>`;
                    });
                } else {
                    resultContainer.innerHTML = "";
                }
            });
        },
        error: () => {
            return [];
        }
    });
});



   
    

    function timeAgo(postedTime) {
        const postedDate = new Date(postedTime);
        const currentDate = new Date();
        const timeDifference = currentDate - postedDate;

        const seconds = Math.floor(timeDifference / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);
        const months = Math.floor(days / 30);
        const years = Math.floor(days / 365);

        if (years > 0) {
            return `${years} year${years > 1 ? 's' : ''} ago`;
        } else if (months > 0) {
            return `${months} month${months > 1 ? 's' : ''} ago`;
        } else if (days > 0) {
            return `${days} day${days > 1 ? 's' : ''} ago`;
        } else if (hours > 0) {
            return `${hours} hour${hours > 1 ? 's' : ''} ago`;
        } else if (minutes > 0) {
            return `${minutes} min${minutes > 1 ? 's' : ''} ago`;
        } else {
            return 'just now';
        }
    }
    let chatUsersContainer = document.getElementById("chatUsersContainer");
    let chatUsersContainerMobile = document.getElementById("chatUsersContainerMobile");

    var getOnlineStatus = async (uid) => {
    try {
        const status = await $.ajax({
            url: "./server/api/other/checkUserOnlineStatus.php",
            type: "POST",
            data: {
                userId: uid,
            }
        });
        const onlineStatus = JSON.parse(status);
        return onlineStatus.isActive;
    } catch (error) {
        console.error("Error while checking online status:", error);
        return false;
    }
};

const getKurakaniUsers = async () => {
    try {
        const response = await $.ajax({
            url: "./server/api/kurakani/getKurakaniUsers.php",
            type: "GET" // Assuming it's a GET request, adjust if necessary
        });
        // console.log(response);
        let responseObj = JSON.parse(response);
        responseObj = responseObj.filter(item => item.uid != <?php echo $_SESSION['user']['uid']; ?>);
        if(responseObj.length!==0){ 
            chatUsersContainer.innerHTML = "";
            chatUsersContainerMobile.innerHTML = "";
        responseObj.forEach(async (item) => {
            // console.log("container ", item);
            const isOnline = await getOnlineStatus(item.uid);
            const activeDot = isOnline ? '<span class="active-user-dot"></span>' : '';
            chatUsersContainer.innerHTML += `<div class="mitra-request-list-item" id="request-${item.uid}">
                <a class="redirect-to-profile" href="chat.php?uid=${item.uid}">
                    <div class="profile-holder">
                        <img class="mitra-request-profile-list" src="${item.profile_picture ? item.profile_picture : '/MitraPark/assets/images/user.png'}">
                        ${activeDot}
                    </div>
                    <div class="chat-item-container">
                        <span class="uname">${item.uname}</span>
                        <span class="recent-message">${(item.send_by == <?php echo $uid; ?>) ? (item.seen_status == 1 ? 'Seen' : `Sent : ${item.last_message.substr(0, 8)}`) : item.last_message.substr(0, 8)}
                             . <span class="text-time-label">${timeAgo(item.last_updated)}</span>
                        </span>
                    </div>
                </a>
                ${(item.send_by != <?php echo $uid; ?>) ? ((item.seen_status == 0) ? '<span class="new-msg-dot"></span>' : '') : ''}
            </div>`;

            chatUsersContainerMobile.innerHTML += `<div class="mitra-request-list-item" id="request-${item.uid}">
                <a class="redirect-to-profile" href="chat.php?uid=${item.uid}">
                    <img class="mitra-request-profile-list" src="${item.profile_picture ? item.profile_picture : '/MitraPark/assets/images/user.png'}">
                    <span class="uname">${item.uname}</span>
                </a>
            </div>`;
        });
    }else{
        chatUsersContainerMobile.innerHTML = `<div class="mitra-request-list-item">
                No users
            </div>`;
            chatUsersContainer.innerHTML = `<div class="mitra-request-list-item">
                No users
            </div>`;
    }
    } catch (error) {
        console.error("Error while fetching Kurakani users:", error);
    }
};



    let allUsersContainer = document.getElementById("allUsers");

    $.ajax({
        url: "./server/api/kurakani/getAllMitras.php",
        success: function(response) {
            // console.log(response);
            let responseObj = JSON.parse(response);
            responseObj = responseObj.filter(item => item.uid != <?php echo $_SESSION['user']['uid']; ?>);
            if(responseObj.length!==0){ 
            chatUsersContainer.innerHTML = "";
            responseObj.forEach((item) => {
                allUsersContainer.innerHTML += `<div class="mitra-request-list-item" id="request-${(item.uid)}">
                        <a class="redirect-to-profile" href="chat.php?uid=${(item.uid)}">
                            <img class="mitra-request-profile-list" src="${(item.profile_picture) ? (item.profile_picture) : "/MitraPark/assets/images/user.png"}">
                            <span class="uname">
                                ${item.uname}
                            </span>
                        </a>
                    </div>`;

            })
        }else{
            allUsersContainer.innerHTML = `<div class="mitra-request-list-item">
                        No users
                    </div>`;
        }
        }
    })

    $(document).ready(()=>{
       

        let currentMessageCount = 0;
        $.ajax({
                url: "./server/api/kurakani/new-message-count.php",
                success : (newText)=>{
                    const countObj = JSON.parse(newText);
                    currentMessageCount = countObj.messages_count;
                }
            })

        setInterval(()=>{
            $.ajax({
                url: "./server/api/kurakani/new-message-count.php",
                success : (newText)=>{
                    const countObj = JSON.parse(newText);
                    // console.log("unseen ",countObj);
                    // console.log("current ",currentMessageCount)
                    ;
                    if(countObj.messages_count != currentMessageCount)
                    {
                        chatUsersContainer.innerHTML = "";
                        // getKurakaniUsers();
                        currentMessageCount =countObj.messages_count;
                        
                    }
                }
            })
    },5000);
    });
    

    
    
</script>