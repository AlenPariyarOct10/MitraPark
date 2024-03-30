<?php
    include_once("../../../server/db_connection.php");
    if(session_status()!=PHP_SESSION_ACTIVE){
        session_start();
    }
    $uid = $_SESSION['user']['uid'];

    $query = "
    SELECT 
        posts.post_id, posts.author_id, posts.content, posts.visibility, posts.created_date_time, posts.media, 
        users.uid, users.fname, users.lname, users.profile_picture,  COUNT(likes.like_id) AS like_count
    FROM 
        posts
    INNER JOIN 
        users ON posts.author_id = users.uid
    LEFT JOIN 
        likes ON posts.post_id = likes.post_id
    WHERE 
        posts.visibility = 'public'
        OR (posts.visibility = 'private' AND posts.author_id = '$uid')
        OR (posts.visibility = 'mitras' AND posts.author_id IN (
            SELECT acceptor_id FROM friends WHERE sender_id = '$uid'
            UNION
            SELECT sender_id FROM friends WHERE acceptor_id = '$uid'
        ))
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
