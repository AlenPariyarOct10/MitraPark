<script src="./assets/scripts/jquery.js"></script>
<script>
    let chatUsersContainer = document.getElementById("chatUsersContainer");
    let chatUsersContainerMobile = document.getElementById("chatUsersContainerMobile");
    $.ajax({
        url: "./server/api/kurakani/getKurakaniUsers.php",
        success: function (response) {
            console.log(response);
            let responseObj = JSON.parse(response);
            responseObj =responseObj.filter(item => item.uid != <?php echo $_SESSION['user']['uid']; ?>);
            responseObj.forEach((item) => {
                chatUsersContainer.innerHTML += `<div class="mitra-request-list-item" id="request-1">
                        <a class="redirect-to-profile" href="chat.php?uid=${(item.uid)}">
                            <img class="mitra-request-profile-list" src="${(item.profile_picture) ? (item.profile_picture) : "/MitraPark/assets/images/user.png"}">
                            <span class="uname">
                                ${item.uname}
                            </span>
                        </a>
                    </div>`;
                    chatUsersContainerMobile.innerHTML += `<div class="mitra-request-list-item" id="request-1">
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