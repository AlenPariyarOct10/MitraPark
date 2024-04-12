<?php echo "---------- hel ". $uid; ?>

<script src="./assets/scripts/jquery.js"></script>
<script>
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
    $.ajax({
    url: "./server/api/kurakani/getKurakaniUsers.php",
    success: function (response) {
        console.log(response);
        let responseObj = JSON.parse(response);
        responseObj = responseObj.filter(item => item.uid != <?php echo $_SESSION['user']['uid']; ?>);
        responseObj.forEach((item) => {
            console.log(item);
            chatUsersContainer.innerHTML += `<div class="mitra-request-list-item" id="request-1">
                    <a class="redirect-to-profile" href="chat.php?uid=${item.uid}">
                        <div class="profile-holder">
                            <img class="mitra-request-profile-list" src="${item.profile_picture ? item.profile_picture : '/MitraPark/assets/images/user.png'}">
                            <span class="active-user-dot"></span>
                        </div>
                        <div class="chat-item-container">
                            <span class="uname">
                                ${item.uname}
                            </span>
                            <span class="recent-message">
                                ${(item.sender_id == <?php echo $uid; ?>) ? (item.seen_status == 1 ? 'Seen' : `Sent : ${item.last_message.substr(0, 5)}`) : item.last_message.substr(0, 5)}
                                 . 
                                <span class="text-time-label">
                                    ${timeAgo(item.last_updated)}
                                </span>
                            </span>
                        </div>
                    </a>
                    ${(item.seen_status == 0) ? '<span class="new-msg-dot"></span>' :''}
                    
                </div>`;

            chatUsersContainerMobile.innerHTML += `<div class="mitra-request-list-item" id="request-1">
                <a class="redirect-to-profile" href="chat.php?uid=${item.uid}">
                    <img class="mitra-request-profile-list" src="${item.profile_picture ? item.profile_picture : '/MitraPark/assets/images/user.png'}">
                    <span class="uname">
                        ${item.uname}
                    </span>
                </a>
            </div>`;
        });
    }
});


    let allUsersContainer =document.getElementById("allUsers");

    $.ajax({
        url: "./server/api/kurakani/getAllMitras.php",
        success: function (response) {
            console.log(response);
            let responseObj = JSON.parse(response);
            responseObj =responseObj.filter(item => item.uid != <?php echo $_SESSION['user']['uid']; ?>);
            responseObj.forEach((item) => {
                allUsersContainer.innerHTML += `<div class="mitra-request-list-item" id="request-1">
                        <a class="redirect-to-profile" href="chat.php?uid=${(item.uid)}">
                            <img class="mitra-request-profile-list" src="${(item.profile_picture) ? (item.profile_picture) : "/MitraPark/assets/images/user.png"}">
                            <span class="uname">
                                ${item.uname}
                            </span>
                        </a>
                    </div>`;
                
            })
        }
    })
</script>