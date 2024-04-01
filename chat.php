<?php
include_once ('./parts/entryCheck.php');
include_once ('./server/db_connection.php');
include_once ('./server/validation.php');
include_once ('./server/functions.php');
include_once ('./server/db_connection.php');

$aboutSite = $connection->query('SELECT * FROM `system_data`');

$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/kurakani-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="assets/css/mitras-style.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="./assets/css/navbar.css">
    <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">

    <style>
        .mid-body {
            height: 90vh;
        }

        .mitra-request-list-item:hover {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            margin: 1px;
        }

        .message-container {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .m-in {
            justify-content: flex-end;
        }

        .m-out {
            justify-content: flex-start;
        }

        .deleteMsg{
            color: #949494;
            cursor: pointer;
        }

        .deleteMsg:hover{
            color: #d9534f;

        }
    </style>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Kurakani Station</title>
</head>

<body>
    <?php include_once ("./parts/navbar.php"); ?>
    <div class="body">
        <?php include_once ("./parts/kurakani/leftNavPart.php") ?>
        <?php
        $chatUserId = htmlspecialchars($_GET['uid']);
        $getUserQuery = "SELECT concat(fname,' ',lname) as uname, profile_picture, uid FROM `users` WHERE `uid`='$chatUserId'";
        $getUserQuery = mysqli_query($connection, $getUserQuery);
        $getChatUserData = mysqli_fetch_array($getUserQuery, MYSQLI_ASSOC);
        ?>
        <div class="mid-body">
            <a href="kurakani.php" class="back">
                < Go Back </a>
                    <div class="message-head">
                        <div class="mitra-request-list-item" id="chat-user-<?php echo $chatUserId; ?>">
                            <a class="redirect-to-profile" href="user.php?id=<?php echo $chatUserId ?>">
                                <img class="mitra-request-profile-list"
                                    src="<?php echo $getChatUserData['profile_picture']; ?>">
                                <span id="chat-profile-uname" class="uname">
                                    <?php echo $getChatUserData['uname']; ?>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div id="main-container" class="message-conversation">

                    </div>
                    <div class="message-field">
                        <textarea name="" id="message-text"></textarea>
                        <i id="sendBtn" class="fa fa-paper-plane" aria-hidden="true"></i>
                    </div>
        </div>
        <?php include_once ("./parts/rightSidebar.php") ?>
    </div>
</body>
<script src="./assets/scripts/jquery.js"></script>
<script>
    function scrollToBottom() {
    mainChatContainer.scrollTop = mainChatContainer.scrollHeight;
}
    function deleteMsg(id)
    {
        let clickedBtn = document.getElementById("chat-"+id);
        $.ajax({
            url: "./server/api/kurakani/deleteKurakani.php",
            data: {message_id: id},
            type: "POST",
            success: function (response)
            {
                console.log(response);
            }
        })
        clickedBtn.remove();
    }
    
    let receipientUserId = '<?php echo $chatUserId; ?>';
    let chatUsersContainer = document.getElementById("chatUsersContainer");
    $.ajax({
        url: "./server/api/kurakani/getKurakaniUsers.php",
        success: function (response) {
            console.log(response);
            let responseObj = JSON.parse(response);
            responseObj.forEach((item) => {
                console.log("name", item.uname);
                chatUsersContainer.innerHTML += `<div class="mitra-request-list-item" id="kurakani-${item.uid}">
                        <a class="redirect-to-profile" href="chat.php?uid=${item.uid}">
                            <img class="mitra-request-profile-list" src="${(item.profile_picture) ? (item.profile_picture) : "/MitraPark/assets/images/user.png"}">
                            <span class="uname">
                                ${item.uname}
                            </span>
                        </a>
                    </div>`;
            });
        }
    })

    let userChatList = document.getElementById("mitra-request-list-item");

    let mainChatContainer = document.getElementById("main-container");

    let messageBox = document.getElementById("message-text");
    let sendBtn = document.getElementById("sendBtn");

    function refreshMessages() {
        $.ajax({
            url: "./server/api/kurakani/getMessage.php",
            type: "POST",
            data: { receipientId: receipientUserId },
            success: function (response) {
                let chatData = JSON.parse(response);
                mainChatContainer.innerHTML = ""; // Clear previous messages
                chatData.forEach((chat) => {
                    let newChat = "";
                    if (receipientUserId == chat.sender_id && localStorage.getItem("mp-uid") == chat.receiver_id) {
                       
                                newChat = `
                                <div class="message-container m-out">
                                    <div id="${chat.message_id}" class="message-out">
                                        <span>${chat.message_text}</span>
                                    </div>
                                </div>`;
                    } else if (receipientUserId == chat.receiver_id && localStorage.getItem("mp-uid") == chat.sender_id) {
                        newChat = `
                                <div class="message-container m-in" id="chat-${chat.message_id}">
                                <div class="deleteMsg" onclick="deleteMsg(${chat.message_id})" ><i class="fa-solid fa-trash-can"></i></div>
                                    <div class="message-in">
                                        <span>${chat.message_text}</span>
                                    </div>
                                </div>`;
                    }
                    mainChatContainer.innerHTML += newChat;
                });
            }
        });
        scrollToBottom();
    }


    function getMessages() {
        $.ajax({
            url: "./server/api/kurakani/getMessage.php",
            type: "POST",
            data: { receipientId: receipientUserId },
            success: function (response) {
                let chatData = JSON.parse(response);
                let newChat = "";
                chatData.forEach((chat) => {
                    if (receipientUserId == chat.sender_id && localStorage.getItem("mp-uid") == chat.receiver_id) {
                        newChat = `
                            <div class="message-container">
                                <div class="message-in">
                                    <span>${chat.message_text}</span>
                                </div>
                            </div>
                            `;
                    } else if (receipientUserId == chat.receiver_id && localStorage.getItem("mp-uid") == chat.sender_id) {
                        newChat = `
                            <div class="message-container">
                                <div class="message-out">
                                    <span>${chat.message_text}</span>
                                </div>
                            </div>
                            `;
                    }
                    mainChatContainer.innerHTML += newChat;
                  
                })
            }
        })
        scrollToBottom();
       
    }

    // Function to send message
    function sendMessage() {
        let message = messageBox.value.trim();
        if (message !== "") {
            let newChat = `
                    <div class="message-container">
                        <div class="message-out">
                            <span>${message}</span>
                        </div>
                    </div>`;
            // Update UI with sent message
            mainChatContainer.innerHTML += newChat;
            messageBox.value = ""; // Clear message box

           
            $.ajax({
                url: "./server/api/kurakani/sendMessage.php",
                type: "POST",
                data: { receipientId: receipientUserId, msg: message },
                success: function (status) {
                    console.log(status);
                    // Refresh messages after sending
                    refreshMessages();
                }
            });
        }
    }


    $(document).ready(() => {
        refreshMessages();
        scrollToBottom();
    })

    // Set interval to refresh messages every 5 seconds (adjust as needed)
    setInterval(refreshMessages, 5000);

    // Attach event listener to send button
    sendBtn.addEventListener("click", sendMessage);


   



   




</script>

</html>