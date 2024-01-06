<?php
    include_once("../db_connection.php");
    include_once("../headers.php");
    

    $query = "
    SELECT 
        post.published_date, post.post_text, post.post_likes_count, 
        post.post_comments_count, post.post_visibility, post.published_time, 
        media.media_url, user.user_active_status, 
        user.user_first_name, user.user_mid_name, user.user_last_name
    FROM mp_posts post
    INNER JOIN mp_media media ON post.post_id = media.post_id
    INNER JOIN mp_users user ON post.post_author = user.user_id
";
    $result = mysqli_query($connection,$query);
    $allPosts = Array();
    
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($allPosts, $row);
    }
    print_r(json_encode($allPosts));
    



?>