<?php

include_once("../../../server/db_connection.php");

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

$profileUid = $_POST['profileUid'];
// echo "profile uid : ".$profileUid;
$uid = $_SESSION['user']['uid'];
$authorMitras = "SELECT * FROM `friends` WHERE (`sender_id`='$uid' AND `acceptor_id`='$profileUid') OR (`sender_id`='$profileUid' AND `acceptor_id`='$uid')";
$authorMitras = mysqli_query($connection, $authorMitras);
$authorMitras = mysqli_fetch_assoc($authorMitras);
$isMitra = false;
if ($authorMitras) {
    $isMitra = true;
}


$dateTime = Date("Y-m-d H-i-s");

if(!$isMitra)
{
    $query = "
    SELECT 
        posts.post_id, posts.author_id, posts.content, posts.visibility, posts.created_date_time, posts.media, 
        users.uid, users.fname, users.lname, users.profile_picture, 
        COUNT(likes.like_id) AS like_count,
        CONCAT(TIMESTAMPDIFF(SECOND, posts.created_date_time, '$dateTime'), ' seconds ago') AS time_ago
    FROM 
        posts
    INNER JOIN 
        users ON posts.author_id = users.uid
    LEFT JOIN 
        likes ON posts.post_id = likes.post_id
    WHERE 
        posts.author_id = '$profileUid'
        AND
        posts.visibility = 'public'
        AND
        posts.status = 'active'
    GROUP BY
        posts.post_id
    ORDER BY 
        posts.created_date_time DESC";
}else{
    $query = "
    SELECT 
        posts.post_id, posts.author_id, posts.content, posts.visibility, posts.created_date_time, posts.media, 
        users.uid, users.fname, users.lname, users.profile_picture, 
        COUNT(likes.like_id) AS like_count,
        CONCAT(TIMESTAMPDIFF(SECOND, posts.created_date_time, '$dateTime'), ' seconds ago') AS time_ago
    FROM 
        posts
    INNER JOIN 
        users ON posts.author_id = users.uid
    LEFT JOIN 
        likes ON posts.post_id = likes.post_id
    WHERE 
        posts.author_id = '$profileUid'
        AND
        (posts.visibility = 'public' OR posts.visibility = 'mitras')
        AND
        posts.status = 'active'
    GROUP BY
        posts.post_id
    ORDER BY 
        posts.created_date_time DESC";
}

// echo $query;


$result = mysqli_query($connection, $query);

if ($result) {
    // Initialize an empty array to store all posts
    $allPosts = array();

    // Fetching all rows one by one
    while ($row = mysqli_fetch_assoc($result)) {
        $allPosts[] = $row;
    }

    // Output as JSON
    echo json_encode($allPosts);
} else {
    // Handle query execution error
    echo "Error: " . mysqli_error($connection);
}

// Close database connection
mysqli_close($connection);
?>
