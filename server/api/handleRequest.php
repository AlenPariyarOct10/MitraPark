<?php

include_once('../../parts/entryCheck.php');
include_once('../../server/db_connection.php');
include_once('../../server/validation.php');
include_once('../../server/functions.php');

(session_status() !== PHP_SESSION_ACTIVE) ? session_start() : "";
$uid = $_SESSION['user']['uid'];
$receiverId = htmlspecialchars($_POST['messageTo']);
$requestMode = htmlspecialchars($_POST['mode']);



// Check in Request List
$selectFriendRequest = "SELECT * FROM `friend_requests` WHERE sender_id='$uid' AND `receiver_id`='$receiverId'";
$requestList = mysqli_query($connection, $selectFriendRequest);
$requestList = mysqli_fetch_array($requestList, MYSQLI_ASSOC);
if ($requestMode === "sendRequest") {

    $dateTime = Date("Y-m-d H-i-s");

    if ($requestList === null) {
        $insertRequest = "INSERT INTO `friend_requests`(`sender_id`, `receiver_id`, `status`, `created_date_time`) VALUES ('$uid','$receiverId','pending','$dateTime')";
        $insertRequestStatus = mysqli_query($connection, $insertRequest);

        addNotification("request_received", $receiverId, $uid);


        echo '
        <div id="mitraRequestHandleBtn" data-mode="cancelRequest" data-uid="' . $receiverId . '" class="mitra-request-control-btn">
            <img src="./assets/images/remove.png" height="30px" alt="" />
            <span>Cancel Request</span>
        </div>';
    }
} else if ($requestMode === "cancelRequest") {
    if ($requestList !== null) {
        $deleteRequest = "DELETE FROM `friend_requests` WHERE `sender_id`='$receiverId' AND `receiver_id`='$uid' OR `receiver_id`='$receiverId' AND `sender_id`='$uid'";
        $deleteRequestStatus = mysqli_query($connection, $deleteRequest);
        echo ' <div id="mitraRequestHandleBtn" data-mode="sendRequest" data-uid="' . $receiverId . '" class="mitra-request-control-btn">
                        <img src="./assets/images/add-mitra.png" height="30px" alt="" />
                        <span>Add Mitra</span>
                     </div>';
        removeNotification("request_received",$receiverId, $uid);
        
    }
} else if ($requestMode === "acceptRequest") {
    // Delete from Friend Requests
    $deleteRequest = "DELETE FROM `friend_requests` WHERE `sender_id`='$uid' AND `receiver_id`='$receiverId' OR `sender_id`='$receiverId' AND `receiver_id`='$uid'";
    $deleteRequestStatus = mysqli_query($connection, $deleteRequest);

    $dateTime = Date("Y-m-d H-i-s");

    // Insert into Friends
    $insertFriend = "INSERT INTO `friends`(`sender_id`, `acceptor_id`, `since_date_time`) VALUES ('$receiverId','$uid','$dateTime')";
    $insertFriendStatus = mysqli_query($connection, $insertFriend);

    echo '
                                <div id="mitraRequestHandleBtn" data-mode="removeMitra" data-uid="' . $uid . '" class="mitra-request-control-btn">
                                    <img src="./assets/images/remove.png" height="30px" alt="" />
                                    <span>Remove Mitra</span>
                                </div>
                               
                                ';
    addNotification("request_accepted", $receiverId, $uid);
                                

}else if($requestMode === "rejectRequest")
{
    // Remove friend request
    $setRejected = "DELETE FROM `friend_requests` WHERE `receiver_id`='$receiverId' AND `sender_id`='$uid'";
    $setRejectedStatus = mysqli_query($connection, $setRejected);
    echo ' <div id="mitraRequestHandleBtn" data-mode="sendRequest" data-uid="' . $receiverId . '" class="mitra-request-control-btn">
                        <img src="./assets/images/add-mitra.png" height="30px" alt="" />
                        <span>Add Mitra</span>
                     </div>';
}else if($requestMode === "removeMitra")
{
    // Remove From friends
    $setRejected = "DELETE FROM `friends` WHERE `sender_id`='$uid' AND `acceptor_id`='$receiverId' OR `sender_id`='$receiverId' AND `acceptor_id`='$uid'";
    $setRejectedStatus = mysqli_query($connection, $setRejected);
    echo ' <div id="mitraRequestHandleBtn" data-mode="sendRequest" data-uid="' . $receiverId . '" class="mitra-request-control-btn">
                        <img src="./assets/images/add-mitra.png" height="30px" alt="" />
                        <span>Add Mitra</span>
                     </div>';
    removeNotification("request_accepted", $receiverId, $uid);

}




// Check if is friend or not
// $query = "SELECT * FROM `friends` WHERE `sender_id`='$senderId' AND `acceptor_id`='$uid'";
// $IsFrientResult = mysqli_query($connection, $query);
// $IsFrientResult = mysqli_fetch_array($IsFrientResult, MYSQLI_ASSOC);

// if ($IsFrientResult !== null) {
//     echo '
//             <div id="mitraRequestHandleBtn" data-mode="removeMitra" data-uid="' . $uid . '" class="mitra-request-control-btn">
//                 <img src="./assets/images/remove.png" height="30px" alt="" />
//                 <span>Mitra"s</span>
//             </div>
//             <a class="mitra-request-control-btn" style="display: flex; justify-content: space-around">
//                 <i style="color: rgb(78, 78, 78)" class="fa-solid fa-message"></i>
//                 <span>Kurakani</span>
//             </a>
//             ';
// } else {
//     if ($requestList === null) {
//         $insertRequest = "INSERT INTO `friend_requests`(`sender_id`, `receiver_id`, `status`, `created_date_time`) VALUES ('$uid','$receiverId','pending',now())";
//         $insertRequestStatus = mysqli_query($connection, $insertRequest);
//         echo '
//         <div id="mitraRequestHandleBtn"  data-uid="' . $receiverId . '" class="mitra-request-control-btn">
//             <img src="./assets/images/remove.png" height="30px" alt="" />
//             <span>Cancel Request</span>
//         </div>';
//     } else {
//         $deleteRequest = "DELETE FROM `friend_requests` WHERE `sender_id`='$uid' AND `receiver_id`='$receiverId'";
//         $deleteRequestStatus = mysqli_query($connection, $deleteRequest);
//         echo ' <div id="mitraRequestHandleBtn" data-uid="' . $receiverId . '" class="mitra-request-control-btn">
//                     <img src="./assets/images/add-mitra.png" height="30px" alt="" />
//                     <span>Add Mitra</span>
//                  </div>';
//     }
// }
