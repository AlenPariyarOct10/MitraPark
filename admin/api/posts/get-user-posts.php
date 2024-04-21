<?php
    include_once("../../../server/db_connection.php");
    if(session_status()!=PHP_SESSION_ACTIVE){
        session_start();
    }

    if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['uid']))
    {
        $authorId = htmlspecialchars($_POST['uid']);
        $query = "
            SELECT 
                posts.post_id, posts.author_id, posts.content, posts.visibility, posts.created_date_time, posts.media, 
                users.uid, users.fname, users.lname, users.profile_picture,  COUNT(likes.like_id) AS like_count, COUNT(comments.comment_id) AS comments_count
            FROM 
                posts
            INNER JOIN 
                users ON posts.author_id = users.uid
            LEFT JOIN 
                likes ON posts.post_id = likes.post_id
            LEFT JOIN
                comments ON posts.post_id = comments.post_id
            WHERE 
                posts.author_id = '$authorId'
            GROUP BY
                posts.post_id
            ORDER BY 
                posts.created_date_time DESC
        ";
        
        $result = mysqli_query($connection, $query);
    
        if ($result) {
    
            $allPosts = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
            echo json_encode($allPosts);
        }
        mysqli_close($connection);
    }

   
?>
