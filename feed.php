<?php

include_once('./parts/entryCheck.php');
include_once('./server/db_connection.php');
include_once('./server/validation.php');
include_once('./server/functions.php');


$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
include_once("./server/auto-routes.php");
?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <?php include_once("./parts/header-links.php"); ?>
    <title>Feed -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <link rel="stylesheet" href="./assets/parts/global-css/style.css">
    <link rel="stylesheet" href="./assets/css/profile.css">

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
            border: 1px solid black;
            padding: 2px;
            border-radius: 5px;
        }



        .comment-inp button {
            padding: 0px 5px 0px 5px;
            border: none;
            background-color: white;
        }

        .comment-inp input {
            width: 100%;
            border: none;
            outline: none;
        }

        .comment-inp input:focus {
            outline: none;
        }


        .post-comment-inp {
            height: 30px;
            margin: 1px;
            border: 1px solid grey;
        }

        .post-comment {
            height: 30px;
        }

        #post-container {
            width: 100%;
        }



        #modal-wrapper {

            background: rgba(0, 0, 0, 0.7);
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: none;
        }

        #closeModal {
            top: 0;
            left: 98%;
            width: 9px;
            height: 9px;
            background-color: red;
            padding: 10px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.5;
            position: absolute;
            cursor: pointer;
        }

        #mid-body {
            width: 35%;
            height: 90vh;
        }

        .post-image-holder{
            display: none;
        }
    </style>
    <?php include_once("../MitraPark/assets/css/dynamicColor.php"); ?>
    <link rel="stylesheet" href="./assets/css/navbar.css">

    <?php echo "<script>localStorage.setItem('mp-uid','" . $_SESSION['user']['uid'] . "')</script>"; ?>

</head>

<body>


    <?php
    include_once("./parts/navbar.php");

    include_once("./parts/leftSidebar.php");

    include_once("./parts/feed-midbody.php");
    ?>

    <?php
    include_once("./parts/rightSidebar.php");
    ?>
    <script src='./assets/scripts/jquery.js'></script>

    <?php
    if($_SERVER['REQUEST_METHOD']==="GET")
    {
       
        if(isset($_GET['invalid-post-file-type']))
        {
            echo "<script>alert('Unable to upload file. Make sure you only upload valid image files.');window.location.href = 'feed.php';</script>";
        }if(isset($_GET['invalid-post-null']))
        {
            echo "<script>alert('Unable to upload post. Make sure you have uploaded images or text content.');window.location.href = 'feed.php';</script>";
        }
    }
    ?>

    <script>
        $("#post-upload-file").change((event) => {
            const file = event.target.files[0];
            if (file) {
                const imgUrl = URL.createObjectURL(file);
                const maxSizeInBytes = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSizeInBytes) {
                    alert("The selected file is too large. Please select a file smaller than 5MB.");
                    $("#post-share-btn").prop('disabled', true);
                }else{
                    $("#post-share-btn").prop('disabled', false);
                    $("#selected-post-img").attr("src", imgUrl);
                    $(".post-image-holder")[0].style.display = "block";
      
                }
                
                
              
            }
        });

        $("#remove-post-image").click(()=>{
            $("#selected-post-img").attr("src", null);
            $(".post-image-holder")[0].style.display = "none";
        })

        $("#post-text").click(() => {
            
            $("#modal-wrapper").slideDown();
            if($("#selected-post-img").attr("src") || $("#post-caption")[0].value.length > 0)
            {
                $("#post-share-btn").prop('disabled', false);
            }else{
                $("#post-share-btn").prop('disabled', true);
            }
        
        });

        

        let postTestCaption = false;
        let postTestImage = false;

        function checkUploadBtn()
        {
            if(postTestCaption || postTestImage)
            {
                $("#post-share-btn").prop('disabled', false);
            }else{
                $("#post-share-btn").prop('disabled', true);
            }
        }

        document.getElementById("post-caption").addEventListener("keyup", ()=>{
            if(document.getElementById("post-caption").value.length > 0)
            {
                postTestCaption = true;
            }else{
                postTestCaption = false;
            }
            checkUploadBtn();
        });

        
        document.getElementById("post-upload-file").addEventListener("change", ()=>{
            // console.log(document.getElementById("selected-post-img").getAttribute("src"));
            if(document.getElementById("selected-post-img").getAttribute("src"))
            {
                postTestImage = true;
            }else{
                postTestCaption = false;
            }
            checkUploadBtn();
        })

        document.getElementById("remove-post-image").addEventListener("click",()=>{
            postTestImage = false;
            checkUploadBtn();
        })



        let modalWrapper = document.getElementById("modal-wrapper");
        let closeModal = document.getElementById("closeModal");
        closeModal.addEventListener("click", () => {
            $("#modal-wrapper").slideUp();
        });


       
    </script>
    <script src='posts.js'></script>
    <?php
        include_once("./parts/js-script-files/js-script.php");
        
    ?>
<?php include_once("./parts/js-script-files/strict-and-activity-update.php"); ?>

</body>

</html>