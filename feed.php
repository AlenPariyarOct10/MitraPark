<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite= $aboutSite->fetch_array(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="./assets/css/profile.css">
    <style>
        
        #share-btn{
            border: none; 
            background-color: white;
            cursor: pointer;
        }

        #share-btn:hover{
            background-color: rgba(0, 0, 0, 0.2);
        }

        .comment-inp{
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            border: 1px solid black;
            padding: 2px;
            border-radius: 5px;
        }

        

        .comment-inp button{
            padding: 0px 5px 0px 5px;
            border: none;
            background-color: white;
        }
        .comment-inp input{
            width: 100%;
            border: none;
            outline: none;
        }

        .comment-inp input:focus{
            outline: none;
        }


        .post-comment-inp{
            height: 30px;
            margin: 1px;
            border: 1px solid grey;
        }

        .post-comment{
            height: 30px;    
        }
    </style>
    <?php echo "<script>localStorage.setItem('mp-uid','".$_SESSION['user']['uid']."')</script>";?>

</head>

<body>
    <?php
        include_once("./parts/navbar.php");
        include_once("./parts/leftSidebar.php");

        include_once("./parts/feed-midbody.php");
        ?>
            <!-- Update Form -->
          <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
              <span id="closeModal" class="close">&times;</span>
              <div>
                <span style="text-decoration: underline;">Update Profile  </span><label id="form-submit-failed"></label>
                <form class="form-datas profile-update-form" id="profile-update-form" method="post">
                  <input type="file"  style="display: none" id="profile-img-uploader" />
                  <div class="form-innner-row">
                    <div class="inner-form-element">
                      <label id="fname-label" for="fname">First name <span id="fname-error"></span> </label>
                      <input name="fname" type="text" maxlength="15" id="fname" value="<?php echo $_SESSION['user']["fname"]; ?>" />
                      <label class="length-validate" for="fname"> <span id="fname-count"> 0 </span> / 15</label>
                    </div>
                    <div class="inner-form-element">
                      <label id="lname-label" for="lname">Last name <span id="lname-error"></span></label>
                      <input name="lname" type="text" maxlength="15" id="lname" value="<?php echo $_SESSION['user']["lname"]; ?>" />
                      <label class="length-validate" for="lname"> <span id="lname-count"> 0 </span> / 15</label>
                    </div>
                  </div>

                  <div class="form-innner-row">
                    <div class="inner-form-element">
                      <label id="bio-label" for="bio">Bio <span id="bio-error"></span></label>
                      <input name="bio" type="text" id="bio" maxlength="150" value="<?php echo $_SESSION['user']["bio"]; ?>" />
                      <label class="length-validate" for="bio"> <span id="bio-count"> 0 </span> / 150</label>
                    </div>
                  </div>

                  <div class="form-innner-row">
                    <div class="inner-form-element">
                      <label for="gender">Gender</label>
                      <select name="gender" id="gender">
                        <option value="NULL" <?php echo ($_SESSION['user']['gender']==null)? "selected":'';?> disabled>Select one</option>
                        <option value="male" <?php echo ($_SESSION['user']['gender']=="male")? "selected":'';?>>Male</option>
                        <option value="female" <?php echo ($_SESSION['user']['gender']=="female")? "selected":'';?>>Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-innner-row">
                    <div class="inner-form-element">
                      <label for="bio">Permanent Address</label>
                      <select name="p_address" id="">
                        <?php
                          $result = $GLOBALS['connection']->query("SELECT * FROM `locations`  ORDER BY location_name ASC");
                          ?>
                          <option value="NULL" <?php echo ($_SESSION['user']['p_address_id']==null)?"selected":"";?> disabled>Select One</option>
                          <?php
                          
                          while($row = mysqli_fetch_assoc($result))
                          {
                            echo "<option value=".$row['location_id'].">".$row['location_name']."</option>";
                             $row['location_name'];
                          }

                        ?>

                        
                      </select>
                    </div>
                  </div>
                  <div class="form-innner-row">
                    <div class="inner-form-element">
                      <label for="bio">Temporary Address</label>
                      <select name="t_address" id="">
                      <?php
                          $result = $GLOBALS['connection']->query("SELECT * FROM `locations` ORDER BY location_name ASC");
                          ?>
                          <option value="NULL" <?php echo ($_SESSION['user']['t_address_id']==null)?"selected":"";?> disabled>Select One</option>
                          <?php
                          
                          while($row = mysqli_fetch_assoc($result))
                          {
                            echo "<option value=".$row['location_id'].">".$row['location_name']."</option>";
                          }

                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-innner-row">
                    <div class="inner-form-element">
                      <label for="academic_institution">Academic Institution</label>
                      <select name="academic_institution" id="academic_institution">
                      <?php
                          $result = $GLOBALS['connection']->query("SELECT * FROM `academic_institution`");
                          ?>
                          <option value="NULL" <?php echo ($_SESSION['user']['academic_institution_id']==null)?"selected":"";?> disabled>Select One</option>
                          <?php
                          
                          while($row = mysqli_fetch_assoc($result))
                          {
                            echo "<option value=".$row['inst_id'].">".$row['institution_name']."</option>";
                          }

                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-inner-row">
                    <div class="inner-form-element">
                      <button id="profile-form-submit" type="submit">Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php
        include_once("./parts/rightSidebar.php");
    ?>
    <script>
        let modal =document.getElementById("myModal");
        let closeModal =document.getElementById("closeModal");

        

        
            // modal.style.display = "block";
        

        closeModal.addEventListener("click",()=>{
            modal.style.display = "none";
        })



    </script>
    <script src='./assets/scripts/jquery.js'></script>
    <script src='posts.js'></script>
</body>
</html>