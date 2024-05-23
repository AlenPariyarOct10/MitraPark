<?php
include_once("../server/db_connection.php");
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
      width: 200px;

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
      display: flex;
      flex-direction: column;
      justify-content: space-around;
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
      justify-content: space-around;
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
      color: #ffffffd5;
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
      background-color: white;
      display: flex;
      
      margin: 3px;
      margin-top: 10px;
      
      border-radius: 10px;
      flex-direction: column;
      width: 250px;
      box-shadow: 0.5px 0.5px 5px 0.5px rgba(78, 78, 78, 0.38);
    }

    .post-header {
      display: flex;
      font-size: medium;
      align-items: center;
      justify-content: space-around;
      padding: 2px;
    }

    #profile-img {
      height: 40px;
      

    }

    

    .post-footer {
      display: flex;
      justify-content: space-around;
    }

    #media {
      width: 100%;
      border-radius: 10px;
    }

    #content{
      text-align: center;
      font-size: x-large;
    }

    
    #likes,
    #comments {
      font-size: medium;
    }

    .flex-row {
      display: flex;
      flex-direction: row;
      justify-content: space-around;
    }

    .graph-container {
      margin-top: 20px;
      width: 65%;
      background-color: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0px 0px 20px 1px rgb(206, 206, 206);
    }
    .card-stats-count
    {
      font-size: xxx-large;
      font-weight: bolder;
    }

   /* MitraPark : Stats card  */
    .card-style-red {
    background: -webkit-gradient(linear, left top, right top, from(#fe5d70), to(#fe909d));
    background: linear-gradient(to right, #fe5d70, #fe909d);
    color: white;
    }
    .card-style-yellow {
    background: -webkit-gradient(linear, left top, right top, from(#f5c800), to(#ffea75));
    background: linear-gradient(to right, #f5c800, #ffea75);
    color: white;
    }
    .card-style-blue {
    background: -webkit-gradient(linear, left top, right top, from(#0056f5), to(#aac0ff));
    background: linear-gradient(to right, #0056f5, #aac0ff);
    color: white;
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
            <div class="card card-style-red">
              <div class="card-row ">
                <p class="lite-dim">TOTAL USERS</p>
                <p id="new_users" class="lite-dim">+0</p>
              </div>
              <div class="card-row">
                <p class="card-stats-count" id="total_users">5K</p>
                <span class="icon-cover bg-red">
                  <i><i class="bx bxs-user">
                      <div></div>
                    </i></i>
                </span>
              </div>
            </div>
            <div class="card card-style-yellow">
              <div class="card-row">
                <p class="lite-dim">TOTAL POSTS</p>
                <p id="new_posts" class="lite-dim">+0</p>
              </div>
              <div class="card-row">
                <p class="card-stats-count" id="total_posts"></p>
                <span class="icon-cover bg-yellow">
                  <i><i class="bx bx-grid-alt">
                      <div></div>
                    </i></i>
                </span>
              </div>
           
            </div>
            <div class="card card-style-blue">
              <div class="card-row">
                <p class="lite-dim">RESTRICTED USERS</p>
              </div>
              <div class="card-row">
                <p class="card-stats-count" id="restricted_users"></p>
                <span class="icon-cover bg-blue">
                  <i><i class="bx bx-user-x">
                      <div></div>
                    </i></i>
                </span>
              </div>
              
            </div>
          </div>
          <div class="flex-row">

            <div style="display: flex; justify-content: space-between;" class="popular-post">
              <!-- <p class="card-style-yellow" style="font-size: small; background-color: #c6c6c6;padding: 10px;border-radius: 5px;">Most Liked Post</p> -->
              <div style="height: 100%;display: flex; flex-direction: column; justify-content: space-between;">
              <div class="post-body">
                <img style="border-radius: 8px 8px 0px 0px;" src="" alt="" id="media"/>
                <p id="content"></p>
              </div>
              <div class="post-footer">
                <p id="likes"></p>
                <p id="comments"></p>
              </div>
              <div class="post-header">
                <div>
                  <img style="border-radius: 50%;" src="" alt="" id="profile-img">
                </div>
                <div>
                  <p id="uname"></p>
                  <div>
                    <p id="visibility"></p>
                    <p id="created_date_time"></p>
                  </div>
                </div>
              </div>
            </div>
              <div class="card-style-yellow">
                <p style="font-size: x-large;">Popular Post</p>
              </div>
            </div>
            <div class="graph-container">
              <canvas id="myChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
<script src="../assets/scripts/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('myChart');
  let getStats = new XMLHttpRequest();

  getStats.onreadystatechange = ()=>{
    if(getStats.readyState == 4 && getStats.status == 200)
    {
      let response = JSON.parse(getStats.responseText);
      console.log(response);


      new Chart(ctx, {
    type: 'bar',
    data: {
      labels: response.map((item)=>(
        (item[0])
      )),
      datasets: [{
        label: ['User Statistics'],
        data: response.map((item)=>(
        (parseInt(item[1]))
      )),
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)',
          
        ],
        borderColor: [
          'rgb(255, 159, 64)',
          'rgb(255, 99, 132)',
          'rgb(255, 205, 86)',
          'rgb(75, 192, 192)',
          'rgb(54, 162, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  });
    }
  }

  getStats.open("GET", "./api/getUserStats.php", true);
  getStats.send();

  
</script>
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
      $("#uname")[0].innerText = responseObj.popular_post.uname;
      $("#total_posts")[0].innerText = responseObj.total_posts;
      $("#restricted_users")[0].innerText = responseObj.restricted_users;
      $("#new_users")[0].innerText = "+" + responseObj.new_users;
      $("#new_posts")[0].innerText = "+" + responseObj.new_posts;
      $("#created_date_time")[0].innerText = timeAgo(responseObj.popular_post.created_date_time);
      $("#media")[0].src = "/MitraPark/" + responseObj.popular_post.media;
      $("#content")[0].innerText =  responseObj.popular_post.content;
      $("#likes")[0].innerText = "Likes : " + responseObj.popular_post.likes;

      $("#profile-img")[0].src = "/MitraPark/" + responseObj.popular_post.profile_picture;

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