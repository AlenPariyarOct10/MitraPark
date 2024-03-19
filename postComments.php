<?php

include_once ('./parts/entryCheck.php');
include_once ('./server/db_connection.php');
include_once ('./server/validation.php');
include_once ('./server/functions.php');


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='style.css'>
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/fontawesome.css">
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link
        href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap'
        rel='stylesheet'>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <title>Feed -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <style>
        #share-btn {
            border: none;
            background-color: white;
            cursor: pointer;
        }

        #share-btn:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .comment-inp {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
        }

        .comment-inp button {
            padding: 0px 5px 0px 5px;
        }

        .comment-inp input {
            width: 100%;
        }
    </style>
    <?php echo "<script>localStorage.setItem('mp-uid','" . $_SESSION['user']['uid'] . "')</script>"; ?>

</head>

<body>
    <?php
    include_once ("./parts/navbar.php");
    include_once ("./parts/leftSidebar.php");
    ?>

    <?php
    $postId = htmlspecialchars($_GET['postId']);
 // Assuming $postId is the ID of the post you want to retrieve comments for

// Prepare the SQL statement
$getCommentsQuery = "SELECT comments.*, users.uid, users.profile_picture, CONCAT(users.fname, ' ', users.lname) AS uname 
FROM `comments` 
INNER JOIN `users` ON comments.comment_by = users.uid
WHERE `post_id` = ?";

// Prepare and execute the statement
$stmt = $connection->prepare($getCommentsQuery);
$stmt->bind_param("i", $postId); // Assuming $postId is an integer
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch data
$comments = [];
while ($row = $result->fetch_assoc()) {
$comments[] = $row;
}

// Free the result and close the statement
$stmt->close();

// Now $comments contains all comments along with the user information for the specified post

    
    ?>
    <div class="mid-body">
        <div>

                <span>Comments</span>
            <hr>
            
            <?php 
                foreach($comments as $comment)
                {
                    echo '<div style="border: 1px solid black"><a class="right-nav-item" href="user.php?id='.$comment['uid'].'">
                    <img class="right-nav-item-img" src="'.$comment['profile_picture'].'">
                    <span>'.$comment['uname'].'</span>
                  
                </a>  <textarea disabled>
                '.$comment['content'].'
                </textarea></div>';
                }
               
            ?>
            
        </div>
    </div>
    <?php
    include_once ("./parts/rightSidebar.php");
    ?>
    <script src='./assets/scripts/jquery.js'></script>

</body>

</html>