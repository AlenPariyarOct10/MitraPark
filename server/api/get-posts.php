<?php
    include_once("../../server/db_connection.php");

    $query = "
    SELECT 
        posts.post_id, posts.author_id, posts.content, posts.visibility, posts.created_date_time, posts.media, 
        users.uid, users.fname, users.lname, users.profile_picture
    FROM 
        posts
    INNER JOIN 
        users ON posts.author_id = users.uid
    ORDER BY 
        posts.created_date_time DESC
    ";
    
    $result = mysqli_query($connection,$query);
    $allPosts = Array();
    
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($allPosts, $row);
    }
    print_r(json_encode($allPosts));
    



?>