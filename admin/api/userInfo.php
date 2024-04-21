<?php
    include_once("../../server/db_connection.php");

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $result = array();
        // Get total users
        $usersCount = "SELECT COUNT(uid) as total_users FROM `users` WHERE 1";
        $usersCount = mysqli_query($connection, $usersCount);
        $usersCount = mysqli_fetch_assoc($usersCount);
        $result['total_users'] = $usersCount['total_users'];

        // Get new users
        $newUsersCount = "SELECT COUNT(uid) as new_users FROM `users` WHERE createdDateTime=NOW()";
        $newUsersCount = mysqli_query($connection, $newUsersCount);
        $newUsersCount = mysqli_fetch_assoc($newUsersCount);
        $result['new_users'] = $newUsersCount['new_users'];
        
        // total posts
        $postsCount = "SELECT COUNT(post_id) as total_posts FROM `posts` WHERE 1";
        $postsCount = mysqli_query($connection, $postsCount);
        $postsCount = mysqli_fetch_assoc($postsCount);
        $result['total_posts'] = $postsCount['total_posts'];

        // total reported posts
        $postsCount = "SELECT COUNT(`report_id`) as `total_reported_posts` FROM `reports` WHERE `report_response` IS NULL AND `type`='post' AND `component_id` IN (SELECT `post_id` FROM `posts` WHERE `status` = 'active') ";
        $postsCount = mysqli_query($connection, $postsCount);
        $postsCount = mysqli_fetch_assoc($postsCount);
        $result['total_reported_posts'] = $postsCount['total_reported_posts'];
        
        // total restricted posts
        $postsCount = "SELECT COUNT(`post_id`) as `total_restricted_posts` FROM `posts` WHERE `status`='restricted'";
        $postsCount = mysqli_query($connection, $postsCount);
        $postsCount = mysqli_fetch_assoc($postsCount);
        $result['total_restricted_posts'] = $postsCount['total_restricted_posts'];

        // Get new posts
        $newPostsCount = "SELECT COUNT(post_id) as new_posts FROM `posts` WHERE created_date_time=NOW()";
        $newPostsCount = mysqli_query($connection, $newPostsCount);
        $newPostsCount = mysqli_fetch_assoc($newPostsCount);
        $result['new_posts'] = $newPostsCount['new_posts'];

        // restricted users
        $restrictedUsersCount = "SELECT COUNT(uid) as restricted_users FROM `users` WHERE status='restricted'";
        $restrictedUsersCount = mysqli_query($connection, $restrictedUsersCount);
        $restrictedUsersCount = mysqli_fetch_assoc($restrictedUsersCount);
        $result['restricted_users'] = $restrictedUsersCount['restricted_users'];

        // reported users
        $reportedUsersCount = "SELECT COUNT(DISTINCT r.component_id) as reported_users FROM reports r INNER JOIN users u ON r.component_id = u.uid WHERE r.type='user' AND u.status='active'";

        $reportedUsersCount = mysqli_query($connection, $reportedUsersCount);
        $reportedUsersCount = mysqli_fetch_assoc($reportedUsersCount);
        $result['reported_users'] = $reportedUsersCount['reported_users'];
        

        // Most liked post
        $popularPostId = "SELECT post_id, COUNT(post_id) AS likes_count FROM `likes` GROUP BY post_id ORDER BY likes_count DESC LIMIT 1";
        $popularPostId = mysqli_query($connection, $popularPostId);
        $popularPostId = mysqli_fetch_assoc($popularPostId);
        // var_dump($popularPostId);
        $postId = $popularPostId['post_id'];

        $popularPost = "SELECT concat(u.fname,' ', u.lname) as uname, p.visibility, p.media, p.created_date_time, p.content, p.author_id, p.post_id, u.profile_picture, count(c.post_id) as comments, count(l.post_id) as likes FROM posts p INNER JOIN users u ON p.author_id = u.uid INNER JOIN likes l ON l.post_id=p.post_id INNER JOIN comments c ON c.post_id=p.post_id WHERE p.post_id= '$postId'";

        $popularPost = mysqli_query($connection, $popularPost);
        $popularPost = mysqli_fetch_assoc($popularPost);
        $result['popular_post'] = $popularPost;

        echo json_encode($result);
    }

?>