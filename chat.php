<?php
include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');
include_once('./server/db_connection.php');

$aboutSite = $connection->query('SELECT * FROM `system_data`');

$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>
<?php
            $chatUserId = htmlspecialchars($_GET['uid']);
            $getUserQuery = "SELECT concat(fname,' ',lname) as uname, profile_picture, uid FROM `users` WHERE `uid`='$chatUserId'";
            $getUserQuery = mysqli_query($connection, $getUserQuery);
            $getChatUserData = mysqli_fetch_array($getUserQuery, MYSQLI_ASSOC);
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/kurakani-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="assets/css/mitras-style.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="./assets/css/navbar.css">
    <link rel="stylesheet" href="./assets/css/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="./<?php echo $aboutSite['system_logo']; ?>" type="image/x-icon">


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

        .deleteMsg > i{
            cursor: pointer;
            color: rgb(104, 104, 104);
        }

        .deleteMsg > i:hover{
            color: rgb(255, 87, 87);

        }

        .message-out > span, .message-in > span{
            padding: 8px;
        }

        .online-status-icon{
            height: 8px;
            width: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .isactive{
            background-color: rgb(59, 255, 82);
        }
        .inactive{
            background-color: rgb(255, 59, 59);
        }

        .online-status{
            background-color: rgb(236, 236, 236);
            padding: 0.5px 10px;
            border-radius: 10px;
            width: fit-content
        }

        .message-out{
            position: relative;
        }

        .bx-check-double{
            position: absolute;
            bottom: 0;
        }

        .mitra-request-list-item:hover {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            margin: 1px;
        }

        .for-mobile{
            display: none;
            visibility: hidden;
        }

        @media screen and (max-width: 600px)
        {
            .hide-mobile{
                visibility: hidden;
                display: none;
            }

            .for-mobile{
                display: block;
                visibility: visible;
            }
        }

        /* ALEN : Kurakani-Style */
        .recent-message{
            font-size: small;
            padding-left: 5px;
        }

        .chat-item-container{
            color: rgb(62, 62, 62);
            display: flex;
            padding-left: 5px;
            flex-direction: column;
        }

        .new-msg-dot {
            height: 12px;
            width: 12px;
            background-color: #3da5ff;
            border-radius: 50%;
            display: inline-block;
            }
        .active-user-dot {
            height: 15px;
            width: 15px;
            background-color: #2bff19;
            border-radius: 50%;
            display: inline-block;
            position: absolute;
            bottom: 5px;
            right: 1px;
            box-shadow: 0.5px 0.5px 2px 0.5px #78787892;
            }

        .text-time-label{
            padding-left: 5px;
            font-size: x-small;
        }

        .profile-holder{
            position: relative;
        }
        
    </style>

    <?php include_once("../MitraPark/assets/css/dynamicColor.php"); ?>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title> <?php echo $getChatUserData['uname']; ?> ~ Chat</title>
</head>

<body>
    <?php include_once("./parts/navbar.php"); ?>
    <div class="body">
        <?php include_once ("./parts/kurakani/leftNavPart.php"); ?>

        
        
        <div class="mid-body">
        <div id="chatUsersContainerMobile" class="mid-body for-mobile">
        </div>
            <a href="kurakani.php" class="back">
                < Go Back </a>
                <?php
                    // ALEN : User Validation
                    $uid = $_SESSION['user']['uid'];
                    $checkMitra = "SELECT * FROM `friends` WHERE (`sender_id`='$chatUserId' AND `acceptor_id`='$uid') OR (`sender_id`='$uid' AND `acceptor_id`='$chatUserId')";
                    $checkMitra = mysqli_query($connection, $checkMitra);
                    $checkMitra = mysqli_fetch_all($checkMitra);
           
                    if($checkMitra){

                            $getHistory = "SELECT * FROM `chat_history` WHERE `user_1`='$uid' AND `user_2`='$chatUserId' OR `user_1`='$chatUserId' AND `user_2`='$uid'";
                            $getHistory = mysqli_query($connection, $getHistory);
                            $getHistory = mysqli_fetch_assoc($getHistory);
                            if($getHistory)
                            {
                                if($getHistory['sender_id']!=$uid)
                                {
                                    $history = "UPDATE `chat_history` SET `seen_status`=1 WHERE `user_1`='$uid' AND `user_2`='$chatUserId' OR `user_1`='$chatUserId' AND `user_2`='$uid'";
                                    mysqli_query($connection, $history);
                                }
                            }
                            

                            
                        
                       

                ?>
                    <div class="message-head">
                        <div class="chat-user-profile" id="chat-user-<?php echo $chatUserId; ?>">
                            <a class="redirect-to-profile" href="user.php?id=<?php echo $chatUserId ?>">
                                <img class="mitra-request-profile-list" src="<?php echo $getChatUserData['profile_picture']; ?>">
                                <div style="display:flex;flex-direction:column; margin-left:6px; justify-content:flex-start;">
                                    <span id="chat-profile-uname" class="uname">
                                        <?php echo $getChatUserData['uname']; ?>
                                    </span>
                                    <span id="online-status" class="online-status"> 
                                </div>
                                
                            </a>
                        </div>
                    </div>
                    <div id="main-container" class="message-conversation">

                    </div>
                    <div class="message-field">
                        <textarea name="" id="message-text"></textarea>
                        <i id="sendBtn" class="fa fa-paper-plane" aria-hidden="true"></i>
                    </div>
                    <?php
                    }else{
                        ?>
                         <div class="post-item">
                            User not found
                         </div>
                        <?php
                    }
                    ?>
        </div>
        <?php include_once("./parts/rightSidebar.php") ?>
    </div>
</body>
<script src="./assets/scripts/jquery.js"></script>
<?php include_once("./parts/kurakani/kurakani-scripts.php"); ?>


<script>


    
    // ALEN : Check online status

    $.ajax({
        url: "./server/api/other/checkUserOnlineStatus.php",
        type: "POST",
        data: {
            userId: <?php echo $chatUserId; ?>
        },
        success: (status)=>{
            const onlineStatus = JSON.parse(status);
            if(onlineStatus.isActive)
            {
                $("#online-status")[0].innerHTML = `
                <span class="online-status-icon isactive" > </span>
                                        Active
                                    </span>
                `;

            }else{
                $("#online-status")[0].innerHTML = `
                <span class="online-status-icon inactive" > </span>
                                        Inactive
                                    </span>
                `;
            }
        }
    })

 


    function scrollToBottom() {
        mainChatContainer.scrollTop = mainChatContainer.scrollHeight;
    }

    // ALEN : Delete message
    function deleteMsg(id) {
        let clickedBtn = document.getElementById("chat-" + id);
        $.ajax({
            url: "./server/api/kurakani/deleteKurakani.php",
            data: {
                message_id: id,
                receiver_id: <?php echo $chatUserId; ?>,
            },
            type: "POST",
            success: function(response) {
                // console.log(response);
            }
        })
        clickedBtn.remove();
    }

    let receipientUserId = '<?php echo $chatUserId; ?>';
   
   

    let userChatList = document.getElementById("mitra-request-list-item");

    let mainChatContainer = document.getElementById("main-container");

    let messageBox = document.getElementById("message-text");
    let sendBtn = document.getElementById("sendBtn");


    // ALEN : Refresh chat 
    function refreshMessages() {
        getKurakaniUsers();
        $.ajax({
            url: "./server/api/kurakani/getMessage.php",
            type: "POST",
            data: {
                receipientId: receipientUserId
            },
            success: function(response) {
                let chatData = JSON.parse(response);
                mainChatContainer.innerHTML = ""; 
                chatData.forEach((chat) => {
                    let newChat = "";
                    if (receipientUserId == chat.sender_id && localStorage.getItem("mp-uid") == chat.receiver_id) {

                        newChat = `
                                <div class="message-container m-out">
                                    <div id="${chat.message_id}" class="message-in">
                                        <span>${chat.message_text}</span>
                                    </div>
                                    
                                </div>
                                
                                `;
                    } else if (receipientUserId == chat.receiver_id && localStorage.getItem("mp-uid") == chat.sender_id) {
                        newChat = `
                                <div class="message-container m-in" id="chat-${chat.message_id}">
                                <div class="deleteMsg" onclick="deleteMsg(${chat.message_id})" ><i class="fa-solid fa-trash-can"></i></div>
                                    <div class="message-out">
                                        <span>${chat.message_text}</span>
                                        ${(chat.seen_status==1)?'<i class="bx bx-check-double"></i>':''}
                                        

                                    </div>
                                   
                                </div>
                                
                                `;
                    }
                    mainChatContainer.innerHTML += newChat;
                });
            }
        });
        scrollToBottom();
        seenMessage();
        // getKurakaniUsers();
    }

// ALEN : get messages
    function getMessages() {
        $.ajax({
            url: "./server/api/kurakani/getMessage.php",
            type: "POST",
            data: {
                receipientId: receipientUserId
            },
            success: function(response) {
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

    // ALEN : Update seen status of message
    function seenMessage()
    {
        $.ajax({
            url: "./server/api/kurakani/updateSeenStatus.php",
            type: "POST",
            data: {
                senderId: receipientUserId
            },
            success: (success)=>{
                // console.log(success);
            },
            error: (error)=>{
                // console.log(error);
            }
        })
        scrollToBottom();
    }

    // ALEN : Send Message 
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
                data: {
                    receipientId: receipientUserId,
                    msg: message
                },
                success: function(status) {
                    // console.log(status);

                    refreshMessages();
                }
            });

            // ALEN : Update chat history after sending msg
            $.ajax({
                url: "./server/api/kurakani/updateChatHistory.php",
                type: "POST",
                data: {
                    receipientId: receipientUserId,
                    msg: message
                },
                success: function(status) {
                    // console.log(status);
                },
                error: function(error) {
                    // console.log(error);
                }
            });
        }
        
    }

    $(document).ready(() => {
        refreshMessages();
        scrollToBottom();
        seenMessage();
    })
    
    scrollToBottom();
    setInterval(refreshMessages, 5000);

    // Attach event listener to send button
    sendBtn.addEventListener("click", sendMessage);
    
</script>

    <?php include_once("./parts/js-script-files/js-script.php"); ?>
<?php include_once("./parts/js-script-files/strict-and-activity-update.php"); ?>


</html>