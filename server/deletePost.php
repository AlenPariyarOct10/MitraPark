<?php

include_once("../server/db_connection.php");


if (isset($_POST['postId']) && isset($_POST['authorId'])) {
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }

$uid = $_SESSION['user']['uid'];
$postId = $_POST['postId'];
    if ($_POST['authorId'] == $uid) {

        $mediaName = mysqli_query($connection, "SELECT `media` FROM `posts` WHERE post_id='$postId'");
        $hasMedia = false;

        if(mysqli_affected_rows($connection)>0)
        {
            $hasMedia=true;
            $mediaPath = mysqli_fetch_assoc($mediaName);
            $mediaPath = $mediaPath['media'];
        }
        
        $uid = $_SESSION['user']['uid'];
        $deletePosts = "DELETE from posts WHERE post_id = '$postId' AND author_id='$uid'";
        $deleteLikes = "DELETE from likes WHERE post_id = '$postId'";
        $deleteComments = "DELETE from comments WHERE post_id = '$postId'";
        $deleteNotifications = "DELETE from notifications where type='like' AND component_id = '$postId'";
        $resultPosts = mysqli_query($connection, $deletePosts);
        $resultLikes = mysqli_query($connection, $deleteLikes);
        $resultComment = mysqli_query($connection, $deleteComments);
        $resultNotification = mysqli_query($connection, $deleteNotifications);

        if($hasMedia)
        {
            try{
                $fullMediaPath = ".." . $mediaPath;
                echo $fullMediaPath;
                if(file_exists($fullMediaPath))
                {
                    echo "has image";
                    if(unlink($fullMediaPath))
                    {
                        echo "Deleted";

                    }else{
                        echo "unable to delete";
                    }

                }
            }catch(Exception $ex)
            {
               
            }

        }
        header("Location: ../feed.php");
    } else {
        header("Location: ../feed.php");
    }
} else {
    header("Location: ../feed.php");
}
