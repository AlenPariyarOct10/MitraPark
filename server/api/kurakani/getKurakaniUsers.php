<?php

    include_once("../../../parts/entryCheck.php");
    include_once("../../db_connection.php");
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];

    $getMitras = "SELECT 
    f.sender_id, 
    f.acceptor_id, 
    u.uid, 
    CONCAT(u.fname, ' ', u.lname) AS uname, 
    u.profile_picture 
FROM 
    `friends` f 
INNER JOIN 
    `users` u 
ON 
    u.uid = f.acceptor_id OR u.uid = f.sender_id 
WHERE 
    (f.acceptor_id = '$uid' OR f.sender_id = '$uid')
";

$getMitras = "
SELECT ch.ch_id, CONCAT(u.fname, ' ', u.lname) AS uname, ch.user_1 as sender_id, ch.user_2 as acceptor_id, ch.last_updated, u.uid, u.profile_picture, ch.last_message, ch.seen_status, ch.sender_id as send_by FROM `chat_history` ch LEFT JOIN `users` u on u.uid = ch.user_1 OR u.uid = ch.user_2 WHERE ch.user_1 = '$uid' OR ch.user_2 = '$uid' AND u.uid <> '$uid' ORDER BY ch.last_updated DESC
";

    $result = mysqli_query($connection, $getMitras);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($result);
  
?>
