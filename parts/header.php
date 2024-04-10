<?php
    include_once("../server/db_connection.php");

    $getSystemColor = "SELECT * FROM `system_data` WHERE 1";
    $result = mysqli_query($connection, $getSystemColor);

    $result = mysqli_fetch_assoc($result);
    $data = json_decode($result['themeSpecification'], true);

    // ALEN : primaryColor, secondaryColor, ThemeBgColor

?>

<style>
:root{
    --mp-primary : <?php echo $data['primaryColor']; ?>;
    --mp-secondary : <?php echo $data['secondaryColor']; ?>;
    --mp-theme-bg : <?php echo $data['ThemeBgColor']; ?>;
}

* {
    margin: 0px;
    font-family: 'poppins';
    color: rgb(0, 0, 0);
}

body{
    background-color: var(--mp-theme-bg);
    color: white;

}

#profile-info-uname {
    text-align: center;
    font-weight: bold;
    
}

.profile-info{
    display: flex;
    flex-direction: column;
}

#user-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: var(--mp-primary);
    position: relative;
    box-shadow: 0.1px 0.1px 1px 0.2px white;
}



#nav-profile-img
{
    cursor: pointer;
}

#user-nav .center-part {
    width: 40vw;
    display: flex;
    justify-content: space-around;
    font-size: 25pt;
}

#user-nav .right-part img {
    height: 3rem;
}

#user-nav .center-part a {
    padding: 5px;
    height: 100%;
    width: 100%;
    text-align: center;
    color: var(--mp-secondary);
    border-top: 5px solid var(--mp-primary);
    border-bottom: 5px solid var(--mp-primary);
}

#user-nav .center-part a i{
    
    color: var(--mp-secondary);
}

#user-nav .center-part a:hover {
    background-color: rgba(115, 115, 115, 0.215);
    color: var(--mp-secondary);
  

}

#user-nav .center-part .active{
    color: var(--mp-secondary);
    border-bottom: 5px solid var(--mp-secondary);
    border-top: 5px solid var(--mp-secondary);

    background-color: #49494947;

}

#user-nav .right-part {
    margin-right: 10px;
}

#user-nav .left-part {
    margin-left: 10px;
}

#user-nav .right-part .profile-img {
    border-radius: 50%;

}


#user-nav .left-part .navbar-title {
    font-family: 'poppins';
    color: white;
    font-weight: bold;
    font-size: x-large;
}

.profile-menu {
    display: flex;
    flex-direction: column;
    width: 25%;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0.5px 0.5px 9px 0.5px rgb(148, 148, 148);
    position: absolute;
    top: 10%;
    left: 72%;
}



.image-holder {
    display: flex;
    justify-content: center;
    width: 100%;
   
}

#profile-menu{
    display: none;
    background-color: rgba(255, 255, 255, 0.916);
}

.nav-icon{
    position: relative;
}

.post-upload-image{
    height: 70px;
    margin-left: 8px;
    border-radius: 5px;
    
}
.inner-post-image-holder
{
    position: relative;

    width: fit-content;
}


#remove-post-image{
    top: 0;
    left: 90%;
    width: 9px;
    height: 9px;
    background-color: #c0c0c0;
    padding: 3px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.5;
    position: absolute;
    cursor: pointer;
}

#remove-post-image:hover{
    background-color: #ffffff;
}

.nav-icon::after{
    font-family: "poppins";
    content: attr(current-count);
    position: absolute;
    font-size: x-small;
    background-color: rgb(255, 46, 46);
    height: 16px;
    width: 16px;
    text-align: center;
    border-radius: 50%;
    top: -10%;
    right: -20%;
    border: 3px solid black;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-weight: bold; 
}

a{
    text-decoration: none;
}

.nav-icon{
    position: relative;
}

.notification-count{
    position: fixed;
}

.profile-menu-item:hover{
    background-color: #cecece;
    border-radius: 2px;
}
.profile-menu-item{
    width: 100%;
    padding: 3px;
    margin: 2px;
    text-align: center;
    color: #111111;

}

body{
    height: 100vh;
    overflow: hidden;
}

.main-body{
    display: flex;
    justify-content: space-between;
    height: 100%;

}

.left-sidebar{
    width: 26%;

    background-color: var(--mp-theme-bg);
}

.mid-body{
    background-color: var(--mp-theme-bg);
    width: 70%;
    height: 100vh;
}


 
::-webkit-scrollbar{
    width: 2px;
}

.right-sidebar{
    width: 26%;
    background-color: var(--mp-theme-bg);
}

.mid-body{
    display: flex;
    flex-direction: column;
    align-items: center;
    
}


#popup-upload-post
{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 40%;
    border-radius: 20px;
    background-color: var(--mp-theme-bg);
    box-shadow: 0px 0px 20px 1px #fffbfb66;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.modal-popup-head{
    margin-top: -50px;

    align-items: center;
}

.post-uploader{
    height: 100%;
    width: 100%;
    padding: 30px 0px 10px 0px;
}

.row-upload-controls {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    
}

.row-upload-controls > *{
    background-color: #8F90FB;
    color: white;
    height: 30px;
    border-radius: 3px;
    border: none;
    padding: 3px;
    width: 30%;
    cursor: pointer;
    font-weight: bold;
}

.post-uploader-head{
    color: white;
    text-align: center;
    margin-top: -30px;
}

.section-break-hr{
    border: 0.5px solid #7c7c7c67;
}

.row-caption-container{
    padding: 8px;
    margin: 5px;
    border-radius: 5px;
    background-color: #bbbbbb41;
    color: white;
}

.row-upload-controls > *:hover{

}

#post-caption{
    width: 100%;
    height: 100%;
    resize: none;
    outline: none;
    background-color: transparent;
    border: none;
    color: white;
    font-size: medium;
}

.active{

}




@media only screen and (max-width:600px) {
    .profile-menu {
        top: 10%;
        left: 66%;
    }

    #user-nav .left-part .navbar-title {
        font-family: 'poppins';
        color: white;
        font-weight: bold;
        font-size: x-large;
    }

    .right-sidebar{
        display: none;
    }
    .left-sidebar{
        display: none;
    }
    #mid-body{
        width: 100%;
    }

    #popup-upload-post{
        width: 80%;
    }
}

</style>