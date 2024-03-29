<?php
if(session_status()!=PHP_SESSION_ACTIVE)
{
  session_start();
}
 if($_SESSION['loggedInAdmin']!=true)
{

    session_destroy();
    header("Location: ../login.php");


}

echo $_SESSION['loggedInAdmin'];
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

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Dashboard - <?php echo $aboutSite['system_name']; ?> </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.css">

     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">

      <ul class="nav-links">
        <li>
          <a href="index.php" class="<?php echo "active"; ?>">
          <i class="fa-solid fa-gauge"></i>
            <span class="links_name"> <?php echo $aboutSite['system_name']; ?></span>
          </a>
        </li>
        <li>
          <a href="users.php">
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
          <a href="logout.php">
          <i class="fa-solid fa-desktop"></i>
            <span class="links_name">Logout</span>
          </a>
        </li>


      </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard - MitraPark</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div>
    </nav>

    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Users</div>
            <div class="number"><?php echo $getUsersCount['count']; ?></div>

          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Posts</div>
            <div class="number"><?php echo $getPostsCount['count']; ?></div>
            
          </div>
    
        </div>

      </div>

  
    </div>
  </section>

  <script>
   let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
 </script>

</body>
</html>