<?php

include_once("../../../server/db_connection.php");

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

$uid = $_SESSION['user']['uid'];

$query = "
    SELECT 
        posts.post_id, posts.author_id, posts.content, posts.visibility, posts.created_date_time, posts.media, 
        users.uid, users.fname, users.lname, users.profile_picture, 
        COUNT(likes.like_id) AS like_count,
        CONCAT(TIMESTAMPDIFF(SECOND, posts.created_date_time, NOW()), ' seconds ago') AS time_ago
    FROM 
        posts
    INNER JOIN 
        users ON posts.author_id = users.uid
    LEFT JOIN 
        likes ON posts.post_id = likes.post_id
    WHERE 
        posts.author_id = '$uid'
    GROUP BY
        posts.post_id
    ORDER BY 
        posts.created_date_time DESC";

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
