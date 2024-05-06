<?php
var_dump($_POST);

if (isset($_POST)) {

    include_once("../db_connection.php");
    $text = htmlspecialchars($_POST['caption']);
    $visibility = htmlspecialchars($_POST['visibility']);
    $img = NULL;
    $validVisibility = false;
    $validPostText = false;
    $validImg = false;
    $validFile = false;
    $postId = $_POST['postId'];
    
    var_dump($_FILES['file']);
 
    if ($_FILES['file']['size']>0) {

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
            $newFileName = '/user_uploads/' . $newName;
        }
    }else{
        echo "no file";
    }

    $allowedVisibile = array("public", "private", "mitras");

    if (array_search($visibility, $allowedVisibile) !== FALSE) {
        $validVisibility = true;
    }

    if ((strlen($text) > 0 || $img != NULL) && $validVisibility) {
        if (!isset($_SESSION)) {
            session_start();
        }


        $uid = $_SESSION['user']['uid'];

        if($_POST['file-operation']=="delete")
        {
            $updateProfileQuery = "UPDATE `posts` SET `content`='$text',`media`=null,`visibility`='$visibility' WHERE `author_id`='$uid' AND `post_id`='$postId'";
            
        }else{
            if(isset($newFileName))
            {
                $updateProfileQuery = "UPDATE `posts` SET `content`='$text',`media`='$newFileName',`visibility`='$visibility' WHERE `author_id`='$uid' AND `post_id`='$postId'";
            }else{
                $updateProfileQuery = "UPDATE `posts` SET `content`='$text', `visibility`='$visibility' WHERE `author_id`='$uid' AND `post_id`='$postId'";
            }
        }
       
        

        mysqli_query($connection, $updateProfileQuery);


        header("Location: ../../post.php?postId=".$postId);
        
    } else {
        header("Location: ../../feed.php");
    }
}
?>