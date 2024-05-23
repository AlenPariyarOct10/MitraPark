<?php
  $adminMenu = [
    [
      "title"=>"Dashboard",
      "href"=>"index.php",
      "class" => "bx bxs-dashboard",
    ],
    [
      "title"=>"Reported Users",
      "href"=>"reported-users.php",
      "class" => "bx bxs-user",
    ],
    [
      "title"=>"All Users",
      "href"=>"users.php",
      "class" => "bx bxs-user",
    ],
    [
      "title"=>"Reported Posts",
      "href"=>"reported-posts.php",
      "class" => "bx bxs-card",
    ], [
      "title"=>"All Posts",
      "href"=>"posts.php",
      "class" => "bx bxs-card",
    ],
    [
      "title"=>"System",
      "href"=>"system.php",
      "class" => "bx bxs-info-square",
    ],
    [
      "title"=>"Logout",
      "href"=>"logout.php",
      "class" => "bx bx-log-in-circle",
    ],
    
  ]
  

?>
<div class="sidebar sidebar-desktop">
      <span><a href=""><?php echo $aboutSite['system_name']; ?></a></span>
      <ul>
       
          <?php
            foreach ($adminMenu as $item) {
                echo '<li ';
                if (str_contains($_SERVER['REQUEST_URI'], $item['href'])) {
                    echo 'class="active-tab"';
                }
                echo '><i class="' . $item["class"] . '"></i><a class="sidebar-links" href="./' . $item['href'] . '">' . $item['title'] . '</a></li>';
            }
          ?>

      </ul>
    </div>