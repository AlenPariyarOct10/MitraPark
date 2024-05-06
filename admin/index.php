<?php
include_once("../server/db_connection.php");
include_once("./parts/entryCheck.php");

$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard ~ <?php echo $aboutSite['system_name']; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Khand:wght@300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/boxicons/css/boxicons.css">
  <style>
    body {
      margin: 0px;
      padding: 0px;
      background-color: #F3F3F9;
      display: flex;
      flex-direction: column;
      font-family: 'Hanken Grotesk';
      font-size: 28px;
      font-weight: normal;
    }

    .body {
      display: flex;
      background-color: #f2f2f2;
      height: 100%;

    }


    /* ALEN: SIDEBAR */
    .sidebar {
      background-color: #3d4d82;
      ;
      transition: width 0.9s ease;
      color: rgb(243, 243, 243);
      font-size: medium;
      line-height: 30px;

    }

    .sidebar-mobile {
      width: 60px;
    }

    .sidebar-desktop {
      width: 180px;

    }

    .sidebar ul>*:hover {
      background-color: #535C91;
    }





    .sidebar ul>li {

      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .active-tab {
      background-color: #FF204E;
      font-weight: bold;
    }

    .sidebar ul {
      padding: 0;
      margin: 0;
      width: 100%;
    }

    a {
      width: 100%;
      color: whitesmoke;
      text-decoration: none;
    }

    .sidebar ul>li {
      padding-left: 20px;
      /* background-color: red; */
    }

    .inner-body {
      height: 100%;
    }

    .inner-body-section {
      height: inherit;
    }

    /* ---------------------------------------- */
    .content {
      padding: 30px;
      width: 100%;
    }

    p {
      margin: 0;
      padding: 0;
    }

    .content {
      display: flex;
      flex-direction: column;
    }



    /* Card Style */
    .card {
      display: flex;
      flex-direction: column;
      background-color: white;
      padding: 20px;
      border-radius: 4px;
      box-shadow: 0px 0px 20px 1px #9f9f9f66;
      width: 20%;
      height: 100px;

    }

    .card:hover {

      box-shadow: 0px 0px 20px 1px #9f9f9fad;

    }

    .card-row {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
    }

    .lite-dim {
      font-weight: 500;
      font-size: small;
      color: #535C91;
    }

    .underline {
      text-decoration: underline;
    }

    .bg-green {
      background-color: #6effc5;
      color: #00b96f;
    }

    .bg-red {
      background-color: #ff6e6e;
      color: #b90000;
    }

    .bg-yellow {
      background-color: #ffee6e;
      color: #b9b300;
    }

    .bg-blue {
      background-color: #6e8bff;
      color: #002eb9;
    }

    .icon-cover {
      padding: 5px 8px 5px 8px;
      border-radius: 10px;
    }

    .card-grid {
      width: 100%;
      display: flex;
      justify-content: space-between;
    }

    /* -------------------------- Popular Post Card ------------------------------------- */
    .popular-post {
      margin-top: 10px;
      background-color: white;
      display: flex;
      padding: 10px;
      border-radius: 5px;
      flex-direction: column;
      width: 250px;
      box-shadow: 0.5px 0.5px 5px 0.5px rgba(78, 78, 78, 0.38);
    }

    .post-header {
      display: flex;
      font-size: medium;
      align-items: center;
      justify-content: space-around;
    }

    #profile-img {
      height: 40px;
      border-radius: 50%;

    }

    .post-body {
      padding: 5px;
    }

    .post-footer {
      display: flex;
      justify-content: space-around;
    }

    #media {
      width: 100%;
      border-radius: 10px;
    }

    #content,
    #likes,
    #comments {
      font-size: medium;
    }

    .flex-row {
      display: flex;
      flex-direction: row;
      justify-content: space;
    }

    .graph-container {
      width: 70%;
    }
  </style>
</head>

<body>

  <div class="body">
    <?php include_once("./parts/sidebar.php") ?>
    <!-- /opt/lampp/htdocs/MitraPark/parts/testSidebar.php -->
    <div class="content">
      <div class="inner-header">
        <p>Dashboard ~ <?php echo $aboutSite['system_name']; ?> </p>
      </div>
      <div class="inner-body">
        <div class="inner-body-section">
          <!-- ALEN : CARD -->
          <div class="card-grid">
            <div class="card">
              <div class="card-row">
                <p class="lite-dim">TOTAL USERS</p>
                <p id="new_users" class="lite-dim">+0</p>
              </div>
              <div class="card-row">
                <p id="total_users">5K</p>
              </div>
              <div class="card-row">
                <span class="icon-cover bg-red">
                  <i><i class="bx bxs-user">
                      <div></div>
                    </i></i>
                </span>
              </div>
            </div>
            <div class="card">
              <div class="card-row">
                <p class="lite-dim">TOTAL POSTS</p>
                <p id="new_posts" class="lite-dim">+0</p>
              </div>
              <div class="card-row">
                <p id="total_posts"></p>
              </div>
              <div class="card-row">
                <span class="icon-cover bg-yellow">
                  <i><i class="bx bxs-user">
                      <div></div>
                    </i></i>
                </span>
              </div>
            </div>
            <div class="card">
              <div class="card-row">
                <p class="lite-dim">RESTRICTED USERS</p>
              </div>
              <div class="card-row">
                <p id="restricted_users"></p>
              </div>
              <div class="card-row">
                <span class="icon-cover bg-blue">
                  <i><i class="bx bxs-user">
                      <div></div>
                    </i></i>
                </span>
              </div>
            </div>
          </div>
       



        </div>
      </div>
    </div>
  </div>

</body>
<script src="../assets/scripts/jquery.js"></script>

<script>
  function timeAgo(postedTime) {
    const postedDate = new Date(postedTime);
    const currentDate = new Date();
    const timeDifference = currentDate - postedDate;

    const seconds = Math.floor(timeDifference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor(days / 30);
    const years = Math.floor(days / 365);

    if (years > 0) {
      return `${years} year${years > 1 ? 's' : ''} ago`;
    } else if (months > 0) {
      return `${months} month${months > 1 ? 's' : ''} ago`;
    } else if (days > 0) {
      return `${days} day${days > 1 ? 's' : ''} ago`;
    } else if (hours > 0) {
      return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    } else if (minutes > 0) {
      return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    } else {
      return 'just now';
    }
  }
  // Get dashboard data
  $.ajax({
    url: "./api/userInfo.php",
    type: "POST",
    success: async (response) => {
      const responseObj = await JSON.parse(response);
      $("#total_users")[0].innerText = responseObj.total_users;
      
      $("#total_posts")[0].innerText = responseObj.total_posts;
      $("#restricted_users")[0].innerText = responseObj.restricted_users;
      $("#new_users")[0].innerText = "+" + responseObj.new_users;
      $("#new_posts")[0].innerText = "+" + responseObj.new_posts;


    }
  })

  $('body').css({
    'height': $(this).height()
  });
  if ($(window).width() > 576) {
    if ($(".sidebar").hasClass("sidebar-mobile")) {
      $(".sidebar").removeClass("sidebar-mobile");
      $(".sidebar").addClass("sidebar-desktop");
      $(".sidebar-links").show();
      $(".card-grid").css({
        'height': '100%',
        'flex-direction': 'row',
        'justify-content': 'space-around'
      });
      $(".card").css({
        "width": "20%"
      })
    }
  } else if ($(window).width() < 576) {
    if ($(".sidebar").hasClass("sidebar-desktop")) {
      $(".sidebar").removeClass("sidebar-desktop");
      $(".sidebar").addClass("sidebar-mobile");
      $(".sidebar-links").hide();
      $(".card-grid").css({
        'height': '100%',
        'flex-direction': 'column',
        'justify-content': 'space-around'
      });
      $(".card").css({
        "width": "90%"
      })
    }
  }

  $(window).resize(() => {
    if ($(window).width() > 576) {
      if ($(".sidebar").hasClass("sidebar-mobile")) {
        $(".sidebar").removeClass("sidebar-mobile");
        $(".sidebar").addClass("sidebar-desktop");
        $(".sidebar-links").show();
        $(".card-grid").css({
          'height': '100%',
          'flex-direction': 'row',
          'justify-content': 'space-around'
        });
        $(".card").css({
          "width": "20%"
        })
      }
    } else if ($(window).width() < 576) {
      if ($(".sidebar").hasClass("sidebar-desktop")) {
        $(".sidebar").removeClass("sidebar-desktop");
        $(".sidebar").addClass("sidebar-mobile");
        $(".sidebar-links").hide();
        $(".card-grid").css({
          'height': '100%',
          'flex-direction': 'column',
          'justify-content': 'space-around'
        });
        $(".card").css({
          "width": "90%"
        })
      }
    }
  })
</script>

</html>