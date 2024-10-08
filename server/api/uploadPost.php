<?php

if (isset($_POST)) {
    
    include_once("../db_connection.php");
    $text = htmlspecialchars($_POST['post-text']);
    $visibility = htmlspecialchars($_POST['visibile-mode']);
    $img = NULL;
    $validVisibility = false;
    $validPostText = false;
    $validImg = false;
    $validFile = false;
    if(isset($_FILES['file']) ||  strlen($text)>0)
    {

    if (isset($_FILES['file'])) {
        $img = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTempName = $_FILES['file']['tmp_name'];
        $path = "../../user_uploads/";

        $validFileType = array("jpg", "jpeg", "png");
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $validFileType)) {
            $validFile = true;
            $newName = uniqid() . "." . $fileExtension;
            move_uploaded_file($fileTempName, $path . $newName);
            $_GLOBALS['fileName'] = '/user_uploads/' . $newName;
        } else {
            header("Location: ../../feed.php?invalid-post-file-type");
            exit();
        }
    }

    $allowedVisibile = array("public", "private", "mitras");

    if (array_search($visibility, $allowedVisibile) !== FALSE) {
        $validVisibility = true;
    }

    if ((strlen($text) > 0 || $img != NULL) && $validVisibility) {
        if (!isset($_SESSION)) {
            session_start();
        }

        $dateTime = Date("Y-m-d H-i-s");

        $uid = $_SESSION['user']['uid'];
        $filePath = $_GLOBALS['fileName'];
        $insertPostQuery = "INSERT INTO `posts`(`content`, `author_id`, `created_date_time`, `media`, `visibility`) VALUES ('$text','$uid','$dateTime','$filePath','$visibility')";
        $connection->query($insertPostQuery);
        header("Location: ../../feed.php");
        
    } else {
        header("Location: ../../feed.php");
    }
}
}else{
    header("Location: ../../feed.php?invalid-post-null");
}
?>