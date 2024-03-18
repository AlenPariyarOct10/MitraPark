<?php

  include_once('./parts/entryCheck.php');
  include_once('./server/db_connection.php');
  include_once('./server/validation.php');
  include_once('./server/functions.php');

  $aboutSite = $connection->query('SELECT * FROM `system_data`');
  $aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
  
  var_dump($_SESSION['user']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="assets/css/mitras-style.css" />
  <link rel="stylesheet" href="./assets/css/all.css" />
  <link rel="stylesheet" href="./assets/css/fontawesome.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/profile.css" />

  <title>Profile - </title>
</head>

<body>
  <?php
    include_once("./parts/navbar.php");
    include_once("./parts/leftSidebar.php");
  ?>
    <div class="mid-body">
      <div class="left-inner-body inner-mid-body">
        <label for="profileUpload">
          <div id="profile-img-holder" class="image-holder">
            <img src=".<?php echo "./MitraPark".$_SESSION['user']['profile_picture']; ?>" id="profile-img" class="profile-img" />
            <div id="overlay-button">Change</div>
          </div>
          <input style="display: none" type="file" name="profileUpload" id="profileUpload" />
        </label>

        <span class="name-placeholder">Alen Pariyar</span>
        <span class="dim-label">
          `A curious guy who experiments with ${code}.`
        </span>
        <hr class="label-underline" />

        <div style="
              display: flex;
              height: 40px;
              margin: 10px;
              justify-content: space-around;
              width: 100%;
            ">
          <a class="mitra-request-control-btn">
            <img src="./assets/images/add-mitra.png" height="30px" alt="" />
            <span>Add Mitra</span>
          </a>
          <a class="mitra-request-control-btn" style="display: flex; justify-content: space-around">
            <i style="color: rgb(78, 78, 78)" class="fa-solid fa-message"></i>
            <span>Kurakani</span>
          </a>
          <a id="myBtn" class="mitra-request-control-btn" style="display: flex; justify-content: space-around">
            <i style="color: rgb(78, 78, 78)" class="fa-regular fa-pen-to-square"></i>
            <span>Edit Profile</span>
          </a>
          <!-- Trigger/Open The Modal -->

          <!-- The Modal -->
          <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
              <span class="close">&times;</span>
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
        </div>
        <hr class="label-underline" />
        <span class="dim-label"> Add Permanent Address </span>
        <span class="dim-label"> Add Temporary Address </span>
        <span class="dim-label"> Add Educational Institution </span>
        <span class="dim-label"> Select Gender </span>
      </div>
    </div>
    <?php include_once("./parts/rightSidebar.php") ?>
</body>
<script src="./assets/scripts/jquery.js"></script>
<script>
  let profileImg = document.getElementById("profile-img");
  let changeBtn = document.getElementById("overlay-button");
  changeBtn.style.opacity = 0;
  document
    .getElementById("profile-img-holder")
    .addEventListener("mouseenter", () => {
      profileImg.style.opacity = 0.5;
      changeBtn.style.opacity = 1;
      document.body.style.cursor = "pointer";
    });
  document
    .getElementById("profile-img-holder")
    .addEventListener("mouseleave", () => {
      profileImg.style.opacity = 1;
      changeBtn.style.opacity = 0;
      document.body.style.cursor = "default";
    });

  document
    .getElementById("profile-img-holder")
    .addEventListener("click", () => {
      let formData = new FormData();
      let profileImg = $("#profileUpload")[0].files[0];

      if (profileImg) {
        formData.append("file", profileImg);

        $.ajax({
          url: "testFile.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            let success =
              '<div class="label-success">Profile updated successfully.</div>';
            let profileDiv = document.querySelectorAll(".inner-mid-body")[0];
            profileDiv.innerHTML = success + profileDiv.innerHTML;
          },
          error: function(xhr, status, error) {
            let failure =
              '<div class="label-failure">Unable to update profile.</div>';
            let profileDiv = document.querySelectorAll(".inner-mid-body")[0];
            profileDiv.innerHTML = failure + profileDiv.innerHTML;
          },
        });
      } else {
        console.error("No file selected.");
      }
    });

  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks on the button, open the modal
  btn.onclick = function() {
    modal.style.display = "block";
  };

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  };

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };


  let form = document.getElementById("profile-update-form");
  form.addEventListener("submit",(e)=>{
    e.preventDefault();
    let formError = document.getElementById("")
    let formData = new FormData(form);
    console.log(formData);

    const userData = {
      fname : formData.get("fname"),
      lname : formData.get("lname"),
      bio : formData.get("bio"),
      gender : formData.get("gender"),
      p_address : formData.get("p_address"),
      t_address : formData.get("t_address"),
      academic_institution : formData.get("academic_institution")
    }

    console.log(document.getElementsByTagName("label"));


    console.log(userData);
    form.reset(); 
  })

  // Update form elements
  let fname =document.getElementById("fname");
  let lname =document.getElementById("lname");
  let bio =document.getElementById("bio");

  // Error text label
  let fname_error = document.getElementById("fname-error");
  let lname_error = document.getElementById("lname-error");
  let bio_error = document.getElementById("bio-error");


  //text length count
  let fname_label =document.getElementById("fname-count");
  let lname_label =document.getElementById("lname-count");
  let bio_label =document.getElementById("bio-count");

  // Error Flag
  let hasError = false;

  const formInputFields = [[fname,fname_label,15, fname_error, 3], [lname,lname_label,15, lname_error, 3], [bio,bio_label,150, bio_error, 0]];

  fname_label.innerText = fname.value.length;
  lname_label.innerText = lname.value.length;
  bio_label.innerText = bio.value.length;

  formInputFields.forEach((item)=>{
    item[0].addEventListener("keyup",()=>{
      item[1].innerText = item[0].value.length;
      let nameRule = new RegExp(`^[a-z A-Z]{${item[4]},${item[2]}}$`);

      if(!nameRule.test(item[0].value))
      {
        hasError = true;
        item[3].innerText = "- Invalid name";
        console.log("hello");
      }else{
        item[3].innerText = "";
        hasError = false;
      }
      
    })
    
  })

</script>

</html>