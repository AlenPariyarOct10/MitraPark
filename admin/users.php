<?php

include_once("../server/db_connection.php");

$getUsersCount = "SELECT count(`uid`) as count FROM `users` WHERE 1";
$getUsersCount = mysqli_query($connection, $getUsersCount);
$getUsersCount = mysqli_fetch_assoc($getUsersCount);

$getPostsCount = "SELECT count(`post_id`) as count FROM `posts` WHERE 1";
$getPostsCount = mysqli_query($connection, $getPostsCount);
$getPostsCount = mysqli_fetch_assoc($getPostsCount);

$aboutSite = $connection->query("SELECT * FROM `system_data`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);


?>



<?php
if (isset($_GET['delete'])) {
    $id = htmlspecialchars($_GET['delete']);
    $query = "
         DELETE FROM `strict_mode` WHERE `uid` = '$id';
         DELETE FROM `friend_requests` WHERE `sender_id` = '$id' OR `receiver_id` = '$id';
         DELETE FROM `friends` WHERE `sender_id` = '$id' OR `acceptor_id` = '$id';
         DELETE FROM `likes` WHERE `liked_by` = '$id';
         DELETE FROM `messages` WHERE `sender_id` = '$id' OR `receiver_id` = '$id';
         DELETE FROM `chat_history` WHERE `chat_history_of` = '$id' OR `chat_with` = '$id';
         DELETE FROM `comments` WHERE `comment_by` = '$id';
         DELETE FROM `posts` WHERE `author_id` = '$id';
         DELETE FROM `users` WHERE uid = '$id';
         ";

    $result = mysqli_query($connection, $query);
    echo "Deleted a user.";
}

?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Users -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar">

        <ul class="nav-links">
            <li>
                <a href="index.php">
                    <i class="fa-solid fa-gauge"></i>
                    <span class="links_name">
                        <?php echo $aboutSite['system_name']; ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="users.php" class="<?php echo "active"; ?>">
                    <i class="fa-solid fa-user"></i>
                    <span class="links_name">Users</span>
                </a>
            </li>
            <li>
                <a href="posts.php">
                    <i class="fa-regular fa-newspaper"></i>
                    <span class="links_name">Posts</span>
                </a>
            </li>
            <li>
                <a href="system-info.php">
                    <i class="fa-solid fa-desktop"></i>
                    <span class="links_name">System</span>
                </a>
            </li>

        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Users - MitraPark</span>
            </div>

            <form class="search-box" action="users.php" method="get">
                <input type="text" name="name" placeholder="Search user...">

                <button type="submit"><i class='fa-solid fa-magnifying-glass bx bx-search'></i></button>

            </form>

        </nav>

        <div class="home-content">
            <div class="overview-boxes">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Users</div>
                        <div class="number">
                            <?php echo $getUsersCount['count']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_GET['name'])) {
            $name = htmlspecialchars($_GET['name']);
            $query = "SELECT concat(`fname`,' ',`lname`) as `name`, `uid`, `profile_picture` FROM users WHERE concat(`fname`,' ',`lname`) LIKE '%$name%' OR `uid`='$name'";

            $result = mysqli_query($connection, $query);

            if (mysqli_affected_rows($connection) > 0) {
                echo '<div class="home-content">';

                while ($row = mysqli_fetch_assoc($result)) {

        ?><a style="color: black; text-decoration:none" class="overview-boxes">
                        <div class="box">

                            <div class="right-side">
                                <div class="box-topic">
                                    <?php echo $row['uid']; ?>
                                </div>
                                <div class="number">
                                    <?php echo $row['name']; ?>
                                </div>
                            </div>
                            <div class="left-side">
                                <div class="box-topic">
                                    <img style="border-radius: 20px; margin:5px;" height="80px" src="<?php echo "../" . $row['profile_picture']; ?>" alt="" srcset="">
                                </div>
                            </div>

                            <div class="indicator">
                                <i class='bx bx-up-arrow-alt'></i>
                                <form action="users.php" method="get">
                                    <input type="hidden" name="delete" value="<?php echo $row['uid']; ?>">
                                    <input type="submit" value="Delete">
                                </form>
                            </div>
                        </div>


                    </a>
                <?php
                }
            } else {
                ?>
                <div class="home-content">
                    <a style="color: black; text-decoration:none" class="overview-boxes">
                        <div class="box">
                            <div class="right-side">
                                <div class="number">
                                    No user found
                                </div>
                            </div>

                        </div>
                    </a>
                </div>;
        <?php
            }
        }
        ?>

    </section>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function() {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>

</body>

</html>