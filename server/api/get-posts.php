<?php
    include_once("../../server/db_connection.php");

    $query = "
    SELECT 
        posts.post_id, posts.author_id, posts.content, posts.visibility, posts.created_date_time, posts.media, 
        users.uid, users.fname, users.lname, users.profile_picture, likes.liked_by as liked, COUNT(likes.like_id) AS like_count
    FROM 
        posts
    INNER JOIN 
        users ON posts.author_id = users.uid
    LEFT JOIN 
        likes ON posts.post_id = likes.post_id
    GROUP BY
        posts.post_id
    ORDER BY 
        posts.created_date_time DESC
    ";
    
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Fetching all rows as associative array
        $allPosts = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        // Free result set
        mysqli_free_result($result);
        
        // Output as JSON
        echo json_encode($allPosts);
    } else {
        // Handle query execution error
        echo "Error: " . mysqli_error($connection);
    }

    // Close database connection
    mysqli_close($connection);
?>
