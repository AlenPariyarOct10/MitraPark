<?php 

    var_dump($_POST);
    var_dump($_FILES);

// /MitraPark/assets/images/mitrapark.png
// if (isset($_POST)) {

//     include_once("../db_connection.php");

//     $validImg = false;
//     $validFile = false;

//     if (isset($_FILES['file'])) {
//         $img = $_FILES['file'];
//         $fileName = $_FILES['file']['name'];
//         $fileTempName = $_FILES['file']['tmp_name'];
//         $path = "../../assets/images/";

//         $validFileType = array("jpg", "jpeg", "png");
//         $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

//         if (in_array($fileExtension, $validFileType)) {
//             $validFile = true;
//             $newName = uniqid() . "." . $fileExtension;
//             move_uploaded_file($fileTempName, $path . $newName);
//             $_GLOBALS['fileName'] = '/user_uploads/' . $newName;

//             $updateSystemLogo = 
//         } else {
           
//         }
//     }


//     if ((strlen($text) > 0 || $img != NULL) && $validVisibility) {
//         if (!isset($_SESSION)) {
//             session_start();
//         }


//         $uid = $_SESSION['user']['uid'];
//         $filePath = $_GLOBALS['fileName'];
//         $insertPostQuery = "INSERT INTO `posts`(`content`, `author_id`, `created_date_time`, `media`, `visibility`) VALUES ('$text','$uid',now(),'$filePath','$visibility')";
//         $connection->query($insertPostQuery);
//         header("Location: ../../feed.php");
        
//     } else {
//         header("Location: ../../feed.php");
//     }
// }

?>